$(document).ready(function () {
    $('#form-chapter').on('submit', function (e) {
        e.preventDefault();
        var frm = $('#form-chapter');
        $.ajax({
            type: "POST",
            url: 'data_chapter.php',
            data: frm.serializeArray(),
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj);
                if (obj.response == 1) {
                    alert("Năm " + obj.yearReview + " hiện chưa có dữ liệu");
                    return false;
                }
                var vertex = [];
                var data = [];
                var ave = [];

                for (var i in obj) {
                    vertex.push(obj[i].name);
                    data.push(obj[i].per_student_grade_gt_5);
                    ave.push(50);
                }
                console.log(vertex);

                var options = {
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                            }
                        }],
                        yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                steps: 10,
                                stepValue: 5,
                                min: 0,
                                suggestedMin: 0,
                                max: 100
                            }
                        }]
                    },
                };
                var chartdata = {
                    labels: vertex,
                    datasets: [
                        {
                            label: "Phần trăm sinh viên có ĐTB lớn hơn hoặc bằng 5",
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgb(54, 162, 235)',
                            data: data,
                            fill: true,
                        },
                        {
                            label: "Trung bình",
                            borderColor: 'rgb(255, 0, 0)',
                            borderWidth: '1',
                            type: "line",
                            data: ave,
                            fill: false,
                        }
                    ]
                };
                $(".chart-container").css("display", "block");
                var ctx = $("#chapterCanvas");

                var barGraph = new Chart(ctx, {
                    type: 'bar',
                    data: chartdata,
                    options: options
                });
            }
        });
    });
});

