<?php

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 08-Dec-14
     * Time: 9:06 PM
     */

    /**
     * Class SentMail
     *
     * @property string uid
     * @property string gname
     * @property bool   failed
     */
    class SentMail extends Eloquent
    {

        protected $table = 'sent_mails';

        public $timestamps = true;

        public $incrementing = false;

        protected $primaryKey = 'mail_id';

        /**
         * To add an entry
         *
         * @param string $uid
         * @param string $gname
         * @param bool   $failed
         *
         * @internal param string $mail_id
         */
        public static function addRow( $uid, $gname, $failed )
        {
            $sent = new SentMail();
            $sent->failed = $failed;
            $sent->gname = $gname;
            $sent->uid = $uid;
            $sent->save();
        }


    }