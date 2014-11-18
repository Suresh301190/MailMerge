<?php

/**
 * Contains all static methods which can be used in the program
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
     * @param unknown $arr
     * @return multitype:string
     */
    public static function cleanGroups($arr) {
        $data = array();
        foreach ( $arr as $k => $v ) {
            $val = substr($v, 15, -2);
            $data["$val"] = $val;
        }
        
        return $data;
    }

}
?>