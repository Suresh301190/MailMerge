<?php

class Email {

    const HEADER_HTML = '<!DOCTYPE html>
        <html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>';

    const TAIL_HTML = '</body></html>';

    private static $mailingLists = array (
            'toList' => 'to-List',
            'ccList' => 'cc-List',
            'bccList' => 'bcc-List'
    );

    public static final function getMailingListArray() {

        return self::$mailingLists;
    
    }

    private static $templates = array (
            'useage' => 'useage',
            'invite' => 'invite',
            'follow' => 'follow',
            'confirm' => 'confirm',
            'custom1' => 'custom1',
            'custom2' => 'custom2'
    );

    public static final function getTemplatesArray() {

        return self::$templates;
    
    }

    public static $useage, $send;

    public static function getModifyUseage() {

        if (! self::$useage) {
            $fs = new Filesystem ();
            self::$useage = $fs->get ( storage_path () . "/templates/useage.txt" );
        }
        
        return self::$useage;
    
    }

    public static function getSendUseage() {

        if (! self::$send) {
            $fs = new Filesystem ();
            self::$send = $fs->get ( storage_path () . "/templates/send.txt" );
        }
        
        return self::$send;
    
    }

    /**
     * To get the Templates Content from the storage
     *
     * @param string $type
     */
    public static function getTemplateContent($type) {

        if (in_array ( "$type", self::$templates )) {
            $fs = new Filesystem ();
            $content = $fs->get ( storage_path () . "/templates/$type.txt" );
            return $content;
        }
        else {
            return "Template Doesn't Exists $type";
        }
    
    }

    /**
     * To store the Templates Content
     *
     * @param string $type
     * @param string $content
     */
    public static function putTemplateContents($type, $content) {

        $data = array ();
        if (strcmp ( 'useage', "$type" ) == 0) {
            $data ['type'] = $type;
            $data ['content'] = "$content";
            $data ['success'] = false;
        }
        else if (in_array ( "$type", self::$templates )) {
            $fs = new Filesystem ();
            $fs->put ( storage_path () . "/templates/$type.txt", "$content" );
            $data ['type'] = $type;
            $data ['content'] = $content;
            $data ['success'] = true;
        }
        else {
            $data ['type'] = $type;
            $data ['content'] = "Template Doesn't Exists $type";
            $data ['success'] = false;
        }
        
        return $data;
    
    }

}
?>