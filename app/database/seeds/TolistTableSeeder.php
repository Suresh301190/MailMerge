<?php

class TolistTableSeeder extends Seeder {

    public function run() {

        Tolist::create ( array (
                'to_id' => '111911364852842467336_adobe',
                'email' => 'Suresh1317@iiitd.ac.in'
        ) );
        
        Tolist::create ( array (
                'to_id' => '111911364852842467336_adobe',
                'email' => 'suresh301190@gmail.com'
        ) );
        
        Tolist::create ( array (
                'to_id' => '111911364852842467336_amazon',
                'email' => 'suresh301190@gmail.com'
        ) );
        
        Tolist::create ( array (
                'to_id' => '111911364852842467336_amazon',
                'email' => 'Suresh1317@iiitd.ac.in'
        ) );
    
    }

}