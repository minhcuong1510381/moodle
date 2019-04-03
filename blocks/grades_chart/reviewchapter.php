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

?>
<?php include('inc/header.php') ?>
    <div class="container" style="height: 700px;">
        <div class="header">
            <div class="title-gradeschart" style="margin: 0 auto; width: 500px; text-align: center">
                <h3>Biểu đồ thống kê điểm số sinh viên theo chương</h3>
            </div>
        </div>
        <div class="content">
            <form id="form-chapter" style="margin-top: 20px;">
                <input type="hidden" id="courseId" name="courseId" value="<?php echo $courseId; ?>">
                <div class="form-group choose-year-chapter" style="margin: 0 auto; width: 500px;" id="year-chapter">
                    <label>Chọn năm để phân tích:</label>
                    <select class="form-control" id="choose-year-chapter" name="yearChapter">
                        <?php for ($i = date("Y") - 10; $i <= date("Y"); $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button id="submit" type="submit" class="btn btn-danger"
                        style="margin-left: 40%; width: 200px; margin-top: 10px;">Xác nhận
                </button>
            </form>
        </div>
        <div class="chart-container" style="display: none; width: 800px;">
            <canvas id="chapterCanvas" style="width: 800px"></canvas>
        </div>
    </div>

<?php include('inc/footer.php') ?>