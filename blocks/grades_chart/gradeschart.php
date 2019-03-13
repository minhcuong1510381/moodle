<?php
require_once("../../config.php");
require_once($CFG->dirroot.'/lib/moodlelib.php');
global $DB;
require("lib.php");
// include('data.php');

$courseId = $_GET['courseId'];

require_login($courseId);

$query = "SELECT u.id, u.firstname, u.lastname 
          FROM {user} u
          WHERE u.id <> 1 AND u.password <> 'restored' 
          ORDER BY u.id ASC";

$res = $DB->get_records_sql($query);

?>
<?php include('inc/header.php') ?>
    <div class="container" style="height: 700px;">
        <div class="header">
            <div class="title-gradeschart">
                <h3>Biểu đồ đánh giá năng lực sinh viên</h3>
            </div>
            <form id="myform">
                <input type="hidden" id="courseId" name="courseId" value="<?php echo $courseId; ?>">
                <div class="form-group choose-student" style="margin: 0 auto; width: 500px;">
                <label>Chọn sinh viên: </label>
                <select class="form-control" id="student" name="studentId">
                    <?php foreach ($res as $key => $value) { ?>
                        <option value="<?php echo $value->{'id'}; ?>">
                            <?php echo $value->{'firstname'}." ".$value->{'lastname'}; ?>
                        </option>
                    <?php }?>
                </select>
                </div>
                <button id="submit" type="submit" class="btn btn-danger" style="margin-left: 40%; width: 200px; margin-top: 10px;">Xác nhận</button>
            </form>  
        </div>
    
        <div class="chart-container" style="display: none;">
            <canvas id="mycanvas"></canvas>
        </div>
        <div class="table-container" style="display: none; padding-top: 20px; margin: 0 auto; width: 500px;">
        </div>
        <div class="detail" style="display:none; margin: 0 auto; width: 100px; padding-top: 10px;">
            <button type="button" id="detail" class="btn btn-primary">Chi tiết</button>
        </div>
        <div class="graph" style="display:none; margin: 0 auto; width: 100px;">
            <button type="button" id="graph" class="btn btn-success">Đồ thị</button>
        </div>
    </div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<!-- <script src="js/style.js"></script> -->
<script>
    $(document).ready(function(){
        $('#myform').on('submit',function(e){
            $('.table-container').empty();
            $('#detail').unbind("click");
            $('.table-container').css("display", "none");
            $('.graph').css("display", "none");
            $('#mycanvas').remove();
            $('.chart-container').append('<canvas id="mycanvas"><canvas>');
            e.preventDefault();
            var frm = $('#myform');
            $.ajax({
                type:"POST",
                url: 'data.php',
                data: frm.serializeArray(),
                success: function(data){
                    // console.log(data);
                    var obj = JSON.parse(data);
                    var vertex = [];
                    var score = [];
                    var ave = [];

                    for (var i in obj){
                        vertex.push(obj[i].name);
                        score.push(obj[i].average);
                        ave.push(5);
                    }

                    var options = {
                        scale: {
                            ticks: {
                                beginAtZero: true,
                                max: 10
                            }
                        }
                    };

                    var chartdata = {
                        labels : vertex,
                        datasets: [
                            {
                                label: obj[0].user,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgb(54, 162, 235)',
                                pointBackgroundColor: 'rgb(54, 162, 235)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgb(54, 162, 235)',
                                data: score,
                                fill: true,
                            },
                            {
                                label: "Trung bình",
                                borderColor: 'rgb(255, 0, 0)',
                                backgroundColor: 'rgba(255, 255, 255, 0)',
                                borderWidth: '1',
                                pointStyle: 'cross',
                                data: ave,
                                fill: true,
                            }
                        ]
                    };

                    $(".chart-container").css("display","block");
                    $(".detail").css("display","block");

                    var ctx = $("#mycanvas");

                    var barGraph = new Chart(ctx,{
                        type: 'radar',
                        data: chartdata,
                        options: options,
                    });

                    $('#detail').click(function(e){
                        e.preventDefault();
                        $('.chart-container').css("display", "none");
                        $('.table-container').css("display", "block");
                        $('.detail').css("display", "none");
                        $('.graph').css("display", "block");

                        var sum = 0;

                        var table = document.createElement("table");
                        table.setAttribute("class","table table-bordered");
                        $('.table-container').append(table);

                        var thead = document.createElement("thead");
                        table.appendChild(thead);

                        var trHead = document.createElement("tr");
                        thead.appendChild(trHead);

                        var thHead = document.createElement("th");
                        thHead.setAttribute("colspan","3");
                        trHead.appendChild(thHead);

                        thHead.innerHTML= obj[0].user;

                        var tbody = document.createElement("tbody");
                        table.appendChild(tbody);

                        var trBody = document.createElement("tr");
                        tbody.appendChild(trBody);

                        for (var i = 1; i <= 3; i++) {
                            var thBody = document.createElement("th");
                            trBody.appendChild(thBody);
                            if(i == 1){
                                thBody.innerHTML = "Chương";
                            }else if(i==2){
                                thBody.innerHTML = "ĐTB chương";
                            }else{
                                thBody.innerHTML = "Đánh giá";
                            }
                        }

                        for (var i = 0; i < obj.length; i++) {
                            var trBody1 = document.createElement("tr");
                            tbody.appendChild(trBody1);

                            var tdBody1 = document.createElement("td");
                            tdBody1.setAttribute("width", "60%");
                            var tdBody2 = document.createElement("td");
                            tdBody2.setAttribute("width", "20%");
                            var tdBody3 = document.createElement("td");
                            tdBody3.setAttribute("width", "20%");

                            trBody1.appendChild(tdBody1);
                            trBody1.appendChild(tdBody2);
                            trBody1.appendChild(tdBody3);

                            tdBody1.innerHTML = obj[i].name;
                            tdBody2.innerHTML = obj[i].average;
                            if(tdBody2.innerHTML >= 5){
                                tdBody3.innerHTML = '<i class="fa fa-check"></i>';
                            }else{
                                tdBody3.innerHTML = '<i class="fa fa-times"></i>';
                            }
                            sum += parseFloat(tdBody2.innerHTML);
                        }

                        var trBody2 = document.createElement("tr");
                        tbody.appendChild(trBody2);

                        var thBody2 = document.createElement("th");
                        trBody2.appendChild(thBody2);
                        thBody2.innerHTML = "Trung bình khóa học: ";

                        var tdBody4 = document.createElement("td");
                        trBody2.appendChild(tdBody4);
                        tdBody4.innerHTML = (sum/obj.length).toFixed(1);

                        var tdBody5 = document.createElement("td");
                        trBody2.appendChild(tdBody5);
                        if(tdBody4.innerHTML >= 5){
                            tdBody5.innerHTML = '<i class="fa fa-check"></i>';
                        }else{
                            tdBody5.innerHTML = '<i class="fa fa-times"></i>';
                        }
                        console.log(obj.length);

                    });

                    $('#graph').click(function(e){
                        e.preventDefault();
                        $('.chart-container').css("display", "block");
                        $('.table-container').empty();
                        $('.detail').css("display", "block");
                        $('.graph').css("display", "none");
                        console.log(obj);
                    });


                }
            });
        });


    });
</script>
<?php include('inc/footer.php') ?>
