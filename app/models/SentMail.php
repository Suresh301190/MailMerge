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
     * @property string uid     User id
     * @property string gname   group name
     * @property enum   $status ['sending', 'sent', 'failed']
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
         * @param string $status default is 'sending'
         *
         * @internal param string $mail_id
         */
        public static function addOrUpdateRow( $uid, $gname, $status = '' )
        {
            if ( $status == '' ) {
                $sent = new SentMail();
                $sent->status = 'sending';
                $sent->gname = $gname;
                $sent->uid = $uid;
                $sent->save();
            } else {
                DB::table( 'sent_mails' )
                    ->where( 'uid', '=', $uid )
                    ->where( 'gname', '=', $gname )
                    ->update( array( 'status' => $status ) );
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

            $mails = SentMail::select( array( 'gname', 'status' ) )
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

    }