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
                'status' => 'sent'
            ) );

            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'adobe',
                'status' => 'failed'
            ) );

            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'hike',
                'status' => 'sent'
            ) );

        }
    }