<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/11/2019
 * Time: 10:34 AM
 */
defined('MOODLE_INTERNAL') || die();

function block_grades_chart_convert_to_array($user){
    $result = array();
    if($user){
        foreach ($user as $key => $value){
            $result[] = $value;
        }
    }

    return $result;
}