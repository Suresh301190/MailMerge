<?php

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 08-Dec-14
     * Time: 9:06 PM
     */
    use Carbon\Carbon;

    /**
     * Class SentMail
     *
     * @property string   uid        User id
     * @property string   gname      group name
     * @property enum     status     ['sending', 'sent', 'failed']
     * @property enum     type       ['invite', 'follow', 'confirm']
     * @property dateTime updated_at time when the record was updated
     */
    class SentMail extends Eloquent
    {

        protected $table = 'sent_mails';

        public $timestamps = true;

        public $incrementing = false;

        protected $primaryKey = array( 'uid', 'gname', 'status' );

        private static $status = array(
            'sending', 'sent', 'failed'
        );

        /**
         * To add or update an existing entry an entry
         *
         * @param string $uid    user ID
         * @param string $gname  group name to update
         * @param string $type type of the message
         * @param string $status default is 'sending'
         *
         * @internal param string $mail_id
         */
        public static function addOrUpdateRow( $uid, $gname, $type, $status = '' )
        {
            if ( $status == '' ) {
                SentMail::where( 'uid', '=', $uid )
                    ->where( 'gname', '=', $gname )
                    ->where( 'type', '=', $type )
                    ->delete();

                $sent = new SentMail();
                $sent->uid = $uid;
                $sent->gname = $gname;
                $sent->type = $type;
                $sent->status = 'sending';
                $sent->save();

            } else if ( $status != '' ) {
                DB::table( 'sent_mails' )
                    ->where( 'uid', '=', $uid )
                    ->where( 'gname', '=', $gname )
                    ->where( 'type', '=', $type )
                    ->update( array(
                        'status'     => $status,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ) );
            }
        }

        /**
         * Get the mails by status i.e. sending, sent or failed
         *
         * @param string $status
         * @param int    $lastXDays
         *
         * @return array $mails
         */
        public static function getMailByStatus( $status, $lastXDays = 180 )
        {
            // To check if status is valid
            if ( !in_array( $status, self::$status ) )
                return array();

            $mails = SentMail::select( array( 'gname', 'status', 'type' ) )
                ->where( 'uid', '=', User::getUID() )
                ->where( 'status', '=', $status )
                ->where( 'updated_at', '>=', Carbon::now()->subDays( $lastXDays )->toDateTimeString() )
                ->get()
                ->toArray();

            return $mails;
        }

        /**
         * Get all mails grouped by status
         *
         * @param int $lastXDays
         *
         * @return array $mailByStatus
         */
        public static function getAllMailByStatus( $lastXDays = 180 )
        {
            $mailByStatus = array();

            foreach ( self::$status as $s ) {
                $mailByStatus["$s"] = self::getMailByStatus( $s, $lastXDays );
            }

            return $mailByStatus;
        }

        /**
         * Get all the results sorted by update_at time for the last X days
         *
         * @param int $lastXDays default 3
         * @param int $take      default 10
         *
         * @return array $notifications
         */
        public static function getNotifications( $lastXDays = 7, $take = 10 )
        {
            $notification = SentMail::select( array( 'gname', 'status', 'type', 'updated_at' ) )
                ->where( 'uid', '=', User::getUID() )
                ->where( 'updated_at', '>=', Carbon::now()->subDays( $lastXDays )->toDateTimeString() )
                ->orderBy( 'updated_at', 'desc' )
                ->take( $take )
                ->get()
                ->toArray();

            return $notification;
        }

        private static $stateToMessage = array(
            'invite'  => 'invite ',
            'follow'  => 'follow up ',
            'confirm' => 'confirmation '
        );

        /**
         * Get the Cleaned Notifications to be displayed on the dashboard
         *
         * @param int $lastXDays How far to search
         * @param int $take      How many results to take
         *
         * @return array ['message', 'type', 'timestamp']
         */
        public static function getCleanedNotifications( $lastXDays = 7, $take = 10 )
        {
            $notifications = SentMail::getNotifications( $lastXDays, $take );
            $ret = array();

            foreach ( $notifications as $mail ) {
                $row = array();

                // sent status
                if ( strcmp( $mail['status'], 'sent' ) == 0 ) {
                    $row['message'] = self::$stateToMessage[ $mail['type'] ] . 'sent to ' . $mail['gname'];
                    $row['type'] = 1;
                } // failed status
                elseif ( strcmp( $mail['status'], 'failed' ) == 0 ) {
                    $row['message'] = self::$stateToMessage[ $mail['type'] ] . 'to ' . $mail['gname'] . ' failed';
                    $row['type'] = 2;
                } // Sending status
                else {
                    $row['message'] = 'sending ' . self::$stateToMessage[ $mail['type'] ] . 'to ' . $mail['gname'];
                    $row['type'] = 0;
                }

                $row['time'] = Carbon::createFromFormat( 'Y-m-d H:i:s', $mail['updated_at'] )->diffForHumans( Carbon::now() );
                array_push( $ret, $row );
            }

            return $ret;

        }

    }