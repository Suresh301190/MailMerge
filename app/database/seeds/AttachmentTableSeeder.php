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
                'fid'      => 'response',
                'filename' => 'Response Sheet.docx'
            ) );

            Attachment::create( array(
                'id'       => '111911364852842467336',
                'fid'      => 'brochure',
                'filename' => 'PlaceBro.pdf'
            ) );

            Attachment::create( array(
                'id'       => '111911364852842467336',
                'fid'      => 'custom1',
                'filename' => 'PC - Prep Handbook Final.docx'
            ) );

            Attachment::create( array(
                'id'  => '111911364852842467336',
                'fid' => 'custom2',
                'filename' => 'Parser.java'
            ) );
        }
    }