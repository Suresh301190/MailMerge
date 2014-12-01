<?php

class GroupTableSeeder extends Seeder {

    public function run() {

        Group::create ( array (
                'gid' => '111911364852842467336',
                'gname' => 'adobe',
                'gid_name' => '111911364852842467336_adobe',
                'hr_name' => 'Akashra',
                'company' => 'Adobe Noida',
                'state' => 'invite'
        ) );
        
        Group::create ( array (
                'gid' => '111911364852842467336',
                'gname' => 'amazon',
                'gid_name' => '111911364852842467336_amazon',
                'hr_name' => 'Simi',
                'company' => 'Amazon India',
                'state' => 'invite'
        ) );
        
        Group::create ( array (
                'gid' => '111911364852842467336',
                'gname' => 'xerox',
                'gid_name' => '111911364852842467336_xerox',
                'hr_name' => 'Kuldeep',
                'company' => 'Xerox Research India' ,
                'state' => 'inviteSent'
        ) );
    
    }

}