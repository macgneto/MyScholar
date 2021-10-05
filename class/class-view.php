<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';

// Auth::requireAdmin();
if (Auth::isStudent()) {
    Url::redirect("/main/index.php");
}

// Checking Teacher Access to each classroom. If the teacher is teaching the class then access granted. Else redirect to classrooms.php
// if (Auth::isTeacher()) {
//     $teacher_classes = TeacherCourses::getTeacherClassesByTeacherId($conn, $_SESSION['user_id']);
//
//     $data_id = array();
//
//     foreach ($teacher_classes as $teacher_class) {
//         array_push($data_id, $teacher_class['class_id']);
//     }
//
//     $get_id = $_GET['id'];
//
//     if (in_array($get_id, $data_id, true)) {
//     } else {
//         Url::redirect("/main/classrooms.php");
//     }
//     var_dump($teacher_classes);
// }
// End Checking Teacher Access




// Assign variables with values to use inside this page
    if (isset($_GET['id'])) {
        $class_id = $_GET['id'];

        $class_profile = Classes::getByClassID($conn, $class_id);
        // var_dump($class_profile);
        $course_profile = Course::getByCourseID($conn, $class_profile -> class_course_id);
        // var_dump($course_profile);
        $attendances = Attendance::getAttendanceByClass($conn, $_GET['id']);
        // var_dump($attendances);
        $teachers_available = Classes::getTeacherByCourse($conn, $class_profile -> class_course_id);
    }


$attendance_students = Attendance::getAllAttendances($conn, $class_id);

$fetch_students = Classes::getStudentsRegisteredToClass($conn, $class_id);

$teacher_id = $class_profile -> class_teacher_id;

// var_dump($teacher_id);
$teacher = Classes::getTeacherClass($conn, $teacher_id);

require '../header.php';

require '../sidebar.php';

?>

<!-- Modal Add Attendance -->
<div class="modal fade" id="add-attendance-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Προσθήκη Παρουσίας Μαθητών</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form  class="needs-validation" action="class-actions.php" method="post" novalidate>
                <div class="modal-body">
                    <div class="form-group" id="add_attendance">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-blue bg-light border-radius-5 full-gradient-bg-blue mb-0">
                                <tr>
                                    <td class="text-center">
                                        <!-- <input type="datetime-local" name="attendance_date" value="
                                        <?php
                                        // echo datetime('Y-m-d H:i:s');
                                        // $date = date_create('2000-01-01');
                                        $dt = new DateTime();
                                        echo $dt->format('Y-m-d H:i:s');
                                        ?>" required/>
                                        <div class="invalid-feedback ">
                                            Παρακαλώ εισάγετε ημερομηνία και ώρα.
                                        </div>
                                        <br/> -->


                                        <div class="d-flex justify-content-center">
                                                          <div class="input-group  col-6">
                                                            <div class="input-group-prepend">
                                                              <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <!-- <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"> -->
                                                            <input class="form-control" type="datetime-local" name="attendance_date" value="
                                                            <?php

                                                            $dt = new DateTime();
                                                            echo $dt->format('Y-m-d H:i:s');

                                                            ?>" required/>

                                                                <div class="invalid-feedback ">
                                                                    Παρακαλώ εισάγετε ημερομηνία και ώρα.
                                                                </div>

                                                          </div>
                                                         </div>




                                    </td>
                                </tr>

                            </table>

                            <table class="table table-bordered table-hover table-blue bg-light border-radius-5 full-gradient-bg-blue">

                                <thead>
                                    <tr>

                                        <th align="center">Ονοματεπώνυμο</th>
                                        <th class="text-center">Παρών</th>
                                        <th class="text-center">Απών</th>
                                        <th class="text-center">Διάρκεια (Ώρες)</th>
                                    </tr>
                                </thead>

                                <?php foreach ($attendances as $attendance): ?>
                                    <input type="hidden" name="class_id" value="<?= $_GET["id"]; ?>">
                                    <tr>


                                        <td>
                                            <?= ($attendance["student_lastname"]); ?>&nbsp <?= ($attendance["student_firstname"]); ?>
                                            <input type="hidden" name="student_id[]" value="<?php echo $attendance["student_id"]; ?>" />
                                            <input type="hidden" name="sc_id[]" value="<?php echo $attendance["sc_id"]; ?>" />
                                        </td>
                                        <td align="center">
                                            <input type="radio" name="attendance_status<?php echo $attendance["student_id"]; ?>" value="Present" />
                                        </td>
                                        <td align="center">
                                            <input type="radio" name="attendance_status<?php echo $attendance["student_id"]; ?>" checked value="Absent" />
                                        </td>
                                        <td align="center">
                                            <input type="number" min="1" name="attendance_duration<?php echo $attendance["student_id"]; ?>" value="1" />
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                    <button type="submit" name="add-attendance-data-modal-button" value="<?php $class_id = $_GET['id'] ?>" class="btn btn-success border-button"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit Teacher in classroom -->
<div class="modal fade" id="edit_class_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Αλλαγή Καθηγητή</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

          <div class="modal-body">
              <form class="needs-validation" action="class-actions.php" method="post" novalidate>




                <div class="alert alert-warning" role="alert">
                  Επιλέξτε τον Καθηγητή και πατήστε Αποθήκευση για να πραγματοποιηθούν οι αλλαγές.
                </div>


                  <div class="form-group">
                      <input type="hidden" name="class_id" id="class_id" value="<?= $_GET['id'];?>">


                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="inputClassTeacher">Επιλέξτε Καθηγητή</label>
                        <select name="teacher_id" id="inputClassId" class="form-control" required>
                          <option disabled value="" >Επιλέξτε Καθηγητή...</option>

                          <?php foreach ($teachers_available as $teacher_available) : ?>

                            <?php if ($teacher_available['teacher_id'] == $class_profile->class_teacher_id) : ?>
                            <option  selected name="class_teacher_id" value="<?= $class_profile->class_teacher_id; ?>">
                            <?php else: ?>
                                <option  name="class_teacher_id" value="<?= $teacher_available['teacher_id']; ?>">
                            <?php endif; ?>
                              <?= $teacher_available["teacher_id"] ." - ". $teacher_available['teacher_lastname']." ". htmlspecialchars($teacher_available['teacher_firstname']); ?>  </option>
                          <?php endforeach; ?>

                        </select>
                        <div class="invalid-feedback">
                            Παρακαλώ επιλέξτε τμήμα απο τη λίστα.
                        </div>
                      </div>
                    </div>

                </div>
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-danger border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
            <button type="submit" name="edit_class_teacher" class="btn btn-success border-button" value=""><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
          </div>
      </form>
    </div>
  </div>
</div>




<div id="layoutSidenav_content">

    <main>

        <div class="container-fluid">








                      <div class="row row-breadcrumb">
                          <div class="col p-0 m-0">
                              <div class="card-breadcrumb  py-1">

                                  <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-chalkboard-teacher"></i>  Καρτέλα Τμήματος : <span class="badge bg-info text-white"><?= $class_profile -> class_code; ?>&nbsp|&nbsp<?= $class_profile -> class_name ;?></span></h3>

                                  <!-- <ol class="breadcrumb m-2 border-bottom-radius-7"> -->
                                      <ol class="breadcrumb m-3 ">
                                          <li class="breadcrumb-item"><a class="text-info" href="<?= basedir ?>index.php">Αρχική</a></li>
                                          <li class="breadcrumb-item"><a class="text-info" href="<?= basedir ?>classrooms.php">Τμήματα </a></li>
                                          <li class="breadcrumb-item active">Πληροφορίες Τμήματος</li>
                                  </ol>
                              </div>
                          </div>
                      </div>

<br>





<script>
window.setTimeout(function() {
    $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>

<!-- Success message on add attendance -->
<?php if (isset($_SESSION['success_edit_message']) && !empty($_SESSION['success_edit_message'])) { ?>

    <div class="alert alert-success alert-dismissible border-success fade show" role="alert">
        <strong>Αποθήκευση!</strong> Οι αλλαγές καταχωρήθηκαν επιτυχώς.
        <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php
    unset($_SESSION['success_edit_message']);
}
?>

<!-- Warning message on add attendance -->
<?php if (isset($_SESSION['fail_edit_message']) && !empty($_SESSION['fail_edit_message'])) { ?>
    <div class="alert alert-danger alert-dismissible border-danger fade show" role="alert">
        <strong>Αποτυχία!</strong> Οι αλλαγές δεν καταχωρήθηκαν.
        <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    unset($_SESSION['fail_edit_message']);
}
?>





<!-- Add new attendance [modal button] -->
<div class="card-body no-border">

    <?php if (empty($fetch_students)): ?>

    <?php else: ?>
    <button type="button" class="btn btn-info border-button border-grey" data-toggle="modal" data-target="#add-attendance-modal">
        <!-- <button type="button" class="btn btn-sm btn-primary button-white l-bg-blue-button border-button border-grey" data-toggle="modal" data-target="#add_student_modal"> -->
        <i class="fa fa-user-plus"></i>&nbsp&nbsp</i>Προσθήκη Παρουσίας
    </button>
<?php endif; ?>
    <?php if (Auth::isAdmin()): ?>
    <button type="button" class="btn btn-warning border-button border-grey" data-toggle="modal" data-target="#edit_class_teacher">
      <i class="fas fa-exchange-alt"></i>&nbsp&nbspΑλλαγή Καθηγητή
    </button>
<?php endif; ?>

</div>





            <!-- Classroom Detail Cards (3) -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col course-tile">
                    <div class="card gradient-bg-blue h-100 ">

                        <div class="card-body">



                            <div class="row ">
                                <div class="col-3 d-flex flex-column align-items-center justify-content-center">

                                    <div class="d-flex flex-column align-items-center text-center">
                                      <img src="<?= basedir ?>images/classroom_icon.png" alt="classroom" class="rounded-circle border-info" width="60">
                                      <div class="mt-2">

                                        <h6><a href="<?= basedir ?>class/class-view.php?id=<?= $class_profile -> class_id; ?>"><span class="badge badge-info">Τμήμα</span></a></h6>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-9">

                                    <div class="row">
                                      <div class="col-sm-12 text-secondary">
                                        <h6><i class="fas fa-atom text-info"></i>&nbsp;&nbsp;<?= ($class_profile-> class_name);?></h6>
                                        <hr>
                                      </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-sm-12 text-secondary">
                                            <h6><i class="fas fa-info-circle text-info"></i>&nbsp;&nbsp;<?= ($class_profile-> class_code);?></h6>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-sm-12 text-secondary">
                                            <h6><i class="fas fa-list text-info"></i>&nbsp;&nbsp;<?= ($class_profile-> class_description);?></h6>
                                        </div>
                                    </div>

                                </div>

                            </div>






                        </div>
                    </div>
                </div>
                <div class="col course-tile">
                    <div class="card gradient-bg-purple-light h-100 ">
                        <div class="card-body">
                        <div class="row ">
                            <div class="col-3 ">
                                <div class="mt-4 text-center ">
                                    <?php if ($student_course-> course_photo) : ?>
                                        <img src="<?= basedir ?>uploads/<?= $course_profile -> course_id; ?>" alt="photo" class="rounded-circle" width="60">
                                    <?php else: ?>
                                        <img src="<?= basedir ?>uploads/course_default_photo.png" alt="photo" class="rounded-circle" width="60">
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <h6><a href="<?= basedir ?>course/course-view.php?id=<?= $course_profile -> course_id; ?>"><span class="badge badge-purple">Μάθημα</span></a></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9 ">

                                <div class="row">
                                  <div class="col-sm-12 text-secondary ">
                                    <h6><i class="fas fa-book-open text-purple"></i>&nbsp;&nbsp;<?= htmlspecialchars($course_profile -> course_code);?></h6>
                                    <hr>
                                  </div>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-sm-12 text-secondary">
                                        <h6><i class="fab fa-readme text-purple" align="center"></i>&nbsp;&nbsp;<?= htmlspecialchars($course_profile -> course_title);?></h6>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-sm-12 text-secondary">
                                        <h6><i class="fas fa-list text-purple"></i>&nbsp;&nbsp;<?= htmlspecialchars($course_profile-> course_description); ?></h6>
                                    </div>
                                </div>

                            </div>

                        </div>



                    </div>
                </div>
                </div>
                <div class="col course-tile">
                    <div class="card gradient-bg-green-light h-100">

                        <div class="card-body">
                        <div class="row ">


                            <div class="col-3 d-flex flex-column align-items-center justify-content-center">

                                <div class="d-flex flex-column align-items-center text-center">
                                    <?php if ($teacher-> teacher_photo) : ?>
                                        <img src="<?= basedir ?>uploads/<?= $teacher->teacher_photo ?>" alt="photo" class="rounded-circle" width="60">
                                    <?php else: ?>
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="photo" class="rounded-circle" width="60">
                                    <?php endif; ?>



                                  <div class="mt-2">

                                    <h6><a href="../teacher/teacher-profile.php?id=<?= $teacher -> teacher_id; ?>"><span class="badge badge-success">Καθηγητής</span></a></h6>
                                  </div>
                                </div>
                            </div>



                            <div class="col-9 ">

                                <div class="row">
                                  <div class="col-sm-12 text-secondary">
                                    <h6><i class="bi bi-person-fill text-success"></i>
                                    <?= ($teacher->teacher_lastname); ?>&nbsp;<?= ($teacher->teacher_firstname); ?></h6>
                                    <hr>
                                  </div>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-sm-12 text-secondary">
                                        <h6><i class="fa fa-envelope text-success" align="center"></i>&nbsp;&nbsp;<?= ($teacher -> teacher_email);?></h6>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-sm-12 text-secondary">
                                        <h6><i class="fas fa-phone-alt text-success" align="center"></i>&nbsp;&nbsp;<?= ($teacher-> teacher_mobile_phone); ?></h6>
                                    </div>
                                </div>

                            </div>



                        </div>



                    </div>


                    </div>
                </div>
            </div>




            <!-- Classroom Students Registered List -->
            <div class="card  mb-4">


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-blue bg-light border-radius-7 full-gradient-bg-blue" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <div class="mb-2 text-primary">
                                    <h6 class="text-center">
                                    <i class="fas fa-table mr-1 fa-user-graduate"></i>
                                    Εγγεγραμένοι Μαθητές

                                </h6>

                                </div>


                                <?php if (empty($fetch_students)): ?>

                                <?php else: ?>
                                <tr>
                                    <th class="text-center">A/A</th>
                                    <th class="text-center">Ονοματεπώνυμο</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Κινητό</th>
                                    <th class="text-center">Ενέργειες</th>
                                </tr>
                            <?php endif; ?>
                            </thead>

                            <tbody>
                                <?php if (empty($fetch_students)): ?>
                                    <tr>
                                        <td class="text-center" colspan="5" ><b>Δεν βρέθηκαν εγγεγραμένοι μαθητές στο συγκεκριμένο τμήμα</b></td>
                                    </tr>
                                <?php else: ?>
                                    <?php $aa = 0; ?>
                                    <?php foreach ($fetch_students as $fetch_student) : ?>

                                        <tr>
                                            <td class="text-center align-middle" width="40px" align="center"><?= $aa = $aa + 1;?></td>

                                            <td align="left">
                                                <?php if ($fetch_student["student_photo"]) : ?>

                                                    <div class="row align-middle">
                                                        <div class="col-3">
                                                            <img src="<?= basedir ?>uploads/<?= $fetch_student["student_photo"] ?>" alt="photo" class="rounded-circle" width="50">
                                                        </div>
                                                        <div class="col-9 a align-self-center">
                                                            <?= ($fetch_student["student_lastname"])." ".($fetch_student["student_firstname"]); ?>
                                                        </div>
                                                    </div>

                                                <?php else: ?>

                                                    <div class="row align-middle">
                                                        <div class="col-3">
                                                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="photo" class="rounded-circle" width="50">
                                                        </div>
                                                        <div class="col-9 align-self-start align-self-center">
                                                            <?= ($fetch_student["student_lastname"])." ".($fetch_student["student_firstname"]); ?>
                                                        </div>
                                                    </div>

                                                <?php endif; ?>
                                            </td>





                                            <td class="text-center align-middle"><?= ($fetch_student["student_email"]); ?></td>
                                            <td class="text-center align-middle"><?= ($fetch_student["student_mobile_phone"]); ?></td>

                                            <td class="text-center align-middle">
                                                <div class="box-body">
                                                    <?php if(Auth::isTeacher()) : ?>

                                                    <?php else: ?>

                                                    <a class="btn btn-white btn-sm button-rounded " href="<?= basedir ?>student/student-course-view.php?id=<?= $fetch_student["sc_id"]; ?>" role="button"><i class="fas fa-eye text-primary"></i></a>
                                                <?php endif; ?>

                                                    <button type="button" id="view_student_attendances" name="submit" value="<?= $fetch_student["student_id"];?>"
                                                        class="btn btn-white btn-sm  button-rounded ml-1" data-toggle="modal" data-target="#view-student-attendnaces-<?= $fetch_student["student_id"];?>"><i class="fas fa-chart-bar text-primary"></i>
                                                        <?php $attendance_student_ids = Attendance::getAttendancesByStudentId($conn, $_GET['id'], $fetch_student["student_id"]); ?>
                                                    </div>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="view-student-attendnaces-<?= $fetch_student["student_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Παρουσιολόγιο Μαθητή: <span class="text-primary"><?= $fetch_student["student_lastname"]." ". $fetch_student["student_firstname"];?></span></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                            </button>
                                                          </div>
                                                          <div class="modal-body">


                                                              <table class="table  table-bordered table-hover  border-radius-7 myTableModal full-gradient-bg-pink table-pink"  id="dataTable_modal" width="100%" cellspacing="0">
                                                                  <thead>





                                                                      <tr class="text-center">
                                                                          <th>A/A</th>
                                                                          <th>Ημερομηνία</th>
                                                                          <th>Roll Num.</th>
                                                                          <th>Κατάσταση</th>
                                                                          <th>Ώρες</th>

                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      <?php if (empty($attendance_student_ids)): ?>
                                                                          <tr>
                                                                              <td colspan="5" align="center"><b>Δεν υπάρχουν δεδομένα στο παρουσιολόγιο</b></td>
                                                                          </tr>
                                                                      <?php else: ?>
                                                                          <?php $bb = 0; ?>
                                                                          <?php foreach ($attendance_student_ids as $attendance_student_id) : ?>
                                                                              <tr class="text-center">

                                                                                  <td width="40px" align="center"><?php echo $bb +=  1;  ?></td>
                                                                                  <td width="180px"><?= (date('d-m-Y', strtotime($attendance_student_id["attendance_date"]))); ?></td>

                                                                                  <?php
                                                                                  $roll_1 = $attendance_student_id["attendance_student_id"];
                                                                                  $roll_2 = $attendance_student_id["attendance_class_id"];
                                                                                  $roll_3 = $attendance_student_id["attendance_id"];
                                                                                  $roll = $roll_1 . $roll_2 . $roll_3;
                                                                                  ?>
                                                                                  <td width="130px"><?= $roll; ?></td>


                                                                                  <?php if ($attendance_student_id["attendance_status"] == "Present") : ?>
                                                                                      <td><span class="badge badge-success"><?= ($attendance_student_id["attendance_status"]); ?></span></td>
                                                                                  <?php else : ?>
                                                                                      <td><span class="badge badge-danger"><?= ($attendance_student_id["attendance_status"]); ?></span></td>
                                                                                  <?php endif; ?>
                                                                                  <td><?= ($attendance_student_id["attendance_duration"]); ?></td>

                                                                              </tr>
                                                                          <?php endforeach; ?>
                                                                      <?php endif; ?>
                                                                  </tbody>
                                                              </table>







                                                          </div>
                                                          <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="btn btn-secondary border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΚλείσιμο</button>
                                                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                                          </div>
                                                        </div>
                                                      </div>
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
        </div>



        <script>
        $(document).ready( function () {
            $('.myTableModal').DataTable();
        } );
        </script>



        <script>
        $(document).ready( function () {
            $('.myTable').DataTable();
        } );
        </script>







        <div class="container-fluid" style="margin-bottom:30px">
            <div class="card ">





                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table  table-bordered table-hover bg-light border-radius-7 myTable full-gradient-bg-pink table-pink"  id="dataTable" width="100%" cellspacing="0">
                            <thead>



                                <div class="d-flex">

                                  <div class="p-0  flex-fill text-right"></div>
                                  <div class="p-0   text-center text-pink"><i class="fas fa-tasks mr-1 text-pink"></i>
                                  Παρουσιολόγιο Τμήματος</div>
                                   <div class="pb-3 flex-fill text-right">
                                  <?php if (empty($fetch_students)): ?>

                                  <?php else: ?>

                                      <button type="button" id="add_button" class="btn btn-info border-button border-grey btn-sm border-radius-4" data-toggle="modal" data-target="#add-attendance-modal"><i class="fas fa-plus"></i>&nbsp&nbspΠροσθήκη</button>

                                  </div>
                              <?php endif; ?>
                                </div>

                                <?php if (empty($fetch_students)): ?>

                                <?php else: ?>
                                <tr class="text-center">
                                    <th>A/A</th>
                                    <th>Ημερομηνία</th>
                                    <th>Roll Num.</th>
                                    <th>Ονοματεπώνυμο</th>
                                    <th>Κατάσταση</th>
                                    <th>Ώρες</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            <?php endif; ?>
                            </thead>
                            <tbody>
                                <?php if (empty($attendance_students)): ?>
                                    <tr>
                                        <td colspan="7" align="center"><b>Δεν υπάρχουν δεδομένα στο παρουσιολόγιο</b></td>
                                    </tr>
                                <?php else: ?>
                                    <?php $aa = 0; ?>
                                    <?php foreach ($attendance_students as $attendance_student) : ?>
                                        <tr class="text-center">
                                            <td width="40px" align="center"><?php echo $aa = $aa + 1;  ?></td>
                                            <td width="220px">


                                                <?php
                                                $attendance_student_datetime = '<i class="fas fa-calendar-day"></i>' . " " . date('d-m-Y', strtotime($attendance_student["attendance_date"])) . ' &nbsp  <i class="far fa-clock"></i> ' . date('H:i', strtotime($attendance_student["attendance_date"]))
                                                ?>

                                                <?= $attendance_student_datetime; ?>


                                                <!-- <?= (date('d-m-Y [H:i]', strtotime($attendance_student["attendance_date"]))); ?> -->



                                            </td>

                                            <?php
                                            $roll_1 = $attendance_student["attendance_student_id"];
                                            $roll_2 = $attendance_student["attendance_class_id"];
                                            $roll_3 = $attendance_student["attendance_id"];
                                            $roll = $roll_1 . $roll_2 . $roll_3;
                                            ?>
                                            <td><?= $roll; ?></td>

                                            <td align="left">
                                                <?php if ($attendance_student["student_photo"]) : ?>

                                                    <div class="row align-middle">
                                                        <div class="col-3">
                                                            <img src="<?= basedir ?>uploads/<?= $attendance_student["student_photo"] ?>" alt="photo" class="rounded-circle" width="40">
                                                        </div>
                                                        <div class="col-9 a align-self-center">
                                                            <?= ($attendance_student["student_lastname"])." ".($attendance_student["student_firstname"]); ?>
                                                        </div>
                                                    </div>

                                                <?php else: ?>

                                                    <div class="row align-middle">
                                                        <div class="col-3">
                                                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="photo" class="rounded-circle" width="40">
                                                        </div>
                                                        <div class="col-9 align-self-start align-self-center">
                                                            <?= ($attendance_student["student_lastname"])." ".($attendance_student["student_firstname"]); ?>
                                                        </div>
                                                    </div>

                                                <?php endif; ?>
                                            </td>
                                            <?php if ($attendance_student["attendance_status"] == "Present") : ?>
                                                <td class="align-middle" width="140px"><span class="badge badge-success"><?= ($attendance_student["attendance_status"]); ?></span></td>
                                            <?php else : ?>
                                                <td class="align-middle" width="140px"><span class="badge badge-danger"><?= ($attendance_student["attendance_status"]); ?></span></td>
                                            <?php endif; ?>
                                            <td><?= ($attendance_student["attendance_duration"]); ?></td>
                                            <td>

                                                <div>


                                                        <button type="button"  id="jim" name="submit" value="<?= $attendance_student["attendance_id"];?>"
                                                            class="btn btn-white btn-sm  button-rounded ml-1" data-toggle="modal" data-target="#edit-attendance-modal-<?= $attendance_student["attendance_id"];?>"><i class="fas fa-edit text-orange"></i>

                                                </div>

                                                <!-- Modal Edit Attendance-->
                                                <div class="modal fade" id="edit-attendance-modal-<?= $attendance_student["attendance_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία στοιχείων Παρουσίας Μαθητή</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <form action="class-actions.php" method="post">
                                                                <div class="modal-body">
                                                                    <div class="form-group" id="attendance_edit">









                                                                            <table class="table table-striped table-bordered bg-white">
                                                                                <tr class="bg-light">
                                                                                    <td>

                                                                                        <div class="d-flex justify-content-center">
<!--
                                                                                        <div class="input-group col-5 ">
                                                                                          <div class="input-group-prepend ">
                                                                                            <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                                                                                          </div>
                                                                                          <div  class="form-control"> -->
                                                                                               <!-- <?php echo date('d-m-Y', strtotime($attendance_student['attendance_date'])); ?> -->
                                                                                              <!-- <?php $t = $attendance_student['attendance_date']; ?> -->
                                                                                              <!-- <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span> -->
                                                                                              <!-- <input class="input-group-text" type="datetime-local" name="attendance_date" value="<?php echo date('Y-m-d\TH:i:s', strtotime($attendance_student['attendance_date'])); ?>">


                                                                                        </div>
                                                                                        </div> -->


                                                                                  <div class="input-group  col-6">
                                                                                    <div class="input-group-prepend">
                                                                                      <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                                                                                    </div>
                                                                                    <!-- <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1"> -->
                                                                                    <input class="form-control" type="datetime-local" name="attendance_date" value="<?php echo date('Y-m-d\TH:i:s', strtotime($attendance_student['attendance_date'])); ?>">

                                                                                  </div>


                                                                                    </td>
                                                                                </tr>
                                                                            </table>

                                                                            <table class="table table-striped table-bordered bg-white">

                                                                                <thead class="bg-white">
                                                                                    <tr>
                                                                                        <th>Αρ. Εγγραφής</th>
                                                                                        <th>Ονοματεπώνυμο</th>
                                                                                        <th>Παρών</th>
                                                                                        <th>Απών</th>
                                                                                        <th>Διάρκεια</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>


                                                                                    <tr class="bg-white">
                                                                                        <input type="hidden" class="form-control" name="attendance_id" id="inputClassDescription" placeholder="Περιγραφή" value="<?= ($attendance_student['attendance_id']);?>">
                                                                                        <td>
                                                                                            <?php echo $attendance_student["attendance_id"]; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?= ($attendance_student["student_lastname"]); ?>&nbsp<?= ($attendance_student["student_firstname"]); ?>
                                                                                            <input type="hidden" name="student_id[]" value="<?php echo $attendance["student_id"]; ?>" />
                                                                                            <input type="hidden" name="attendnace_class_id" value="<?php echo $attendance_student["attendance_class_id"]; ?>" />
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <input type="radio" name="attendance_status" value="Present" <?= ($attendance_student["attendance_status"] == "Present") ? 'checked' : ''; ?> /> Present
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <input type="radio" name="attendance_status" value="Absent" <?= ($attendance_student["attendance_status"] == "Absent") ? 'checked' : ''; ?> /> Absent
                                                                                        </td>
                                                                                        <td align="center">

                                                                                            <input type="number" min="1" name="attendance_duration" value="<?= ($attendance_student["attendance_duration"]); ?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>

                                                                            </table>

                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer d-flex justify-content-center">
                                                                    <button type="button" class="btn btn-danger border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                                                                    <button type="submit" name="edit_attendance" class="btn btn-success border-button" value="<?= $attendance_student["attendance_id"]; ?>"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
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
        </div>

    </main>

<?php

require '../footer.php';

?>
