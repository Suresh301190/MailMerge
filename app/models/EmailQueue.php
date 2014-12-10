<?php
    use Illuminate\Support\Facades\Log;

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 09-Dec-14
     * Time: 12:07 AM
     */
    class EmailQueue
    {

        /**
         * Queue a Mail to send later with the following parameters
         *
         * @param       $job
         * @param array $data a lot of data
         *
         * @internal param string   $name           Name of the sender
         * @internal param string   $subject        Subject of the mail
         * @internal param string   $content        body of the message
         * @internal param array    $to             list of recipients in to field
         * @internal param array    $cc             list of recipients in to field
         * @internal param array    $bcc            list of recipients in to field
         * @internal param array    $attachments    names of the attachments
         * @internal param bool     $ccAdmin        CC admin-placements@iiitd.ac.in
         * @internal param bool     $ccSCP          CC scp@iiitd.ac.in
         * @internal param string   $UID            User id of the user
         * @internal param string   $state          current state of the email group
         * @internal param string   $group          group name of the mailing list
         */
        public function fire( $job, $data )
        {
            // check if job failed the first time
            if ( $job->attempts() > 1 ) {
                $job->delete();
            }// execute the job
            else {

                $sent = false;
                try {
                    $from = $data['from'];
                    $name = $data['name'];
                    $subject = $data['subject'];
                    $content = $data['content'];
                    $to = $data['to'];
                    $cc = $data['cc'];
                    $bcc = $data['bcc'];
                    $attachments = $data['attachments'];
                    $ccAdmin = $data['ccAdmin'];
                    $ccSCP = $data['ccSCP'];

                    //Log::debug( $data );

                    // send the mail
                    Mail::send( 'emails.generic-mail', $content,
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

                    //Log::debug( '@Suresh Message Sent' );
                    $sent = true;

                    // add the status to the sent_mails table
                    SentMail::addOrUpdateRow( $data['uid'], $data['group'], 'sent' );

                    //Log::debug( '@Suresh sent_mails table updated' );

                    // Update the state of group
                    Group::updateState( $data['uid'], $data['group'], $data['state'], 7 );

                    //Log::debug( '@Suresh Group state updated' );

                } catch ( Exception $e ) {
                    Log::error( $e );
                }

                if ( !$sent ) {
                    SentMail::addOrUpdateRow( $data['uid'], $data['group'], 'failed' );
                }

                $job->delete();
            }
        }
    }