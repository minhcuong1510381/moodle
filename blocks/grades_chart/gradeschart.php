<?php
require_once("../../config.php");
require_once($CFG->dirroot.'/lib/moodlelib.php');
global $DB;
require("lib.php");

$courseId = $_GET['courseId'];

$query = "SELECT id, u.firstname, u.lastname 
          FROM {user} u
          WHERE u.id <> 1 AND u.password <> 'restored' 
          ORDER BY u.id ASC";

$res = $DB->get_records_sql($query);



//$arrUser = block_grades_chart_get_users_array($res);

//echo "<pre>";
//print_r($res);die;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="icon" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .chart-container {
            width: 640px;
            height: auto;
        }
    </style>
</head>
<body>
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
            <button type="button" onclick="myClick($('#student').val(), <?php echo $courseId; ?>);" class="btn btn-primary" style="margin-left: 40%; width: 200px; margin-top: 10px;">Xác nhận</button>
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
                    aGrade.push((obj[i].rawgrade * 10).toFixed(2)); 
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
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/style.js"></script>


</body>
</html>
