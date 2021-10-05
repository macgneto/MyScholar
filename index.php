<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/main/config.php");

require 'includes/init.php';

Auth::requireLogin();

$conn = require 'includes/db.php';

session_start();

if ($_SESSION['user_role'] == "student" || $_GET['user_id'] == $_SESSION['user_id']) {
}


$active_students = Student::getAllStudentsActiveRows($conn);

$inactive_students = Student::getAllStudentsInactiveRows($conn);

$total_courses = General::getCount($conn, '*', 'course');

$total_classrooms = General::getCount($conn, '*', 'class');

require 'header.php';

require 'sidebar.php';

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb  py-1">

                        <h3 class="mx-3 mt-3 mb-2"><i class="far fa-smile-wink mr-1"></i> Καλώς ήρθες
                            <b><?php echo $_SESSION['user_username'] ?></b></h3>

                        <ol class="breadcrumb m-3 ">
                            <li class="breadcrumb-item active">Αρχική</li>
                        </ol>
                    </div>
                </div>
            </div>

            <br>



            <?php if (Auth::isAdmin()): ?>


            <div class="row">


                <!-- Students -->
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4 border-button">
                        <div class="card-body">Μαθητές</div>
                        <div class="card-body">Σύνολο : <strong><?= $active_students+$inactive_students;?></strong>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link " href="student.php">Λεπτομέρειες</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4 border-button">
                        <div class="card-body">Καθηγητές</div>
                        <div class="card-body">Σύνολο : <strong><?php echo $active_students; ?></strong></div>

                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link " href="teachers.php">Λεπτομέρειες</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-purple text-white mb-4 border-button">
                        <div class="card-body">Μαθήματα</div>
                        <div class="card-body">Σύνολο : <strong><?= $total_courses;?></strong></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="courses.php">Λεπτομέρειες</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4 border-button">
                        <div class="card-body ">Τμήματα</div>
                        <!-- <hr class="m-0 p-0"> -->
                        <div class="card-body">Σύνολο: <strong><?= $total_classrooms;?></strong></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="classrooms.php">Λεπτομέρειεςhaha</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>


                <!-- 222222 -->
                <!-- <div class="col-xl-6 col-md-6">

                <div class="card h-100 ">
                    <div class="card-body">
                        <div class="d-flex justify-content-center"><b>Διδακτικές Ώρες</b></div>
                        <hr>
                        <canvas id="myChart" width="400" height="160"></canvas>
                        <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                datasets: [{
                                    label: '# of Votes',
                                    data: [12, 19, 3, 5, 2, 3],
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

        </div> -->







                <?php

// total_incomes calculates the total money from all hours tha we calculate as income
$total_incomes = Charts::getInfoAboutMoney($conn);

    $total_money = 0;
    $p = 0;
    $u = 0;
    $x = 0;
foreach ($total_incomes as $total_income) {
    if ($total_income['sc_special_cost'] == 0) {
        $x = (($total_income['course_cost_hour_student']) * ($total_income['attendance_duration']));

        $total_money = $total_money + $x;
        $p = $p + 1 ;
    } else {
        $x = (($total_income['sc_special_cost']) * ($total_income['attendance_duration']));
        $total_money = $total_money +  $x;
        $u = $u + 1;
    }
}

// echo $p;
// echo "<br>";
// echo $u;
// echo "<br>";
// echo $total_money;
// echo "<br>";
// echo $x;

    // total payments we have received
    $money_paid = Charts::sumTotalPayments($conn);
    // var_dump($money_paid);

    // money we expect
    $money_unpaid = $total_money - $money_paid ;
?>
                <!-- 111111 -->
                <!-- <div class="col-xl-3 col-md-3">

                <div class="card  ">
                    <div class="card-body">
                        <div class="d-flex justify-content-center"><b>Οικονομικά Στοιχεία</b></div>
                        <hr>
                        <canvas id="myChart2" width="200" height="100"></canvas>
                        <script>
                        var ctx = document.getElementById('myChart2').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Πληρωμές', 'Εκκρεμότητες'],
                                datasets: [{
                                    label: 'Euros',
                                    data: [<?= ($money_paid); ?>, <?= $money_unpaid; ?>],
                                    backgroundColor: [
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                        // 'rgba(54, 162, 235, 0.2)',
                                        // 'rgba(255, 206, 86, 0.2)',

                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(255, 99, 132, 1)',
                                        // 'rgba(54, 162, 235, 1)',
                                        // 'rgba(255, 206, 86, 1)',

                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                              responsive: true,
                              plugins: {
                                legend: {
                                  position: 'top',
                                },
                                title: {
                                  display: false,
                                  text: 'Chart.js Doughnut Chart'
                                }
                              }
                            },
                        });
                        </script>


                    </div>
                </div>

        </div> -->




            </div>

            <?php endif; ?>


            <?php

            if (Auth::isStudent()):
                $notification = new Attendance();
                $nots = $notification->notificationAttendance($conn, $_SESSION['user_id']);
                ?>
            <?php if (empty($nots)): ?>
            <div class="alert alert-success" role="alert">
                <p>Δεν έχετε ανεπιβεβαίωτες παρουσίες στην καρτέλα σας.</p>
            </div>
            <?php else: ?>

            <?php foreach ($nots as $not) : ?>
            <div class="alert alert-warning" role="alert">
                <p>'Εχετε μη-επιβεβαιωμένες παρουσίες στο μάθημα : <a
                        href="http://myscholar.ddns.net/main/student/student-course-view.php?id=<?= $not['sc_id']; ?>"><?= $not['course_title'] ?></a>
                </p>

            </div>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php endif; ?>





            <?php if (Auth::isAdmin()) {
                    // echo "Admin";
                } elseif (Auth::isTeacher()) {
                    // echo "Teacher";
                } elseif (Auth::isSecretary()) {
                    // echo "Gramateas";
                } elseif (Auth::isStudent()) {








    // echo "Student";
    // echo "</br>";
    // echo $_SESSION['user_id'];
                }
?>




        </div>



    </main>



    <?php

require 'footer.php';
?>