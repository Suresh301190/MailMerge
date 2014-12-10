<?php

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 08-Dec-14
     * Time: 9:04 PM
     */
    class SentMailTableSeeder extends Seeder
    {

        public function run()
        {

            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'xerox',
                'status' => 'sent',
                'type'   => 'invite'
            ) );

            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'adobe',
                'status' => 'failed',
                'type'   => 'invite'
            ) );

            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'hike',
                'status' => 'sent',
                'type'   => 'follow'
            ) );

            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'flipkart',
                'status' => 'sent',
                'type'   => 'confirm'
            ) );

        }
    }