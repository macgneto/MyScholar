<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';



if (isset($_GET['id'])) {
    $teacher_course_teacher = StudentCourses::getStudentCourseTeacherInfoByID($conn, $_GET['id']);
}


$teacher_course = TeacherCourses::getTeacherCourseInfobyId($conn, $_GET['id']);

$teacher_course_classes = TeacherCourses::getTeacherClasses($conn, $_GET['id']);

$classes = Classes::getAllClasses($conn);

// $test = $_GET['id'];

$teacher_classes = TeacherCourses::getTeacherClasses($conn, $_GET['id']);




// <!--====== Variables definitions needed for our code ======-->

$hours_present = StudentCourses::getHoursPresent($conn, $teacher_course -> sc_teacher_id, $teacher_course -> sc_class_id);

$hours_absent = StudentCourses::getHoursAbsent($conn, $teacher_course -> sc_teacher_id, $teacher_course -> sc_class_id);

$hours_verified = StudentCourses::getHoursVerified($conn, $teacher_course -> sc_teacher_id, $teacher_course -> sc_class_id);

$hours_unverified = StudentCourses::getHoursUnverified($conn, $teacher_course -> sc_teacher_id, $teacher_course -> sc_class_id);

$hours_total = intval($hours_present) + intval($hours_absent);

$verification_requests = StudentCourses::getUnverifiedRequests($conn, $teacher_course -> sc_teacher_id, $teacher_course -> sc_class_id);

$total_teaching_hours_per_class = 0;

$total_teaching_hours_per_course = 0;

$total_teaching_classes_completed = 0;

require '../header.php';

require '../sidebar.php';

require 'modals.php';

// <!--====== Calculating hours for teacher ======-->
foreach ($teacher_classes as $teacher_class) {
    $total_teaching_hours_per_class = 0;
    // $total_teaching_classes_completed = 0;

    $teacher_class_attendances = TeacherCourses::getTeacherClassAttendances($conn, $teacher_course->teacher_id, $teacher_class["class_id"]);

    $count_teacher_class_attendances = TeacherCourses::getCountTeacherClassAttendances($conn, $teacher_course->teacher_id, $teacher_class["class_id"]);

    foreach ($teacher_class_attendances as $teacher_class_attendance) {
        $total_teaching_hours_per_class = $total_teaching_hours_per_class + $teacher_class_attendance['max_attendance_duration'] ;
        // $total_teaching_classes_completed = $total_teaching_classes_completed + $count_teacher_class_attendances;
    }

    $total_teaching_hours_per_course = $total_teaching_hours_per_course + $total_teaching_hours_per_class;

    $total_teaching_classes_completed = $total_teaching_classes_completed + $count_teacher_class_attendances;
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <!-- ====== Breadcrumbps Top START ====== -->
            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb  py-1">

                        <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-user-tie mr-1"></i>  Καρτέλα Καθηγητή : <span class="badge bg-success text-white"> <?= $teacher_course ->teacher_lastname ." ".  $teacher_course ->teacher_firstname; ?></span></h3>

                        <ol class="breadcrumb m-3 ">
                            <li class="breadcrumb-item"><a class="text-success" href="<?= basedir ?>index.php">Αρχική</a></li>
                            <li class="breadcrumb-item"><a class="text-success" href="<?= basedir ?>teachers.php">Καθηγητές </a></li>
                            <li class="breadcrumb-item"><a class="text-success" href="<?= basedir ?>teacher/teacher-profile.php?id=<?= $teacher_course -> teacher_id ?>">Καρτέλα Καθηγητή</a></li>
                            <li class="breadcrumb-item active">Πληροφορίες Μαθήματος</li>
                        </ol>

                    </div>
                </div>
            </div>

            <br>
            <!-- ====== Breadcrumbps Top END ====== -->

            <!-- ====== Menu Top START ====== -->
            <nav class="skew-menu teacher">
                <ul>
                    <li class=""><a class="" href="teacher-profile.php?id=<?= $teacher_course -> teacher_id; ?>"><i class="fas fa-user"></i>&nbsp&nbspΠροφίλ</a></li>
                    <li class="active"><a class="" href="teacher-courses.php?id=<?= $teacher_course -> teacher_id; ?>"><i class="fas fa-book-open"></i>&nbsp&nbspΜαθήματα</a></li>
                </ul>
            </nav>
            <!-- ====== Menu Top END ====== -->


            <!-- ====== Script for screen messages START ====== -->
            <script>
            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 3000);
            </script>


            <!-- Success message on edit teacher -->
            <?php if (isset($_SESSION['success_verify_attendance_message']) && !empty($_SESSION['success_verify_attendance_message'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Αποθήκευση!</strong> Οι αλλαγές καταχωρήθηκαν επιτυχώς.
                    <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                unset($_SESSION['success_verify_attendance_message']);
            }
            ?>

            <!-- Warning message on edit teacher -->
            <?php if (isset($_SESSION['fail_edit_message']) && !empty($_SESSION['fail_edit_message'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Αποτυχία!</strong> Οι αλλαγές δεν καταχωρήθηκαν. Υπήρξε πρόβλημα με την αποθήκευση στη βάση δεδομένων.
                    <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                unset($_SESSION['fail_edit_message']);
            }
            ?>

            <!-- Warning message on add teacher -->
            <?php if (isset($_SESSION['fail_add_message']) && !empty($_SESSION['fail_add_message'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Αποτυχία!</strong> Οι αλλαγές δεν καταχωρήθηκαν. Υπήρξε πρόβλημα με την αποθήκευση στη βάση δεδομένων.
                    <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                unset($_SESSION['fail_add_message']);
            }
            ?>
            <!-- ====== Script for screen messages END ====== -->


            <!-- ====== CARDS BEGIN ====== -->
          	<div class="row mt-3">

                <!-- ====== TEACHER CARD BEGIN ====== -->
          		<div class="col-md-4 mb-3">
          			<div class="card h-100 gradient-bg-green-light">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">

                                <?php if ($teacher_course-> teacher_photo) : ?>
                                    <img src="<?= basedir ?>uploads/<?= $teacher_course -> teacher_photo ?>" alt="Admin" class="rounded-circle border-success" width="180">
                                <?php else: ?>
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle border-success" width="180">
                                <?php endif; ?>

                                <div class="mt-3">
                                    <h5><?= ($teacher_course-> teacher_lastname); ?> <?= ($teacher_course-> teacher_firstname); ?></h5>
                                    <p class="text-secondary font-size-sm"><i class="far fa-envelope text-success"></i>&nbsp<?= ($teacher_course-> teacher_email); ?></p>
                                    <p class="text-secondary font-size-sm"><i class="fas fa-phone-alt text-success"></i>&nbsp<?= ($teacher_course-> teacher_mobile_phone); ?></p>
                                </div>
                            </div>

                        </div>
          	         </div>
                </div>
                <!-- ====== TEACHER CARD END ====== -->

                <!-- ====== SECOND COLUMN COURSE AND COST AND HOURS CARDS BEGIN ====== -->
                <div class="col-md-8 col-sm-12 mb-3">

                    <!-- ====== COURSE CARD BEGIN ====== -->
          			<div class="row">
          				<div class="col-md-12 col-sm-12">
          					<div class="card h-100 gradient-bg-purple-light">
                                <div class="card-body ">
                                    <div class="row ">
                                        <div class="col-3">
                                            <div class="d-flex flex-column  align-items-center text-center mt-3">
                                                <?php if ($teacher_course-> course_photo) : ?>
                                                    <img src="<?= basedir ?>uploads/<?= $teacher_course -> course_photo ?>" alt="photo" class="rounded-circle" width="70">
                                                <?php else: ?>
                                                    <img src="<?= basedir ?>uploads/course_default_photo.png" alt="photo" class="rounded-circle" width="70">
                                                <?php endif; ?>
                                                <div class="mt-3">
                                                    <h6><a href="<?= basedir ?>course/course-view.php?id=<?= $teacher_course -> tc_course_id; ?>"><span class="badge badge-purple">Μάθημα</span></a></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-9 ">
                                            <div class="row">
                                                <div class="col-sm-12 text-secondary">
                                                    <h6><i class="fas fa-book-open text-purple"></i>&nbsp&nbsp<?= ($teacher_course-> course_code); ?> </h6>
                                                    <hr>
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-sm-12 text-secondary">
                                                    <h6><i class="fas fa-info-circle text-purple"></i>&nbsp&nbsp<?= ($teacher_course-> course_title); ?></h6>
                                                    <hr>
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-sm-12 text-secondary">
                                                    <h6><i class="fas fa-th-list text-purple"></i>&nbsp&nbsp<?= ($teacher_course-> course_description); ?></h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
          				    </div>
                        </div>
                    </div>
                    <!-- ====== COURSE CARD END ====== -->

                    <!-- ====== SECOND ROW CARD BEGIN ====== -->
                    <div class="row mt-4">

                        <!-- FIRST CARD ΔΙΔΑΚΤΙΚΕΣ ΩΡΕΣ BEGIN -->
                        <div class="col-6">
                            <div class="card h-100 gradient-bg-blue-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center"><b>Διδακτικές Ώρες</b></div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex bd-highlight">Σύνολο ωρών:</div>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-end text-primary"><?= ($total_teaching_hours_per_course) ;?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex bd-highlight">Συνεδρίες:</div>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-end text-success"><?= $total_teaching_classes_completed ;?></div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex bd-highlight">Απουσίες:</div>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex text-danger"><?= ($hours_absent) ;?></div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- FIRST CARD ΔΙΔΑΚΤΙΚΕΣ ΩΡΕΣ END -->

                        <!-- SECOND CARD ΚΟΣΤΟΣ BEGIN -->
                        <div class="col-6">
                            <div class="card h-100 gradient-bg-orange-light">
                                <div class="card-body">

                                    <div class="d-flex justify-content-center"><b>Κόστος</b></div>

                                    <hr>
                                    <?php foreach ($teacher_classes as $teacher_class) : ?>


                                        <?php $total_teaching_hours_per_class = 0; ?>

                                        <?php

                                            $teacher_class_attendances = TeacherCourses::getTeacherClassAttendances($conn, $teacher_course->teacher_id, $teacher_class["class_id"]);

                                            $count_teacher_class_attendances = TeacherCourses::getCountTeacherClassAttendances($conn, $teacher_course->teacher_id, $teacher_class["class_id"]);

                                            foreach ($teacher_class_attendances as $teacher_class_attendance) {
                                                $total_teaching_hours_per_class = $total_teaching_hours_per_class + $teacher_class_attendance['max_attendance_duration'] ;
                                            }

                                            // $total_teaching_hours_per_course = $total_teaching_hours_per_course + $total_teaching_hours_per_class;
                                                // $total_teaching_hours_per_course = $total_teaching_hours_per_course ;
                                        ?>
                                    <?php endforeach; ?>
                                    <?php

                                    // echo $total_teaching_hours_per_course*$teacher_course -> course_cost_hour_teacher;
                                    // echo $total_teaching_hours_per_class;
                                    ?>



                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex bd-highlight">Σύνολο:</div>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-center text-primary">
                                                &euro;
                                                <!-- <?php  if ($teacher_course -> sc_special_cost == "0") {
                                        $total_cost = $hours_verified * ($teacher_course-> course_cost_hour_teacher);
                                    } else {
                                        $total_cost = $hours_verified * ($teacher_course-> sc_special_cost);
                                    }
            echo $total_cost;
            var_dump($teacher_course -> sc_special_cost);
            ?> -->
            <?php echo $total_teaching_hours_per_course*$teacher_course -> course_cost_hour_teacher; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex bd-highlight">Πληρωμένο:</div>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-center text-success">
                                                &euro;
                                                <?php
                                                $paid = Payment::getPaymentInfoById($conn, $_GET['id']);
                                                if ($paid[0]=="") {
                                                    echo "0";
                                                } else {
                                                    echo $paid[0];
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex bd-highlight">Υπόλοιπο:</div>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-center text-danger">
                                                &euro;
                                                <?php
                                                $remaining_cost = $total_cost - $paid[0];
                                                echo $remaining_cost;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ====== SECOND ROW CARD END ====== -->

                </div>
                <!-- ====== SECOND COLUMN COURSE AND COST AND HOURS CARDS BEGIN ====== -->

            </div>
            <!-- ====== CARDS END ====== -->



            <!-- ====== TEACHER CLASSROOMS CARDS BEGIN ====== -->
            <?php if (!empty($teacher_classes)) : ?>    <!-- Checking if we dont have classrooms then do not show divider -->

            <!-- HR WITH TITLE BEGIN  -->
            <div class="row">
                <div class="col-lg-12 mx-auto">

                    <div class="mt-4">
                        <!-- Gradient divider -->
                        <hr data-content="Τμήματα" class="hr-text">
                    </div>

                </div>
            </div>
            <!-- HR WITH TITLE END  -->

            <br>

            <?php endif; ?>

            <div class="row gutters-sm">

                <?php
                $total_teaching_hours_per_class = 0;
                $total_teaching_hours_per_course = 0;

                ?>
                <?php foreach ($teacher_classes as $teacher_class) : ?>


                    <?php $total_teaching_hours_per_class = 0; ?>

                    <?php

                        $teacher_class_attendances = TeacherCourses::getTeacherClassAttendances($conn, $teacher_course->teacher_id, $teacher_class["class_id"]);

                        $count_teacher_class_attendances = TeacherCourses::getCountTeacherClassAttendances($conn, $teacher_course->teacher_id, $teacher_class["class_id"]);

                        foreach ($teacher_class_attendances as $teacher_class_attendance) {
                            $total_teaching_hours_per_class = $total_teaching_hours_per_class + $teacher_class_attendance['max_attendance_duration'] ;
                        }

                        $total_teaching_hours_per_course = $total_teaching_hours_per_course + $total_teaching_hours_per_class;

                    ?>

                    <div class="col-xl-4 mb-4">
                        <div class="card  lift " href="student-course-view.php?id=<?= $teacher_class["class_id"]; ?>">
                            <div class="card-body d-flex justify-content-center flex-column mb-3">

                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="me-3">

                                        <h5 class="text-purple"><a class="text-info" href="<?= basedir ?>class/class-view.php?id=<?= $teacher_class['class_id']; ?>"><?= ($teacher_class['class_code']) ?></a></h5>
                                        <br>
                                        <div class=" text-info small"><?= ($teacher_class['class_name']) ?></div>
                                        <br>
                                        <div class="text-muted small"><?= ($teacher_class['class_description']) ?></div>

                                    </div>

                                    <img class="rounded-circle border-info" src="<?= basedir ?>images/classroom_icon.png" alt="..." style="width: 6rem "/>

                                </div>

                            </div>

                            <hr>

                            <div class="row m-1 mb-2">
                                <div class="col-8">
                                    Ώρες Διδασκαλίας:
                                </div>

                                <div class="col-4">
                                    <?= $total_teaching_hours_per_class ; ?>
                                </div>
                            </div>

                            <div class="row m-1 mb-2">
                                <div class="col-8">
                                    Συνεδρίες:
                                </div>

                                <div class="col-4">
                                    <?= $count_teacher_class_attendances ; ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <p>
                                    <a class="" data-toggle="collapse" href="#collapseExample-<?= $teacher_class["class_id"]; ?>" role="button" aria-expanded="false" aria-controls="collapseExample">

                                    </a>

                                </p>


                            </div>

                            <script>
                            $(document).ready( function () {
                                $('#dataTable-<?= $teacher_class["class_id"]; ?>').DataTable();
                            } );
                            </script>
                            <!-- <div class="collapse" id="collapseExample-<?= $teacher_class["class_id"]; ?>"> -->

                            <div class=" card-body">

                                <!-- Button trigger modal -->
                                <div class="text-center">

                                    <button type="button" class="btn btn-sm btn-info border-button" data-toggle="modal" data-target="#modal-<?= $teacher_class["class_id"]; ?>">
                                        Διδακτικές Ώρες
                                    </button>

                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="modal-<?= $teacher_class["class_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Διδακτικές ώρες</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive  ">
                                                    <table class="table table-bordered table-pink table-hover bg-light  full-gradient-bg-purple border-radius-7" id="dataTable-<?= $teacher_class["class_id"]; ?>" width="100%" cellspacing="0">
                                                        <thead >
                                                            <div class="mb-2 text-pink ">
                                                                <h6 class="text-center">
                                                                    <i class="fas fa-list-ul"></i>
                                                                    Λίστα Διακτικών Ωρών
                                                                </h6>
                                                            </div>
                                                            <tr>
                                                                <th class="text-center align-middle">A/A</th>
                                                                <th class="text-center align-middle">Ημερομηνία</th>
                                                                <th class="text-center align-middle">Ώρες</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                            <?php if (empty($teacher_class_attendances)): ?>

                                                                <tr>

                                                                    <td colspan="7" align="center"><b>Δεν υπάρχουν δεδομένα.</b></td>

                                                                </tr>

                                                            <?php else: ?>
                                                                <?php $aa = 0; ?>
                                                                <?php foreach ($teacher_class_attendances as $teacher_class_attendance) : ?>
                                                                    <tr>
                                                                        <td width="40px" class="text-center align-middle"><?php echo $aa = $aa + 1;  ?></td>
                                                                        <td class="text-dark text-center align-middle"><?= date('d/m/Y', strtotime($teacher_class_attendance['attendance_date'])) ; ?></a></td>
                                                                        <td class="text-dark text-center align-middle"><?= $teacher_class_attendance['max_attendance_duration'] ; ?></td>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">

                                            <button type="button" class="btn btn-secondary border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΠίσω</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </main>

<?php require '../footer.php'; ?>
