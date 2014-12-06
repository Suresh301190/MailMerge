<?php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\View;

    class Email
    {

        const HTML_HEADER = '<!DOCTYPE html>
        <html lang="en-US">
	        <head>
		        <meta charset="utf-8">
	        </head>
	        <body>';

        const HTML_FOOTER = '</body></html>';

        private static $delay = 10;

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
            $data = Input::all();
            $data['groupsByStatus'] = Group::getAllGroupsByStatus();
            $data['success'] = false;
            $state = null;

            // To check if all group are from one status
            if ( !$state = self::onlyOneStatusSelected( $data ) ) {
                $data['message'] = 'Please select only one state [' . implode( ",", Group::getStatesArray() ) . ']';
                $data['success'] = false;
            } // To check if at least one group was selected
            else if ( !$data['success'] ) {
                $data['message'] = 'Please select at least 1 Recipient';
            } // To validate content
            else if ( !Template::validate( $data['content'], $data['contains'] ) ) {
                $data['message'] = "The template doesn't Contain all the selected patterns [" . implode( ',', $data['contains'] ) . "]";
                $data['success'] = false;

            } // To check if subject line is empty
            else if ( $data['subject'] == '' ) {
                $data['message'] = ' **Subject missing** ';
                $data['success'] = false;
            } else {
                $data['message'] = 'Mailing Recipients [' . implode( ",", $data["$state"] ) . ']';

                $from = Auth::user()->email;
                $name = Auth::user()->name;
                $subject = $data['subject'];

                $delay = self::$delay;


                foreach ( $data["$state"] as $group ) {
                    $content = array();
                    $content['content'] = self::makeContent( $data['content'], Group::getReplaceValues( $group )[0] );
                    $to = Tolist::getMails( array( $group ) );
                    $cc = Cclist::getMails( array( $group ) );
                    $bcc = Bcclist::getMails( array( $group ) );

                    self::sendOneMail( $delay, $from, $name, $subject, $content, $to, $cc, $bcc );
                    $delay += self::$delay;
                }
            }

            $data['data'] = array_merge( $data );

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
         * Send a Mail with the following parameters
         *
         * @param  int $delay Delay between Mails
         * @param string $from        sender's address
         * @param string $name        Name of the sender
         * @param string $subject     Subject of the mail
         * @param string $content     body of the message
         * @param array  $to          list of recipients in to field
         * @param array  $cc          list of recipients in to field
         * @param array  $bcc         list of recipients in to field
         * @param array  $attachments names of the attachments
         * @param string $ccAdmin     CC admin-placements@iiitd.ac.in
         * @param string $ccSCP       CC scp@iiitd.ac.in
         */
        private static function sendOneMail( $delay, $from, $name, $subject, $content, $to, $cc, $bcc, $attachments = array(), $ccAdmin = '', $ccSCP = '' )
        {
            Mail::later( $delay, 'emails.generic-mail', $content,
                function ( $message ) use ( $from, $name, $subject, $attachments, $to, $cc, $bcc ) {

                    $message->from( $from, $name )->subject( $subject );

                    /*
                    if ( '' != $ccAdmin )
                        $message->cc( $ccAdmin );
                    if ( '' != $ccSCP )
                        $message->cc( $ccSCP );
                    */


                    foreach ( $to as $row ) {
                        $message->to( $row['email'] );
                    }

                    foreach ( $cc as $row ) {
                        $message->cc( $row['email'] );
                    }

                    foreach ( $bcc as $row ) {
                        $message->bcc( $row['email'] );
                    }

                } );
        }
    }


?>