<?php

class BcclistTableSeeder extends Seeder {

    public function run() {

        Bcclist::create ( array (
                'bcc_id' => '111911364852842467336_adobe',
                'email' => 'Suresh1317@iiitd.ac.in'
        ) );
        
        Bcclist::create ( array (
                'bcc_id' => '111911364852842467336_adobe',
                'email' => 'jeevan1336@iiitd.ac.in'
        ) );
        
        Bcclist::create ( array (
                'bcc_id' => '111911364852842467336_amazon',
                'email' => 'Suresh1317@iiitd.ac.in'
        ) );
        
        Bcclist::create ( array (
                'bcc_id' => '111911364852842467336_amazon',
                'email' => 'jeevan1336@iiitd.ac.in'
        ) );
    
    }

}