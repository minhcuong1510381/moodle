<?php
require_once("../../config.php");
require_once($CFG->dirroot . '/lib/moodlelib.php');
global $DB, $USER;
require("lib.php");
// include('data.php');

$courseId = $_GET['courseId'];

require_login($courseId);

$context = context_course::instance($courseId);

$roles = get_user_roles($context, $USER->id);

$isStudent = current(get_user_roles($context, $USER->id))->shortname == 'student' ? 1 : 2;

if ($isStudent == 1) {
    return false;
}

$query = "SELECT u.id, u.firstname, u.lastname
          FROM {user} u
          INNER JOIN {role_assignments} ra ON ra.userid = u.id
          INNER JOIN {context} ct ON ct.id = ra.contextid 
          WHERE u.suspended = 0 AND ct.contextlevel = 50 AND ct.instanceid = $courseId
          ORDER BY u.id ASC";

$res = block_grades_chart_convert_to_array($DB->get_records_sql($query));

$qry = "SELECT AVG(qg.grade) as ave, qg.userid
            FROM {quiz_grades} qg
            GROUP BY qg.userid";


$temp = block_grades_chart_convert_to_array($DB->get_records_sql($qry));

$data = [];
foreach ($res as $key => $value) {
    $userId = $value->{'id'};
    $value->{'ave'} = 0;

    foreach ($temp as $k => $v) {
        if ($v->{'userid'} == $userId) {
            $res[$key]->{'ave'} = round($v->{'ave'}, 1);
        }
    }
}

$sumPass = 0;
$sumNotPass = 0;

?>
<?php include('inc/header.php') ?>
    <div class="container" style="height: 700px;">
        <div class="header">
            <div class="title-gradeschart" style="margin: 0 auto; width: 500px; text-align: center">
                <h3>Tổng kết điểm trung bình của sinh viên trong khóa học</h3>
            </div>
        </div>
        <div class="content" style="margin: 0 auto; width: 500px; text-align: center; padding-top: 30px;">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Họ tên sinh viên</th>
                    <th>Điểm trung bình khóa học</th>
                    <th>Đánh giá</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($res as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value->{'firstname'} . " " . $value->{'lastname'} ?></td>
                        <td><?php echo number_format($value->{'ave'},1,'.','') ?></td>
                        <td><?php if ($value->{'ave'} >= 5) { $sumPass++; ?><i class="fa fa-check"></i><?php } else { $sumNotPass++; ?>
                                <i class="fa fa-times"></i><?php } ?></td>
                    </tr>
                <?php } ?>
                    <tr>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Tổng kết</th>
                        <td>Số lượng sinh viên đạt</td>
                        <td><?php echo $sumPass; ?></td>
                    </tr>
                    <tr>
                        <td>Số lượng sinh viên không đạt</td>
                        <td><?php echo $sumNotPass; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="chart-container" style="display: none; width: 800px;">
            <canvas id="chapterCanvas" style="width: 800px"></canvas>
        </div>
        <div class="comment" style="display: none; width: 500px; margin: 0 auto;">
        </div>

    </div>

<?php include('inc/footer.php') ?>