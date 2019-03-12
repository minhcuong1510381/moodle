<?php
require_once("../../config.php");
require_once($CFG->dirroot.'/lib/moodlelib.php');
global $DB;
require("lib.php");

$courseId = $_GET['courseId'];

$studentId = $_GET['studentId'];

// die($studentId);

$query = "SELECT id, u.firstname, u.lastname 
          FROM {user} u
          WHERE u.id <> 1 AND u.password <> 'restored' 
          ORDER BY u.id ASC";

$res = $DB->get_records_sql($query);

$query1 = "SELECT q.name, qg.grade
FROM {quiz} q
LEFT JOIN {quiz_grades} qg ON qg.quiz = q.id
WHERE q.course = $courseId
ORDER BY q.id";

$quiz = $DB->get_records_sql($query1);

$aQuiz = block_grades_chart_convert_to_array($quiz);
    

//$arrUser = block_grades_chart_get_users_array($res);

echo "<pre>";
print_r($aQuiz);die;

?>
<?php include('inc/header.php') ?>
    <div class="container">
        <div class="header">
            <div class="title-gradeschart">
                <h3>Biểu đồ đánh giá năng lực sinh viên</h3>
            </div>
            <div class="form-group choose-student" style="margin: 0 auto; width: 500px;">
                <label>Chọn sinh viên: </label>
                <select class="form-control" id="student" >
                    <?php foreach ($res as $key => $value) { ?>
                        <option value="<?php echo $key; ?>">
                            <?php echo $value->{'firstname'}." ".$value->{'lastname'}; ?>
                        </option>
                    <?php }?>
                </select>
            </div>
            <p style="margin: 0 auto; width: 500px; padding-top: 10px;">
                <?php for ($i=0; $i < 5; $i++) { ?>
                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapse[<?php echo $i; ?>]">
                        Chuẩn <?php echo $i+1; ?>
                    </button>
                <?php } ?>
            </p>
            <?php for ($i=0; $i < 5; $i++) { ?>
            <div class="collapse" id="collapse[<?php echo $i; ?>]" style="padding-top: 10px; margin: 0 auto; width: 500px;">
                <div class="card card-body">
                    <h4>Chuẩn <?php echo $i+1; ?></h4>
                    <?php foreach ($aQuiz as $key => $value) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="stand[<?php echo $i+1; ?>]-value[<?php echo $key; ?>]" id="stand[<?php echo $i+1; ?>]-value[<?php echo $key; ?>]">
                      <label class="form-check-label" for="stand[<?php echo $i+1; ?>]-value[<?php echo $key; ?>]">
                         <?php echo $value->{'name'}; ?>
                      </label>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <button type="button" onclick="myClick($('#student').val(), <?php echo $courseId; ?>);" class="btn btn-danger" style="margin-left: 40%; width: 200px; margin-top: 10px;">Xác nhận</button>
        </div>
    </div>
<div class="chart-container" style="display: none; margin: 0 auto; padding-top: 50px;">
    <canvas id="mycanvas"></canvas>
</div>

<script>
    function myClick(studentId, courseId) {
        // var studentId = document.getElementById('student').value;
        $.ajax({
            type: "GET",
            url: "./data.php?studentId=" + studentId +"&courseId="+ courseId,
            success: function(data){
                
                var obj = JSON.parse(data);
                // console.log(obj);
                var nameStudent = obj[0].firstname + " " + obj[0].lastname;

                var aGrade = [];

                for (var i = 0; i < obj.length; i++) {
                    aGrade.push((obj[i].grade * 10).toFixed(2)); 
                }

                console.log(aGrade);
                
                var chartdata = {
                    labels : ["Chuẩn 1","Chuẩn 2","Chuẩn 3","Chuẩn 4","Chuẩn 5"],
                    datasets: [
                        {
                            label: nameStudent,
                            data: aGrade,
                            backgroundColor: 'rgb(255, 255, 132, 0.3)',
                            borderColor: 'rgb(255, 99, 132)',
                        }
                    ]
                };

                $(".chart-container").css("display","block");

                var ctx = $("#mycanvas");

                var barGraph = new Chart(ctx,{
                    type: 'radar',
                    data: chartdata,
                });
            }
        });

    }
</script>
<?php include('inc/footer.php') ?>
