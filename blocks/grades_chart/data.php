<?php
require_once("../../config.php");
require_once($CFG->dirroot.'/lib/moodlelib.php');
global $DB;

//$sql = "SELECT gi.id, categoryid, fullname, itemname, gradetype, grademax, grademin
//            FROM {grade_categories} gc
//            LEFT JOIN {grade_items} gi ON gc.courseid = gi.courseid AND gc.id = gi.categoryid
//            WHERE gc.courseid = ? AND categoryid IS NOT NULL AND EXISTS (
//                SELECT *
//                    FROM {grade_grades} gg
//                    WHERE gg.itemid = gi.id AND gg.rawgrade IS NOT NULL )
//        ORDER BY fullname, itemname";
//
//$courseId = $_GET['courseId'];
//
//$res = $DB->get_records_sql($sql, array($courseId));
//
//echo "<pre>";
//print_r($res);die;

$sql = "SELECT id, userid, usermodified, rawgrade, finalgrade
            FROM {grade_grades} gg
            WHERE  rawgrade <> 0
            ORDER BY userid ASC";

$result = $DB->get_records_sql($sql);

$gradeJson = json_encode($result,true);

echo "<pre>";
print_r($result);die;