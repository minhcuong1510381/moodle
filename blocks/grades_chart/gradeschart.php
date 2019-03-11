<?php
require_once("../../config.php");
require_once($CFG->dirroot.'/lib/moodlelib.php');
global $DB;
require("lib.php");


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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
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
                <select class="form-control" id="student" onchange="myChange();">
                    <?php foreach ($res as $key => $value) { ?>
                        <option value="<?php echo $key; ?>">
                            <?php echo $value->{'firstname'}." ".$value->{'lastname'}; ?>
                        </option>
                    <?php }?>
                </select>
            </div>
        </div>
    </div>
<!--<button onclick="myClick();">Click to draw</button>-->
<!--<div class="chart-container" style="display: none;">-->
<!--    <canvas id="mycanvas"></canvas>-->
<!--</div>-->

<!--<script>-->
<!--    function myClick() {-->
<!--        $(".chart-container").css("display", "block");-->
<!--    }-->
<!--</script>-->
<script>
    function myChange() {
        var studentId = document.getElementById('student').value;
        alert(studentId);

    }
</script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/style.js"></script>


</body>
</html>
