<?php

require 'includes/init.php';

Auth::requireLogin();

$conn = require 'includes/db.php';


$classes = Classes::getAllClasses($conn);

$courses = Course::GetAllCourses($conn);

$teachers = Teacher::GetAllTeachers($conn);

$class_edit = Classes::getByClassID($conn, $_GET["class_id"]);

$class_id = $_POST["class_id"];

$chart_all_students = Charts::chartAllStudents($conn);
$active_students = Student::getAllStudentsActiveRows($conn);
$inactive_students = Student::getAllStudentsInactiveRows($conn);







var_dump($chart_all_students);


$count =  Classes::countStudentsInClassByID($conn, $class_id);

// require 'data.php';

require 'header.php';

require 'sidebar.php';


$dataPoints = array(
    array("label"=> "Food + Drinks", "y"=> 590),
    array("label"=> "Activities and Entertainments", "y"=> 261),
    array("label"=> "Health and Fitness", "y"=> 158),
    array("label"=> "Shopping & Misc", "y"=> 72),
    array("label"=> "Transportation", "y"=> 191),
    array("label"=> "Rent", "y"=> 573),
    array("label"=> "Travel Insurance", "y"=> 126)
);






$dataPoints = array(
   array("label"=>"Chrome", "y"=>64.02),
   array("label"=>"Firefox", "y"=>12.55),
   array("label"=>"IE", "y"=>8.47),
   array("label"=>"Safari", "y"=>6.08),
   array("label"=>"Edge", "y"=>4.29),
   array("label"=>"Others", "y"=>4.59)
)
?>




<script>
window.onload = function() {


var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Usage Share of Desktop Browsers"
	},
	subtitles: [{
		text: "November 2017"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>





<div id="layoutSidenav_content">



	<main>

    <div class="container-fluid">


        <div class="row m-2">
            <div class="col">
                <div class="card ">
                    <div class="card-body">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card ">
                    <div class="card-body">
             <canvas id="myChart2" width="100" height="100"></canvas>
          </div>
      </div>
            </div>
            <div class="col">
                <div class="card ">
                    <div class="card-body">

              3 of 3
          </div>
      </div>
            </div>
          </div>

          <div class="row m-2">
            <div class="col">
                <div class="card ">
                    <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>
   <script>
   var ctx = document.getElementById('myChart').getContext('2d');
   var myChart = new Chart(ctx, {
       type: 'bar',
       data: {
           labels: ['Ενεργοί', 'Ανενεργοί', 'Yellow', 'Green', 'Purple', 'Orange'],
           datasets: [{
               label: '# of Votes',
               data: [<?= $active_students; ?>, <?= $inactive_students; ?>],
               backgroundColor: [
                   'rgba(255, 99, 132, 0.2)',
                   'rgba(54, 162, 235, 0.2)',
                   'rgba(255, 206, 86, 0.2)',
                   'rgba(75, 192, 192, 0.2)',
                   'rgba(153, 102, 255, 0.2)',
                   'rgba(255, 159, 64, 0.2)'
               ],
               borderColor: [
                   'rgba(255, 99, 132, 1)',
                   'rgba(54, 162, 235, 1)',
                   'rgba(255, 206, 86, 1)',
                   'rgba(75, 192, 192, 1)',
                   'rgba(153, 102, 255, 1)',
                   'rgba(255, 159, 64, 1)'
               ],
               borderWidth: 1
           }]
       },
       options: {
           scales: {
               y: {
                   beginAtZero: true
               }
           }
       }
   });
   </script>
            </div>
        </div>
    </div>
            <div class="col-5">
              2 of 3 (wider)
            </div>








                                        <div class="col">
                                            <div class="card ">
                                                <div class="card-body">
                                                    <div id="piechart"></div>

                                                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                                                    <script type="text/javascript">
                                                    // Load google charts
                                                    google.charts.load('current', {'packages':['corechart']});
                                                    google.charts.setOnLoadCallback(drawChart);

                                                    // Draw the chart and set the chart values
                                                    function drawChart() {
                                                        var data = google.visualization.arrayToDataTable([
                                                            ['Task', 'Hours per Day'],
                                                            ['Work', <?= $active_students; ?>],
                                                            ['Eat', <?= $inactive_students; ?>],

                                                        ]);

                                                        // Optional; add a title and set the width and height of the chart
                                                        var options = {'title':'My Average Day', 'height':200};

                                                        // Display the chart inside the <div> element with id="piechart"
                                                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                                        chart.draw(data, options);
                                                    }
                                                    </script>


                                                    </div>
                                                </div>

                                        </div>






          </div>



        <div class="card mb-4">


        <div class="card-body">






<!-- <script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "Average Expense Per Day  in Thai Baht"
	},
	subtitles: [{
		text: "Currency Used: Thai Baht (฿)"
	}],
	data: [{
		type: "pie",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - #percent%",
		yValueFormatString: "฿#,##0",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>

<div id="chartContainer" style="height: 370px; width: 90%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->






<div>
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




<script>
  // === include 'setup' above ===
  const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
  ];
  const data = {
    labels: labels,
    datasets: [{
      label: 'My First dataset',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [0, 10, 5, 2, 20, 30, 45],
    }]
  };



  // === include 'config' ===
  const config = {
  type: 'line',
  data,
  options: {}
};


  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>





<canvas id="myChart2" width="400" height="400"></canvas>
<script>
var ctx = document.getElementById('myChart2');
var myChart2 = new Chart(ctx, {
    type: 'pie',
      data: data,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Chart.js Pie Chart'
          }
        }
      },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>





















</div>

</div>


</div>


</main>

<?php

require 'footer.php';

?>
