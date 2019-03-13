// $(document).ready(function(){
// 	$.ajax({
// 		url: "http://localhost/chartjs/data.php",
// 		method: "GET",
// 		success: function(data){
// 			var obj = JSON.parse(data);
// 			console.log(obj);
// 			var standard = [];
// 			var score = [];

// 			for (var i = 0; i < 5; i++) {
// 				standard.push("Chuan "+ (i+1));
// 				score.push(data[i].i);
// 			}

// 			// for (var i in data) {
// 			// 	player.push("Chuong "+data[i].id);
// 			// 	score.push(data[i].score);
// 			// }

			// var chartdata = {
			// 	labels : player,
			// 	datasets: [
			// 		{
			// 			label:'Player Score',
			// 			backgroundColor: 'rgb(255, 255, 132)',
			// 			borderColor: 'rgb(255, 99, 132)',
			// 			data: score
			// 		}
			// 	]
			// };

// 			// var ctx = $("#mycanvas");

			// var barGraph = new Chart(ctx,{
			// 	type: 'radar',
			// 	data: chartdata
			// });
// 		},
// 		error: function(data) {
// 			console.log(data);
// 		},
// 	});
// });