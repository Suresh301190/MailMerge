<?php

    class Template
    {

        /**
         * List of templates offered by the System
         *
         * @var array
         */
        private static $templates = array(
            'usage'   => 'usage',
            'invite'  => 'invite',
            'follow'  => 'follow',
            'confirm' => 'confirm',
            'custom1' => 'custom1',
            'custom2' => 'custom2'
        );

        /**
         * array of values to be checked in the templates for verification
         *
         * @var array
         */
        private static $replace = array(
            '%HR%',
            '%COMPANY%'
        );

        public static function getReplaceArray()
        {
            return self::$replace;
        }

        /**
         * REGEX to match all the $replace values
         *
         * @var string
         */
        private static $pattern;

        /**
         * Generates the pattern to match with and caches it
         *
         * @return string
         */
        private static function getPattern()
        {
            if ( !self::$pattern ) {
                self::$pattern = '/' . implode( "(.*)", self::$replace ) . '/';
            }

            return self::$pattern;
        }

        public static final function getTemplatesArray()
        {

            return self::$templates;

        }

        /**
         * To cache the values on first access
         *
         * @var string
         */
        public static $usage, $send;

        public static function getModifyUsage()
        {

            if ( !self::$usage ) {
                self::$usage = File::get( storage_path() . "/templates/usage.txt" );
            }

            return self::$usage;

        }

        /**
         * To cache the values on first access
         *
         * @return string $send
         */
        public static function getSendUsage()
        {

            if ( !self::$send ) {
                self::$send = File::get( storage_path() . "/templates/send.txt" );
            }

            return self::$send;

        }

        /**
         * To get the Templates Content from the storage
         *
         * @param string $type
         *
         * @return string
         */
        public static function getTemplateContent( $type )
        {

            if ( in_array( "$type", self::$templates ) ) {
                $content = File::get( storage_path() . "/templates/$type.txt" );

                return $content;
            } else {
                return "Template Doesn't Exists $type";
            }

        }

        /**
         * To store the Templates Content after it contains the $replace strings in
         * it
         *
         * @param string $type     of template to select
         * @param string $content  Content of template to save
         * @param array  $contains of replaceable strings
         *
         * @return array $data('content', 'message', 'success')
         */
        public static function putTemplateContents( $type, $content, $contains )
        {

            $data = array();
            if ( strcmp( 'usage', "$type" ) == 0 ) {
                $data ['message'] = "Please select a template from the list";
                $data ['content'] = "$content";
                $data ['success'] = false;
            } else if ( in_array( "$type", self::$templates ) ) {
                if ( !self::validate( $content, $contains ) ) {
                    $data ['message'] = "The template doesn't Contain all the selected patterns [" . implode( ',', $contains ) . "]";
                    $data ['success'] = false;
                } else {
                    File::put( storage_path() . "/templates/$type.txt", "$content" );
                    $data ['message'] = "Template $type Successfully Updated";
                    $data ['success'] = true;
                }
                $data ['content'] = $content;
            } else {
                $data ['message'] = $type;
                $data ['content'] = "Template Doesn't Exists $type";
                $data ['success'] = false;
            }

            return $data;

        }

        /**
         * Validates the content for all the replaceable instances
         *
         * @param string $content  to validate
         * @param array  $contains contains all valid replaceable strings
         *
         * @return bool true if $content contains all the $replace pattern
         */
        public static function validate( $content, $contains )
        {
            if ( null == $contains )
                return true;

            return preg_match( '/' . implode( "(.*)", $contains ) . '/', $content ) != 0;
        }

    }

?>