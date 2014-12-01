<?php

class UserTableSeeder extends Seeder {

    public function run() {

        User::create ( array (
                'id' => '111911364852842467336',
                'name' => 'Suresh Rangaswamy',
                'email' => 'suresh1317@iiitd.ac.in'
        ) );
        
        User::create ( array (
                'id' => '100167964743286505489',
                'name' => 'Suresh Rangaswamy',
                'email' => 'suresh301190@gmail.com'
        ) );
    
    }

}