<?php
    use Carbon\Carbon;

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

            // Xerox invite sent
            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'xerox',
                'status' => 'sent',
                'type'       => 'invite',
                'updated_at' => Carbon::now()->subDays( 2 ),
                'created_at' => Carbon::now()->subDays( 2 )->subSeconds( 1000 ),
            ) );

            // adobe invite failed
            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'adobe',
                'status' => 'failed',
                'type'       => 'invite',
                'updated_at' => Carbon::now()->subDays( 2 ),
                'created_at' => Carbon::now()->subDays( 2 )->subSeconds( 350 ),
            ) );

            // Hike followed
            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'hike',
                'status' => 'sent',
                'type'       => 'invite',
                'updated_at' => Carbon::now()->subDays( 10 ),
                'created_at' => Carbon::now()->subDays( 10 )->subSecond( 300 ),
            ) );

            SentMail::create( array(
                'uid'        => '111911364852842467336',
                'gname'      => 'hike',
                'status'     => 'sent',
                'type'       => 'follow',
                'updated_at' => Carbon::now()->subDays( 3 ),
                'created_at' => Carbon::now()->subDays( 3 )->subSecond( 600 ),

            ) );

            // flipkart confirmed
            SentMail::create( array(
                'uid'        => '111911364852842467336',
                'gname'      => 'flipkart',
                'status'     => 'sent',
                'type'       => 'invite',
                'updated_at' => Carbon::now()->subDays( 12 ),
                'created_at' => Carbon::now()->subDays( 13 )->subSecond( 600 ),
            ) );

            SentMail::create( array(
                'uid'        => '111911364852842467336',
                'gname'      => 'flipkart',
                'status'     => 'sent',
                'type'       => 'follow',
                'updated_at' => Carbon::now()->subDays( 5 ),
                'created_at' => Carbon::now()->subDays( 5 )->subSecond( 600 ),
            ) );

            SentMail::create( array(
                'uid'    => '111911364852842467336',
                'gname'  => 'flipkart',
                'status' => 'sent',
                'type'       => 'confirm',
                'updated_at' => Carbon::now()->subDays( 1 ),
                'created_at' => Carbon::now()->subDays( 1 )->subSecond( 600 ),
            ) );

        }
    }