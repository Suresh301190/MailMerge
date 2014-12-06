<?php

    /**
     * Created by PhpStorm.
     * User: Suresh
     * Date: 04-Dec-14
     * Time: 2:35 AM
     */
    class AttachmentTableSeeder extends Seeder
    {

        public function run()
        {
            Attachment::create( array(
                'id'       => '111911364852842467336',
                'filename' => 'Response Sheet'
            ) );

            Attachment::create( array(
                'id'       => '111911364852842467336',
                'filename' => 'Brochure'
            ) );

            Attachment::create( array(
                'id'       => '111911364852842467336',
                'filename' => 'Custom1'
            ) );

            Attachment::create( array(
                'id' => '111911364852842467336',
                'filename' => 'Custom2'
            ) );
        }
    }