<?php

    use Carbon\Carbon;

    class GroupTableSeeder extends Seeder
    {

        public function run()
        {

            Group::create( array(
                'gid'      => '111911364852842467336',
                'gname'    => 'adobe',
                'gid_name' => '111911364852842467336_adobe',
                'hr_name'  => 'Akashra',
                'company'  => 'Adobe Noida',
                'state'    => 'invite',
                'reminder' => Carbon::now(),
            ) );

            Group::create( array(
                'gid'      => '111911364852842467336',
                'gname'    => 'amazon',
                'gid_name' => '111911364852842467336_amazon',
                'hr_name'  => 'Simi',
                'company'  => 'Amazon India',
                'state'    => 'invite',
                'reminder' => Carbon::now(),
            ) );

            Group::create( array(
                'gid'      => '111911364852842467336',
                'gname'    => 'xerox',
                'gid_name' => '111911364852842467336_xerox',
                'hr_name'  => 'Kuldeep',
                'company'  => 'Xerox Research India',
                'state'    => 'follow',
                'reminder' => Carbon::now()->addDays( 4 ),
            ) );

            Group::create( array(
                'gid'      => '111911364852842467336',
                'gname'    => 'Hike',
                'gid_name' => '111911364852842467336_hike',
                'hr_name'  => 'Adaya',
                'company'  => 'Hike Messenger',
                'state'    => 'confirm',
                'reminder' => Carbon::now()->subDays( 2 ),
            ) );

        }

    }