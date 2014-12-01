<?php
use Illuminate\Filesystem\Filesystem;

/**
 * Contains all static methods which can be used in the program
 *
 * @author Suresh
 *
 */
class Helper {

    /**
     * Function to print nested arrays
     *
     * @param unknown $arr
     *            array to print
     * @param unknown $level
     *            initial level
     */
    public static function arrayPrettyPrint($arr, $level) {

        foreach ( $arr as $k => $v ) {
            for($i = 0; $i < $level; $i ++)
                echo ("&nbsp;"); // You can change how you indent here
            if (! is_array ( $v ))
                echo ($k . " => " . $v . "<br/>");
            else {
                echo ($k . " => <br/>");
                self::arrayPrettyPrint ( $v, $level + 1 );
            }
        }
    
    }

    /**
     * To clean the array {"group_name":"amazon"} to amazon => amazon
     *
     * @param unknown $arr
     * @return multitype:string
     */
    public static function cleanGroups($arr, $slug = '', $offset = 10, $end = -2) {

        $data = array ();
        foreach ( $arr as $k => $v ) {
            $val = substr ( $v, $offset, $end );
            $data ["$slug$val"] = $val;
        }
        
        return $data;
    
    }

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