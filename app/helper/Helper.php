<?php

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
     * @param array $arr
     *            array to print
     * @param int $level
     *            initial level
     */
    public static function arrayPrettyPrint($arr, $level) {

        foreach ( $arr as $k => $v ) {
            for($i = 0; $i < $level; $i ++)
                echo ("&nbsp;"); // You can change how you
                                     // indent here
            if (! is_array ( $v ))
                echo ($k . " => " . $v . "<br/>");
            else {
                echo ($k . " => <br/>");
                self::arrayPrettyPrint ( $v, $level + 1 );
            }
        }
    
    }

    /**
     * To clean an array {"gname":"amazon"} to amazon => amazon
     *
     * @param array $arr
     * @param string $slug
     *            = ''
     * @param int $offset
     *            = 10
     * @param int $end
     *            = -2
     * @return array
     */
    public static function cleanGroups($arr, $slug = '', $offset = 10, $end = -2) {

        $data = array ();
        foreach ( $arr as $k => $v ) {
            $val = substr ( $v, $offset, $end );
            $data ["$slug$val"] = $val;
        }
        
        return $data;
    
    }

}
?>