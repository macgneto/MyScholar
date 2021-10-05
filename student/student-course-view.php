<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';


if (Auth::isTeacher()) {
    Url::redirect("/main/index.php");
}

if (isset($_GET['id'])) {
    // $student_course_teacher = StudentCourses::getStudentCourseTeacherInfoByID($conn, $_GET['id']);
}


$payments_history = Payment::getPaymentHistoryById($conn, $_GET['id']);
$student_course = StudentCourses::getStudentCourseΙnfoByID($conn, $_GET['id']);

// var_dump($student_course);


// $hours_total = StudentCourses::getHoursPresent($conn, $student_course -> sc_student_id, $student_course -> sc_class_id);

$hours_present = StudentCourses::getHoursPresent($conn, $student_course -> sc_student_id, $student_course -> sc_class_id);
$hours_absent = StudentCourses::getHoursAbsent($conn, $student_course -> sc_student_id, $student_course -> sc_class_id);
$hours_verified = StudentCourses::getHoursVerified($conn, $student_course -> sc_student_id, $student_course -> sc_class_id);
$hours_unverified = StudentCourses::getHoursUnverified($conn, $student_course -> sc_student_id, $student_course -> sc_class_id);

$hours_total = intval($hours_present) + intval($hours_absent);
// var_dump($hours_total);


// fetch all the attendances history to display in the Attendance History Card
$student_course_attendances = StudentCourses::getStudentCourseAttendancesById($conn, $_GET['id']);



$verification_requests = StudentCourses::getUnverifiedRequests($conn, $student_course -> sc_student_id, $student_course -> sc_class_id);
// var_dump($verification_requests);
require '../header.php';

require '../sidebar.php';

require 'modals.php';
?>

    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid bgbgbg">
            <!-- <br> -->




            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb  py-1">

                        <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-table mr-1 fa-user-graduate"></i>  Καρτέλα Μαθητή : <span class="badge bg-primary text-white"> <?= $student_course ->student_lastname ." ".  $student_course ->student_firstname; ?></span></h3>

                        <!-- <ol class="breadcrumb m-2 border-bottom-radius-7"> -->
                            <ol class="breadcrumb m-3 ">
                                <li class="breadcrumb-item"><a href="<?= basedir ?>index.php">Αρχική</a></li>
                                <li class="breadcrumb-item"><a href="<?= basedir ?>student.php">Μαθητές </a></li>
                                <li class="breadcrumb-item"><a href="<?= basedir ?>student/student-profile.php?id=<?= $student_course -> student_id ?>">Καρτέλα Μαθητή</a></li>
                                <li class="breadcrumb-item active">Πληροφορίες Μαθήματος</li>
                        </ol>
                    </div>
                </div>
            </div>


            <br>





            <nav class="skew-menu">
              <ul>
                <li class=""><a class="" href="student-profile.php?id=<?= $student_course -> student_id; ?>"><i class="fas fa-user"></i>&nbsp&nbspΠροφίλ</a></li>
                <li class="active"><a class="" href="student-courses.php?id=<?= $student_course -> student_id; ?>"><i class="fas fa-book-open"></i>&nbsp&nbspΜαθήματα</a></li>
                <!-- <li><a href="#">Shirts</a></li>
                <li><a href="#">Jackets</a></li> -->
              </ul>
            </nav>




<script>
window.setTimeout(function() {
    $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>
<!-- Success message on edit student -->
<?php if (isset($_SESSION['success_verify_attendance_message']) && !empty($_SESSION['success_verify_attendance_message'])) { ?>
    <div class="alert alert-success alert-dismissible fade show border-success" role="alert">
        <strong>Αποθήκευση!</strong> Οι αλλαγές καταχωρήθηκαν επιτυχώς.
        <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    unset($_SESSION['success_verify_attendance_message']);
    echo "<br>";
}
?>

<!-- Warning message on edit student -->
<?php if (isset($_SESSION['fail_edit_message']) && !empty($_SESSION['fail_edit_message'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show border-danger" role="alert">
        <strong>Αποτυχία!</strong> Οι αλλαγές δεν καταχωρήθηκαν. Υπήρξε πρόβλημα με την αποθήκευση στη βάση δεδομένων.
        <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    unset($_SESSION['fail_edit_message']);
    echo "<br>";
}
?>

<!-- Warning message on edit student -->
<?php if (isset($_SESSION['fail_add_message']) && !empty($_SESSION['fail_add_message'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show border-danger" role="alert">
        <strong>Αποτυχία!</strong> Οι αλλαγές δεν καταχωρήθηκαν. Υπήρξε πρόβλημα με την αποθήκευση στη βάση δεδομένων.
        <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    unset($_SESSION['fail_add_message']);
    echo "<br>";
}
?>

<!-- Warning message on success edit payment history -->
<?php if (isset($_SESSION['success_add_message']) && !empty($_SESSION['success_add_message'])) { ?>
    <div class="alert alert-success alert-dismissible fade show border-success" role="alert">
        <strong>Επιτυχία!</strong> Οι αλλαγές καταχωρήθηκαν επιτυχώς.
        <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    unset($_SESSION['success_add_message']);
    echo "<br>";
}
?>






<?php
    if (Auth::isAdmin()|| Auth::isSecretary()):
?>
                <div class="">

                        <button type="button" class="btn  btn-success border-button border-grey border-radius-4" data-toggle="modal" data-target="#add-payment-modal">
                          <i class="fas fa-plus"></i>&nbsp&nbspΠληρωμή
                        </button>
                        <button type="button" class="btn  btn-primary border-button border-grey " data-toggle="modal" data-target="#add-cost-modal">
                          <i class="fas fa-euro-sign"></i>&nbsp&nbspΚόστος
                        </button>
                        <!-- <button type="button" class="btn btn-sm btn-info border-button border-grey border-radius-7" data-toggle="modal" data-target="#add-payment-modal">
                          <i class="fas fa-history"></i>&nbsp&nbspΙστορικό Πληρωμών
                        </button> -->

                </div>
<?php endif; ?>





               <div class="row mt-3">
                   <div class="col-md-4 mb-3">
                       <div class="card h-100 gradient-bg-blue">
                           <div class="card-body">
                               <div class="d-flex flex-column align-items-center text-center">

                                   <?php if ($student_course-> student_photo) : ?>
                                       <img src="<?= basedir ?>uploads/<?= $student_course -> student_photo ?>" alt="Admin" class="rounded-circle border-primary" width="180">
                                   <?php else: ?>
                                       <img src="<?= basedir ?>images/avatar.png" alt="Admin" class="rounded-circle border-primary" width="180">
                                   <?php endif; ?>

                                   <div class="mt-3">
                                       <h5><?= ($student_course-> student_lastname); ?> <?= ($student_course-> student_firstname); ?></h5>

                                   </div>

                              <div class="mt-3">
                                  <p class="text-secondary font-size-sm">Μαθητής</p>
                                  <p class="text-secondary font-size-sm mt-2"><i class="far fa-envelope text-primary"></i>&nbsp<?= ($student_course-> student_email); ?></p>
                                  <p class="text-secondary font-size-sm"><i class="fas fa-phone-alt text-primary"></i>&nbsp<?= ($student_course-> student_mobile_phone); ?></p>
                              </div>
                               </div>

                           </div>
                        </div>
                   </div>



                   <div class="col-md-8 col-sm-12 mb-3">
                       <div class="row">

                           <div class="col-md-9 col-sm-12">
                               <div class="card h-100 gradient-bg-purple-light">
                                   <div class="card-body ">
                                       <div class="row ">

                                           <div class="col-3 d-flex   justify-content-center  align-items-center">
                                               <div class="d-flex flex-column  align-items-center ">
                                                   <?php if ($student_course-> course_photo) : ?>
                                                       <img src="<?= basedir ?>uploads/<?= $student_course -> course_photo ?>" alt="photo" class="rounded-circle " width="80">
                                                   <?php else: ?>
                                                       <img src="<?= basedir ?>uploads/course_default_photo.png" alt="photo" class="rounded-circle " width="80">
                                                   <?php endif; ?>
                                                   <div class="mt-3">
                                                       <h6><a href="<?= basedir ?>course/course-view.php?id=<?= $student_course -> sc_course_id; ?>"><span class="badge badge-purple">Μάθημα</span></a></h6>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-9 ">
                                               <div class="row">
                                                   <div class="col-sm-12 text-secondary">
                                                       <h6><i class="fas fa-book-open text-purple"></i>&nbsp&nbsp<?= ($student_course-> course_code); ?> </h6>
                                                       <hr>
                                                   </div>
                                               </div>

                                               <div class="row mt-1">
                                                   <div class="col-sm-12 text-secondary">
                                                       <h6><i class="fas fa-info-circle text-purple"></i>&nbsp&nbsp<?= ($student_course-> course_title); ?></h6>
                                                       <hr>
                                                   </div>
                                               </div>

                                               <div class="row mt-1">
                                                   <div class="col-sm-12 text-secondary">
                                                       <h6><i class="fas fa-th-list text-purple"></i>&nbsp&nbsp<?= ($student_course-> course_description); ?></h6>
                                                   </div>
                                               </div>
                                           </div>

                                       </div>
                                   </div>
                               </div>
                           </div>


                           <div class="col-md-3">
                               <div class="row mb-0">
                                   <div class="col-md-12 col-sm-12">
                                       <!-- <div class="card h-100 gradient-bg-purple-light"> -->
                                           <!-- <div class="card-body "> -->
                                               <?php if ($student_course -> sc_special_cost == "0") : ?>
                                                   <div class="card bg-success text-white mb-4 border-button">
                                               <?php else:?>
                                                   <div class="card bg-secondary text-white mb-4 border-button">
                                               <?php endif; ?>
                                                   <div class="card-statistic-3 p-3">

                                                       <div class="mb-2">
                                                           <h6 class="card-title mb-0">Κανονική Τιμή</h6>
                                                       </div>
                                                       <div class="row align-items-center mb-2 d-flex">
                                                           <div class="col-6">
                                                               <h6 class="d-flex align-items-top mb-0">
                                                                   <?php if ($student_course -> sc_special_cost == "0") : ?>
                                                                       &euro; <?= ($student_course-> course_cost_hour_student);?>
                                                                   <?php else:?>
                                                                       &euro; <?= ($student_course-> course_cost_hour_student);?>
                                                                   <?php endif; ?>
                                                               </h6>
                                                           </div>
                                                           <div class="col-6 text-right">
                                                               <span>ώρα</span>
                                                           </div>
                                                       </div>

                                                   </div>
                                               </div>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                    </div>
                               </div>
                               <div class="row mb-0">
                                   <div class="col-md-12 col-sm-12">
                                       <!-- <div class="card h-100 gradient-bg-purple-light">
                                           <div class="card-body "> -->


                                               <?php if ($student_course -> sc_special_cost != "0") : ?>
                                                   <div class="card bg-success text-white mb-0 border-button">

                                                       <?php else:?>
                                               <div class="card bg-secondary text-white mb-0 border-button">
                                           <?php endif; ?>
                                               <div class="card-statistic-3 p-3">

                                                   <div class="mb-2">
                                                       <h6 class="card-title mb-0">Ειδική Τιμή</h6>
                                                   </div>
                                                   <div class="row align-items-center mb-2 d-flex">
                                                       <div class="col-6">
                                                           <h6 class="d-flex align-items-center mb-0">
                                                               <?php if ($student_course -> sc_special_cost != "0") : ?>

                                                             &euro; <?= ($student_course-> sc_special_cost);?>
                                                           <?php else:?>
                                                             ---
                                                           <?php endif;?>
                                                       </h6>
                                                       </div>
                                                       <div class="col-6 text-right">
                                                           <?php if ($student_course -> sc_special_cost != "0") : ?>

                                                         <span><?php if ($student_course -> sc_cost_type == "hour") {
    echo "ώρα";
} else {
    echo "μήνα";
} ?></span>
                                                       <?php else:?>
                                                           <span>&nbsp</span>
                                                       <?php endif;?>

                                                       </div>
                                                   </div>

                                               </div>

                                            </div>


                                            <!-- </div>
                                        </div> -->
                                    </div>
                               </div>
                           </div>

                       </div>

                       <!-- l-bg-blue-dark   l-bg-orange -->

                       <div class="row mt-4">

                           <!-- first card -->
                           <div class="col-6">
                               <div class="card gradient-bg-green-light h-100">
                                           <div class="card-body">
                                               <div class="row">
                                                   <div class="col-3 ">

                                                       <div class="d-flex flex-column align-items-center text-center mt-3">



                                                           <?php if ($student_course-> teacher_photo) : ?>
                                                               <img src="<?= basedir ?>uploads/<?= $student_course->teacher_photo ?>" alt="photo" class="rounded-circle border-success" width="60">
                                                           <?php else: ?>
                                                               <img src="<?= basedir ?>images/avatar.png" alt="photo" class="rounded-circle border-success" width="60">
                                                           <?php endif; ?>




                                                           <div class="mt-3">
                                                               <h6><a href="<?= basedir ?>teacher/teacher-profile.php?id=<?= $student_course -> teacher_id; ?>" ><span class="badge badge-success badge-hover">Καθηγητής</span></a></h6>
                                                           </div>
                                                       </div>
                                                   </div>

                                                   <div class="col-9 ">
                                                       <div class="row">
                                                           <div class="col-sm-12 text-secondary">
                                                               <h6><i class="fas fa-user-tie text-success"></i>&nbsp&nbsp<?= ($student_course-> teacher_lastname); ?> <?= ($student_course-> teacher_firstname); ?></h6>
                                                               <hr>
                                                           </div>
                                                       </div>

                                                       <div class="row mt-1 ">
                                                           <div class="col-sm-12 text-secondary">
                                                               <h6><i class="far fa-envelope text-success"></i>&nbsp&nbsp<?= ($student_course-> teacher_email); ?></h6>
                                                               <hr>
                                                           </div>

                                                       </div>

                                                       <div class="row mt-1">
                                                           <div class="col-sm-12 text-secondary">
                                                               <h6><i class="fas fa-phone-alt text-success"></i>&nbsp&nbsp<?= ($student_course-> teacher_mobile_phone); ?></h6>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                           </div>

                           <!-- second card -->
                           <div class="col-6">
                               <div class="card  gradient-bg-blue-light h-100">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-3">
                                            <div class="d-flex flex-column align-items-center text-center mt-3">
                                                <!-- <img src="/admin/uploads/classroom_icon.png" alt="Admin" class="rounded-circle" width="60"> -->
                                                <img  src="<?= basedir ?>uploads/classroom_icon.png" alt="photo" class="rounded-circle border-info" width="60">
                                                <!-- <img class="rounded-circle border-info" src="<?= basedir ?>images/classroom_icon.png" alt="..." style="width: 6rem "/> -->
                                                <div class="mt-3">
                                                    <h6><a href="<?= basedir ?>class/class-view.php?id=<?= $student_course -> class_id; ?>" ><span class="badge badge-info">Τμήμα</span></a></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9 ">
                                            <div class="row">
                                                <div class="col-sm-12 text-secondary">
                                                    <h6><i class="fas fa-chalkboard text-info"></i></i>&nbsp&nbsp<?= ($student_course-> class_name); ?></h6>
                                                    <hr>
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-sm-12 text-secondary">
                                                    <h6><i class="fas fa-info-circle text-info"></i>&nbsp&nbsp<?= ($student_course-> class_code); ?></h6>
                                                    <hr>
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-sm-12 text-secondary">
                                                    <h6><i class="fas fa-th-list text-info"></i>&nbsp&nbsp<?= ($student_course-> class_description).""; ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           </div>
                       </div>




                   </div>

               </div>




















<?php if (!empty($verification_requests)): ?>
    <div class="row">
        <div class="col-lg-12 mx-auto">

            <div class="mt-4">

                <!-- Gradient divider -->
                <hr data-content="Εκκρεμείς Παρουσίες" class="hr-text">
            </div>

        </div>
    </div>
<!-- requests verification -->
<div class="card mb-4 mt-4">


    <div class="card-body">


    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-light border-radius display compact" id="dataTable" width="100%" cellspacing="0">

            <thead>

                <tr>
                    <th class="text-center align-middle">A/A</th>
                    <th class="text-center align-middle">Ημερομηνία</th>
                    <th class="text-center align-middle">Παρουσία</th>

                    <th class="text-center align-middle">Ώρες</th>
                    <th class="text-center align-middle">Κόστος / Ώρα</th>
                    <th class="text-center align-middle">Συνολικό Κόστος</th>
                    <th class="text-center align-middle">Ενέργειες</th>
                </tr>

            </thead>

            <tbody>

                <?php if (empty($verification_requests)): ?>
                    <tr>
                        <td colspan="7" align="center"><b>Δεν βρέθηκαν Εκκρεμή αιτήματα</b></td>
                    </tr>

                <?php else: ?>
                <?php $aa = 0; ?>
                <?php foreach ($verification_requests as $verification_request) : ?>


                    <tr>
                        <td width="40px" class="text-center align-middle"><?php echo $aa = $aa + 1;  ?></td>
                        <td class="text-center align-middle">
                            <?php
                            $verification_request_datetime = '<i class="fas fa-calendar-day"></i>' . " " . date('d-m-Y', strtotime($verification_request["attendance_date"])) . ' &nbsp  <i class="far fa-clock"></i> ' . date('H:i', strtotime($verification_request["attendance_date"]))
                            ?>

                            <?= $verification_request_datetime; ?>

                        </td>
                        <td class="text-center align-middle"><span class="badge badge-success"><?= $verification_request["attendance_status"]; ?></span></td>
                        <td class="text-center align-middle"><?= $verification_request["attendance_duration"]; ?></td>
                        <td class="text-center align-middle">
                            &euro; <?php  if ($student_course -> sc_special_cost == "0") {
    echo  $student_course-> course_cost_hour_student;
} else {
    echo $student_course-> sc_special_cost;
}?>
                        </td>
                        <td class="text-center align-middle"><a href="class/class-view.php?id=<?= $verification_request["class_id"]; ?>">
                            &euro; <?php  if ($student_course -> sc_special_cost == "0") {
    echo  $verification_request["attendance_duration"]*$student_course-> course_cost_hour_student;
} else {
    echo $verification_request["attendance_duration"]* $student_course-> sc_special_cost;
}?>
                        </td>
                        <td class=" text-center align-middle">

                            <!-- Button HTML to verify Attendance -->
                            <div class="box-body">
                                <form action="student-actions.php" method="post" >
                                    <input type="hidden" name="attendance_id" value="<?= $verification_request["attendance_id"]; ?>">
                                    <input type="hidden" name="sc_id" value="<?= $student_course->sc_id; ?>">
                                    <button type="submit" name="verify_attendance" value="<?= $class["class_id"];?>"
                                        class="btn btn-sm btn-success border-button border-grey border-radius-4" data-toggle="modal" data-target="#edit-class-modal-<?= $class["class_id"];?>"><i class="fas fa-check-circle"></i>&nbspΕπιβεβαίωση

                                </form>
                            </div>




                        </td>

                    </tr>

                <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>
    </div>
    </div>

</div>

<?php endif; ?>








<!-- l-bg-blue-dark   l-bg-orange -->
<div class="row">
    <div class="col-lg-12 mx-auto">

        <div class="mt-4">

            <!-- Gradient divider -->
            <hr data-content="Πληροφορίες" class="hr-text">
        </div>

    </div>
</div>
<div class="row my-4">

    <!-- first card -->
    <div class="col-4">
        <div class="card h-100 ">
            <div class="card-body">
                <div class="d-flex justify-content-center badge-primary border-radius-7"><b>Διδακτικές Ώρες</b></div>
                <br>
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex bd-highlight"><h6>Σύνολο:</h6></div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex justify-content-end text-primary">
                            <h6>
                                <?= ($hours_total) ;?>
                            </h6>
                        </div>
                    </div>
                </div>
                <hr class="my-1 p-1">
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex bd-highlight"><h6>Παρουσίες:</h6></div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex justify-content-end text-success">
                            <?= ($hours_verified) ;?>
                        </div>
                    </div>
                </div>
                <hr class="my-1 p-1">
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex bd-highlight"><h6>Απουσίες:</h6></div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex justify-content-end text-danger">
                            <h6>
                                <?php if($hours_absent == null){echo "0"; }else {echo $hours_absent;} ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- second card -->
    <div class="col-4">
        <div class="card h-100 ">
            <div class="card-body">

                <div class="d-flex justify-content-center badge-success border-radius-7 "><b>Κόστος</b></div>
                <br>
<!-- <span class="badge badge-purple">Μάθημα</span> -->
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex bd-highlight"><h6>Σύνολο:</h6></div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex justify-content-end text-primary">
                            <h6>

                            <?php  if ($student_course -> sc_special_cost == "0") {
    echo $total_cost = $hours_verified * $student_course-> course_cost_hour_student;
} else {
    echo $total_cost = $hours_verified * $student_course-> sc_special_cost;
}?>
&nbsp&euro;
</h6>

                        </div>
                    </div>
                </div>

                <hr class="my-1 p-1">
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex bd-highlight"><h6>Πληρωμένο:</h6></div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex justify-content-end text-success  bd-highlight">
                            <h6>


                                    <?php
                                    $paid = Payment::getPaymentInfoById($conn, $_GET['id']);
                                    if ($paid[0]=="") {
                                        echo "0";
                                    } else {
                                        echo $paid[0];
                                    } ?>
                                    &euro;

                            </h6>
                        </div>

                    </div>
                </div>

                <hr class="my-1 p-1">
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex bd-highlight"><h6>Υπόλοιπο:</h6></div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex justify-content-end text-danger">
                            <h6>
                            <?php
                            $remaining_cost = $total_cost - $paid[0];
                            echo $remaining_cost;
                            ?>
                            &euro;
                        </h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<!-- <div class="row">
            <div class="col-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title  text-muted mb-0">Πληρωμένο</h5>
                      <span class="h4 font-weight-bold mb-0">350,897</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-chart-bar"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
                  </p>
                </div>
              </div>
            </div>
</div> -->



    <div class="row">
        <div class="col-lg-12 mx-auto">

            <div class="mt-4">

                <!-- Gradient divider -->
                <hr data-content="Ιστορικό" class="hr-text">
            </div>

        </div>
    </div>



<!-- Payments History Card -->
<div class="row my-4">









    <!-- Attendances Card -->
    <div class="col-6">

        <div class="card mb-0 h-100">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-blue bg-light border-radius-7 full-gradient-bg-pink table-pink attendance-table" id="dataTable" width="100%" cellspacing="0">

                        <thead>

                            <div class="mb-2 text-pink">
                                <h6 class="text-center">
                                    <i class="fas fa-tasks"></i>
                                    Ιστορικό Παρουσιολογίου
                                </h6>
                            </div>

                            <tr>
                                <th class="text-center align-middle">A/A</th>
                                <th class="text-center align-middle">Ημερομηνία</th>
                                <th class="text-center align-middle">Ώρες</th>
                                <th class="text-center align-middle">Κατάσταση</th>
                                <th class="text-center align-middle">Επιβεβαιωμένο</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (empty($student_course_attendances)): ?>
                                <tr>
                                    <td colspan="8" align="center"><b>Δεν βρέθηκαν δεδομένα στο παρουσιολόγιο</b></td>
                                </tr>

                            <?php else: ?>
                                <?php $aa = 0; ?>
                                <?php foreach ($student_course_attendances as $student_course_attendance) : ?>
                                    <tr>
                                        <td class="text-center align-middle" min-width="40px" align="center"><?php echo $aa = $aa + 1;  ?></td>

                                        <td class="text-center align-middle"  align="center">

                                            <?php
                                            $date_attendances = '<i class="fas fa-calendar-day"></i>' . " " . date('d-m-Y', strtotime($student_course_attendance['attendance_date'])) . ' &nbsp  <i class="far fa-clock"></i> ' . date('H:i', strtotime($student_course_attendance['attendance_date']))
                                            ?>
                                            <?= $date_attendances ;?></td>




                                            <!-- <?= date('d-m-Y, H:i', strtotime($student_course_attendance['attendance_date'])); ?> -->
                                        </td>
                                        <td class="text-center align-middle"  align="center">
                                            <?= ($student_course_attendance['attendance_duration']); ?>
                                        </td>
                                        <td class="text-center align-middle"  align="center">
                                            <?php if ($student_course_attendance['attendance_status'] == "Present") : ?>
                                                <span class="badge badge-success"><?= $student_course_attendance['attendance_status']; ?></span>
                                            <?php elseif ($student_course_attendance['attendance_status'] == "Absent") : ?>
                                                <span class="badge badge-danger"><?= $student_course_attendance['attendance_status']; ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center align-middle"  align="center">

                                            <?php if ($student_course_attendance['attendance_verify'] == 0) : ?>

                                                <?php if ($student_course_attendance['attendance_status'] == "Absent") : ?>

                                                    <span class="text-danger">---</span>

                                                <?php else: ?>

                                                <i class="fas fa-user-clock text-warning"></i>

                                            <?php endif; ?>

                                            <?php elseif ($student_course_attendance['attendance_verify'] == 1) : ?>

                                                <i class="fas fa-check text-success"></i>

                                            <?php endif; ?>

                                        </td>










                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                    </tbody>

                </table>
            </div>
        </div>

        </div>
    </div>









    <div class="col-6">

        <div class="card  ">

            <div class="card-body ">
                <div class="table-responsive fixed-height-400">
                    <table class="table table-bordered table-hover table-blue bg-light  full-gradient-bg-blue payments-table" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <div class="mb-2 text-sap-green">
                                <h6 class="text-center">
                                    <i class="fas fa-file-invoice-dollar">&nbsp&nbsp</i>
                                    &nbspΙστορικό Πληρωμών
                                </h6>
                            </div>

                            <tr >
                                <th class="text-center align-middle">A/A</th>
                                <th class="text-center align-middle">Ημερομηνία</th>

                                <th class="text-center align-middle">Ποσό</th>
                                <?php
                                    if (Auth::isAdmin()|| Auth::isSecretary()):
                                ?>
                                <th class="text-center align-middle">Ενέργειες</th>
                            <?php endif; ?>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (empty($payments_history)): ?>
                                <tr>
                                    <td colspan="8" align="center"><b>Δεν βρέθηκαν Πληρωμές</b></td>
                                </tr>

                            <?php else: ?>
                                <?php $aa = 0; ?>
                                <?php foreach ($payments_history as $payment_history) : ?>
                                    <tr>
                                        <td class="text-center align-middle" min-width="40px" align="center"><?php echo $aa = $aa + 1;  ?></td>
                                        <!-- <td class="text-center align-middle"  align="center"><?= (date('d-m-Y - H:i:s', strtotime($payment_history['payment_date_time'])));?></td> -->

                                        <td class="text-center align-middle"  align="center"><?php
                                        $time = '<i class="fas fa-calendar-day"></i>' . " " . date('d-m-Y', strtotime($payment_history['payment_date_time'])) . ' &nbsp  <i class="far fa-clock"></i> ' . date('H:i', strtotime($payment_history['payment_date_time']))
                                        ?>
                                        <?= $time ;?></td>

                                        <td class="text-center align-middle"  align="center"><?= $payment_history['payment_amount']."&nbsp&euro;";  ?></td>
                                        <?php
                                            if (Auth::isAdmin()|| Auth::isSecretary()):
                                        ?>
                                        <td class="text-center align-middle">
                                            <div class="box-body">

                                                <span data-toggle="tooltip" data-placement="top" title="Επεξεργασία" >
                                                <button type="button" id="edit_student" name="submit" value="<?= $student["student_id"];?>"
                                                class="btn btn-white btn-sm button-rounded" data-toggle="modal" data-target="#edit-student-course-payments-history-modal-<?= $payment_history["payment_id"];?>"><i class="fas fa-edit text-orange"></i>
                                                </span>
                                            </div>

                                            <!-- Modal Edit Payment-->

                                            <div class="modal fade" id="edit-student-course-payments-history-modal-<?= $payment_history["payment_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Ιστορικό Πληρωμών</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form class="needs-validation" novalidate action="student-actions.php" method="post" >
                                                            <div class="modal-body">

                                                                <div class="alert alert-warning" role="alert">
                                                                    Διορθώστε το ποσό πληρωμής και πατήστε "Αποθήκευση"
                                                                </div>

                                                                <input type="hidden" name="sc_id" value="<?= $_GET['id'];?>">
                                                                <input type="hidden" name="payment_id" value="<?= $payment_history["payment_id"] ;?>">
                                                                    <table class="table table-striped table-bordered ">
                                                                        <tr>
                                                                            <td class="text-center">
                                                                                <!-- <input type="datetime-local" name="payment_date" value="<?= date('Y-m-d\TH:i', strtotime($payment_history['payment_date_time'])); ?>" /> -->
                                                                                <input type="text" class="align-center" name="payment_date" value="<?= date('d-m-Y', strtotime($payment_history['payment_date_time'])); ?>" disabled/>
                                                                                <br/>


                                                                            </td>
                                                                        </tr>

                                                                    </table>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-5 ">

                                                                    </div>
                                                                        <div class="form-group col-md-2 ">
                                                                        <label for="inputClassCode">Ποσό Πληρωμής (€)</label>
                                                                        <input
                                                                        type="number"
                                                                        min="1"
                                                                        name="payment_amount"
                                                                        class="form-control"
                                                                        id="inputClassCode"
                                                                        required
                                                                        value="<?= htmlspecialchars($payment_history['payment_amount']);?>" &euro>
                                                                        <div class="invalid-feedback">
                                                                            Παρακαλώ συμπληρώστε ποσό (>0)
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-3 ">

                                                                    </div>

                                                                </div>
                                                            </div>










                                                            <div class="modal-footer d-flex justify-content-center">
                                                                <button type="button" class="btn btn-danger border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                                                                <button type="submit" name="edit_student_course_payment_record" class="btn btn-success border-button"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- (END) Modal Edit student -->

                                        </td>


                                    <?php endif; ?>



                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>

                    </table>
                </div>
            </div>

    </div>
</div>















</div>











</div>


<script>
$(document).ready( function () {
    $('.payments-table').DataTable();
} );
</script>



<script>
$(document).ready( function () {
    $('.attendance-table').DataTable();
} );
</script>







  </main>

<?php require '../footer.php'; ?>
