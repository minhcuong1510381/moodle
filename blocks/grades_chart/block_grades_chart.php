<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/10/2019
 * Time: 10:16 PM
 */
class block_grades_chart extends block_base {
    public function init() {
        $this->title = "Analytics Chart";
    }
    // The PHP tag and the curly bracket for the class definition
    // will only be closed after there is another function added in the next section.
    public function get_content() {
        global $CFG;

        $course = $this->page->course;
        $context = context_course::instance($course->id);
        $canview = has_capability('block/analytics_graphs:viewpages', $context);

        if (!$canview) {
            return;
        }
        if ($this->content !== null) {
            return $this->content;
        }

        $courseId = $_GET['id'];
        $chartURL = new moodle_url('/blocks/grades_chart/gradeschart.php',array('courseId'=>$courseId));
        $tableURL = new moodle_url('/blocks/grades_chart/gradestable.php',array('courseId'=>$courseId));
        $reviewCourseURL = new moodle_url('/blocks/grades_chart/reviewcourse.php',array('courseId'=>$courseId));

        $this->content         =  new stdClass;
        $this->content->text   = '<li><a href="'.$chartURL.'" target="_blank">Radar Chart</a></li>';
        $this->content->text   .= '<li><a href="'.$tableURL.'" target="_blank">Grades Table</a></li>';
        $this->content->text   .= '<li><a href="'.$reviewCourseURL.'" target="_blank">Bar Chart</a></li>';

        return $this->content;
    }
}