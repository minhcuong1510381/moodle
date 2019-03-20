<?php
require_once("../../config.php");
require_once($CFG->dirroot.'/lib/moodlelib.php');
global $DB;
require("lib.php");

$courseId = $_GET['courseId'];

$studentId = $_GET['studentId'];

$query = "SELECT id, u.firstname, u.lastname 
          FROM {user} u
          WHERE u.id <> 1 AND u.password <> 'restored' 
          ORDER BY u.id ASC";

$res = $DB->get_records_sql($query);

$query1 = "SELECT *
FROM {question_attempt_steps} qas
INNER JOIN {question_attempts} qa ON qa.id = qas.questionattemptid
INNER JOIN {quiz_slots} qs ON qa.questionid = qs.questionid
WHERE qas.state <> 'todo' AND qas.state <> 'complete' AND qas.userid = 2
ORDER BY qas.id";
$quiz = $DB->get_records_sql($query1);

$aQuiz = block_grades_chart_convert_to_array($quiz);

$quiz1 = [];
$result = [];
foreach ($aQuiz as $key => $value) {
  $t = $value->{'quizid'};
  $query2 = "SELECT name
  FROM {quiz}
  WHERE id = $t";

  $quiz1[] = block_grades_chart_convert_to_array($DB->get_records_sql($query2));

  $result[] = ["state" => $value->{'state'}, "questionsummary" => $value->{'questionsummary'}, "rightanswer" => $value->{'rightanswer'}, "responsesummary" => $value->{'responsesummary'}, "nameQuiz" => $quiz1[$key][0]];
}


echo "<pre>";
print_r($result);die;

?>
<?php include('inc/header.php') ?>
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
        				<th>Câu 1</th>
        				<th>Câu 2</th>
                <th>Câu 3</th>
                <th>Câu 4</th>
                <th>Câu 5</th>
                <th>Câu 6</th>
                <th>Câu 7</th>
                <th>Câu 8</th>
                <th>Câu 9</th>
                <th>Câu 10</th>
        			</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>Chương 1</td>
                <?php foreach ($quiz as $key => $value) { ?>
                  <?php if ( $value->{'quizid'} == '7' &&  $value->{'state'} == 'gradedright') { ?>
                    <td id qa-<?php $id ?>><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '7' &&  $value->{'state'} == 'gradedwrong') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '7' &&  $value->{'state'} == 'gradedpartial') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '7' &&  $value->{'state'} == 'gaveup') { ?>
                    <td><br></td>
                  <?php }?>
          			<?php }?>
        			</tr>
        			<tr>
                <td>Chương 2</td>
                <?php foreach ($quiz as $key => $value) { ?>
                  <?php if ( $value->{'quizid'} == '8' &&  $value->{'state'} == 'gradedright') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '8' &&  $value->{'state'} == 'gradedwrong') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '8' &&  $value->{'state'} == 'gradedpartial') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '8' &&  $value->{'state'} == 'gaveup') { ?>
                    <td><br></td>
                  <?php }?>
                <?php }?>
              </tr>
              <tr>
                <td>Chương 3</td>
                <?php foreach ($quiz as $key => $value) { ?>
                  <?php if ( $value->{'quizid'} == '9' &&  $value->{'state'} == 'gradedright') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '9' &&  $value->{'state'} == 'gradedwrong') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '9' &&  $value->{'state'} == 'gradedpartial') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '9' &&  $value->{'state'} == 'gaveup') { ?>
                    <td><br></td>
                  <?php }?>
                <?php }?>
              </tr>
              <tr>
                <td>Chương 4</td>
                <?php foreach ($quiz as $key => $value) { ?>
                  <?php if ( $value->{'quizid'} == '10' &&  $value->{'state'} == 'gradedright') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '10' &&  $value->{'state'} == 'gradedwrong') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '10' &&  $value->{'state'} == 'gradedpartial') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '10' &&  $value->{'state'} == 'gaveup') { ?>
                    <td><br></td>
                  <?php }?>
                <?php }?>
              </tr>
              <tr>
                <td>Chương 5</td>
                <?php foreach ($quiz as $key => $value) { ?>
                  <?php if ( $value->{'quizid'} == '11' &&  $value->{'state'} == 'gradedright') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-check"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '11' &&  $value->{'state'} == 'gradedwrong') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '11' &&  $value->{'state'} == 'gradedpartial') { ?>
                    <td><a href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
                  <?php }?>
                  <?php if ( $value->{'quizid'} == '11' &&  $value->{'state'} == 'gaveup') { ?>
                    <td><br></td>
                  <?php }?>
                <?php }?>
              </tr>
        		</tbody>
        	</table>
        </div>
    </div>

<?php include('inc/footer.php') ?>
