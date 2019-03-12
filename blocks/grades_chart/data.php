<?php

header('Content-Type: application/json');

require_once("../../config.php");
require_once($CFG->dirroot.'/lib/moodlelib.php');
global $DB;
require("lib.php");

$studentId = $_GET['studentId'];

$courseId = $_GET['courseId'];

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

$sql = "SELECT qg.grade, qg.quiz, qg.userid, u.firstname, u.lastname
			FROM {user} u
            LEFT JOIN {quiz_grades} qg ON u.id = qg.userid
            WHERE  qg.grade <> 0 AND qg.userid = $studentId
            ORDER BY qg.userid ASC";

$result = $DB->get_records_sql($sql);

$arrayRes = block_grades_chart_convert_to_array($result);

$gradeJson = json_encode($arrayRes,true);

print $gradeJson;

// echo "<pre>";
// print_r($result);die;