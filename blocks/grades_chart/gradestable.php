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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/font-awesome.css"> -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title-gradeschart">
                <h3>Đánh giá chi tiết môn học</h3>
            </div>
            <div class="form-group choose-student" style="margin: 0 auto; width: 500px;">
               <label>Chọn sinh viên: </label>
               <select class="form-control" id="student">
                   <?php foreach ($res as $key => $value) { ?>
                       <option value="<?php echo $key; ?>">
                           <?php echo $value->{'firstname'}." ".$value->{'lastname'}; ?>
                       </option>
                   <?php }?>
               </select>
               <button type="button" class="btn btn-primary" style="margin-left: 30%; width: 200px; margin-top: 10px;">Xác nhận</button>
           </div>

       </div>
        <div class="content" style="margin-top: 10px;">
        	<table class="table table-bordered">
        		<thead>
        			<tr>
        				<th></th>
        				<th>Chương 1</th>
        				<th>Chương 2</th>
        				<th>Chương 3</th>
        				<th>Chương 4</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>Q1</td>
        				<td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
        				<td><a href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
        				<td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
        				<td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
        			</tr>
        			<tr>
        				<td>Q2</td>
        				<td><a href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
        				<td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
        				<td><a href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
        				<td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
        			</tr>
        		</tbody>
        	</table>
        </div>
    </div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/style.js"></script>


</body>
</html>
