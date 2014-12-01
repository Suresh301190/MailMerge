<?php

class CclistTableSeeder extends Seeder {

    public function run() {

        Cclist::create ( array (
                'cc_id' => '111911364852842467336_adobe',
                'email' => 'Geet11048@iiitd.ac.in'
        ) );
        
        Cclist::create ( array (
                'cc_id' => '111911364852842467336_adobe',
                'email' => 'Mehak11066@iiitd.ac.in'
        ) );
        
        Cclist::create ( array (
                'cc_id' => '111911364852842467336_amazon',
                'email' => 'Mehak11066@iiitd.ac.in'
        ) );
        
        Cclist::create ( array (
                'cc_id' => '111911364852842467336_amazon',
                'email' => 'Geet11048@iiitd.ac.in'
        ) );
    
    }

}