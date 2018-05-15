<?php
/**
 * Created by PhpStorm.
 * User: Marcel
 * Date: 15.05.2018
 * Time: 09:45
 */

class Notification
{
    /**
     * @var string $output
     */
    private static $output = "";

    /**
     * Returns the saved notification output
     * @return string
     */
    public static function getOutput(){
        return self::$output;
    }

    /**
     * Add a string to the notification output
     * @param $string
     */
    public static function addOutput($string) {
        self::$output .= $string . "<br/>";
    }
}