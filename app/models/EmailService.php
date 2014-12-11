<?php

    use Carbon\Carbon;

    class EmailService
    {

        const HTML_HEADER = '<!DOCTYPE html>
        <html lang="en-US">
	        <head>
		        <meta charset="utf-8">
	        </head>
	        <body>';

        const HTML_FOOTER = '</body></html>';

        private static $delay = 15;

        /**
         * To Set the delay between consecutive mails
         *
         * @param int $delay
         */
        public static function setDelay( $delay )
        {
            self::$delay = $delay;
        }

        private static $mailingLists = array(
            'toList'  => 'to-List',
            'ccList'  => 'cc-List',
            'bccList' => 'bcc-List'
        );

        public static final function getMailingListArray()
        {
            return self::$mailingLists;
        }

        /**
         *
         * @return View dasdboard.send
         */
        public static function sendMails()
        {
            $data = array();
            try {
                $data = Input::all();
                $data['groupsByStatus'] = Group::getAllGroupsByStatus();
                $data['attachmentList'] = Attachment::getMailAttachmentsArray();
                $data['success'] = false;
                $state = null;

                // To check if all group are from one status
                if ( !$state = self::onlyOneStatusSelected( $data ) ) {
                    $data['message'] = 'Please select only one state [' . implode( ",", Group::getStatesArray() ) . ']';
                } // To check if at least one group was selected
                else if ( !$data['success'] ) {
                    $data['message'] = 'Please select at least 1 Recipient';
                } // To check if subject line is empty
                else if ( $data['subject'] == '' ) {
                    $data['message'] = ' **Subject missing** ';
                    $data['success'] = false;
                } // To validate content
                else if ( !Template::validate( $data['content'], $data['contains'] ) ) {
                    $data['message'] = "The template doesn't Contain all the selected patterns [" . implode( ',', $data['contains'] ) . "]";
                    $data['success'] = false;
                } // If all checks passes
                else {
                    $groups = $data["$state"];

                    // Check if all recipients is selected
                    if ( in_array( 'all', $data["$state"] ) ) {
                        $groups = Group::getAllGroupsByStatus()["$state"];
                    }

                    $data['message'] = 'Mailing Recipients [' . implode( ",", $groups ) . ']';

                    // get the email of the user currently logged-in
                    $from = Auth::user()->email;
                    $name = Auth::user()->name;

                    //set the subject
                    $subject = $data['subject'];

                    $toAttach = array();

                    // Process selected attachments
                    foreach ( Attachment::getAttachmentsArray() as $k => $v ) {
                        if ( isset( $data["$k"] ) ) {
                            $toAttach["$k"] = "$k";
                        }
                    }

                    // Get the Corresponding paths
                    $attachments = Attachment::getMailAttachmentsPaths( $toAttach );

                    // Get a temp dir to store the attachments as we send the mails later
                    $dir = Attachment::getTempDir();

                    // Process Uploaded attachments
                    for ( $i = 0; $i < 3; $i++ ) {
                        if ( isset( $data["attachment$i"] ) ) {
                            $ret = Attachment::saveMailAttachment( $dir, "attachment$i" );

                            // If attachment was saved successfully
                            if ( $ret['added'] ) {
                                array_push( $attachments, $ret['path'] );
                            } else {
                                return View::make( 'dashboard.send', $data );
                            }
                        }
                    }

                    $delay = self::$delay;

                    foreach ( $groups as $group ) {
                        $content = array();
                        $content['content'] = self::makeContent( $data['content'], Group::getReplaceValues( $group )[0] );

                        // get the mailing lists
                        $to = Tolist::getMails( array( $group ) );
                        $cc = Cclist::getMails( array( $group ) );
                        $bcc = Bcclist::getMails( array( $group ) );

                        // first method
                        /*
                        self::sendOneMail( $delay, $from, $name,
                            $subject, $content, $to, $cc, $bcc,
                            $attachments, isset( $data['ccAdmin'] ), isset( $data['ccSCP'] ) );

                        // */

                        // Second method via queues
                        $mailData = array();
                        $mailData['from'] = $from;
                        $mailData['name'] = $name;
                        $mailData['subject'] = $subject;
                        $mailData['content'] = $content;
                        $mailData['to'] = $to;
                        $mailData['cc'] = $cc;
                        $mailData['bcc'] = $bcc;
                        $mailData['attachments'] = $attachments;
                        $mailData['ccAdmin'] = isset( $data['ccAdmin'] );
                        $mailData['ccSCP'] = isset( $data['ccSCP'] );

                        // for DB update
                        $mailData['uid'] = User::getUID();
                        $mailData['group'] = $group;
                        $mailData['state'] = $state;

                        SentMail::addOrUpdateRow( $mailData['uid'], $group, $state );
                        Queue::later( Carbon::now()->addSeconds( $delay ), 'EmailQueue', $mailData );

                        // Increase Delay
                        $delay += self::$delay;
                    }
                }

                //Log::debug( $data );
            } catch ( Exception $e ) {
                Log::error( $e );
                $data['message'] = 'Internal Server Error Please try Again';
            }

            return View::make( 'dashboard.send', $data );
        }

        /**
         * To check if all the mails were from one state
         *
         * @param array $data all the Posted Data
         *
         * @return null|string $state which was found
         */
        private static function onlyOneStatusSelected( &$data )
        {
            $state = null;
            foreach ( Group::getStatesArray() as $states ) {
                if ( isset( $data["$states"] ) ) {
                    if ( $state != null )
                        return null;
                    $state = "$states";
                    $data['success'] = true;
                }
            }

            return $state;
        }

        /**
         * To make the contents unique to each mail by replacing the values in $replace (key => value) in the
         * $content
         *
         * @param string $content
         * @param array  $replace
         *
         * @return mixed
         */
        private static function makeContent( $content, $replace )
        {
            return str_replace( Template::getReplaceArray(), array_values( $replace ), $content );
        }

        /**
         * Queue a Mail to send later with the following parameters
         *
         * @param  int $delay   Delay between Mails
         * @param string $from        sender's address
         * @param string $name        Name of the sender
         * @param string $subject     Subject of the mail
         * @param string $content     body of the message
         * @param array  $to          list of recipients in to field
         * @param array  $cc          list of recipients in to field
         * @param array  $bcc         list of recipients in to field
         * @param array  $attachments names of the attachments
         * @param bool $ccAdmin CC admin-placements@iiitd.ac.in
         * @param bool $ccSCP   CC scp@iiitd.ac.in
         */
        public static function sendOneMail( $delay, $from, $name, $subject, $content, $to, $cc, $bcc, $attachments = array(), $ccAdmin = false, $ccSCP = false )
        {
            Mail::later( $delay, 'emails.generic-mail', $content,
                function ( $message ) use ( $from, $name, $subject, $attachments, $to, $cc, $bcc, $ccAdmin, $ccSCP ) {

                    $message->from( $from, $name )->subject( $subject );

                    if ( $ccAdmin )
                        $message->cc( 'admin-placement@iiitd.ac.in' );
                    if ( $ccSCP )
                        $message->cc( 'scp@iiitd.ac.in' );

                    // add the to list
                    foreach ( $to as $row ) {
                        $message->to( $row['email'] );
                    }
                    // add the cc list
                    foreach ( $cc as $row ) {
                        $message->cc( $row['email'] );
                    }
                    // add the bcc list
                    foreach ( $bcc as $row ) {
                        $message->bcc( $row['email'] );
                    }

                    // attach attachments
                    foreach ( $attachments as $pathToFile ) {
                        $message->attach( $pathToFile );
                    }

                } );
        }
    }

?>