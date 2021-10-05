<?php

require '../includes/init.php';
$conn = require '../includes/db.php';


if (isset($_GET['id'])) {
    $teacher = Teacher::getByTeacherID($conn, $_GET['id']);
} else {
    $teacher = null;
}

    $course_ids = array_column($teacher -> getTeacherCourses($conn), 'course_id');
    $courses = TeacherCourses::getAllTeacherCourses($conn);

    $teacher_courses = TeacherCourses::getAllTeacherCourseClasses($conn);




if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // $teacher -> teacher_lastname = $_POST['teacherLastName'];
    // $teacher -> teacher_firstname = $_POST['teacherFirstName'];
    // $teacher -> teacher_email = $_POST['teacherEmail'];
    // $teacher -> teacher_mobile = $_POST['teacherMobile'];
    // $teacher -> teacher_address = $_POST['teacherAddress'];
    // $teacher -> teacher_zip_code = $_POST['teacherZipCode'];
    // $teacher -> teacher_gender = $_POST['teacherGender'];
    // $teacher -> teacher_status = $_POST['teacherStatus'];

    $course_ids = $_POST['course'] ?? [];

    // if ($teacher -> updateTeacher($conn)) {
    if ($teacher -> setTeacherCourses($conn, $course_ids)) {
        Url::redirect("/main/teacher/teacher-courses.php?id={$teacher -> teacher_id}");
    }
}


require '../header.php';
require '../sidebar.php';
?>
<!-- Modal -->
<div class="modal fade" id="edit_teacher_courses_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία Μαθημάτων για τον Καθηγητή: <span class="text-success"> <?= $teacher -> teacher_lastname ." ". $teacher -> teacher_firstname ?></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-bg">



          <div class="alert alert-warning" role="alert">
              Παρακάτω μπορείτε να επεξεργαστείτε τα μαθήματα του Καθηγητή.
          </div>
          <div class="alert alert-danger" role="alert">
              Προσοχή! Εάν αφαιρέσετε ένα μάθημα τότε θα χαθούν όλες οι πληροφορίες που σχετίζονται. Πληρωμές καθώς και ώρες διδασκαλίας θα χαθούν και δεν θα υπάρχει η δυνατότητα επαναφοράς.
          </div>




            <!-- <div class="card-body"> -->
            <form class=""  method="post">


                <div class="row gutters-sm">

                    <?php foreach ($courses as $course) : ?>

                        <div class="col-sm-4 course-tile">
                            <div class="card h-100 ">

                                <div class="card-body d-flex justify-content-center flex-column mb-3">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="me-3">

                                            <h5 class="text-purple"><a class="text-purple" href="../course/course-view.php?id=<?= $course['course_id']; ?>"><?= ($course['course_code']) ?></a></h5>
                                            <br>
                                            <div class=" text-purple small"><?= ($course['course_title']) ?></div>
                                            <br>
                                            <div class="text-muted small"><?= ($course['course_description']) ?></div>

                                        </div>

                                        <img src="<?= basedir ?>uploads/course_default_photo.png" alt="..." style="width: 6rem" />

                                    </div>

                                </div>

                                <div class="card-footer" align = "center">

                                    <div class="custom-control custom-switch">
                                        <input class="custom-control-input" type="checkbox" name="course[]"  value="<?= $course['course_id'] ?>"
                                        id="course<?= $course['course_id'] ?>"
                                        <?php if (in_array($course['course_id'], $course_ids)) : ?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="course<?= $course['course_id'] ?>"></label>
                                    </div>

                                </div>

                            </div>
                        </div>

                    <?php endforeach; ?>


                </div>




              <!-- <div class="form-group row">
                  <div class="col-sm-9 offset-sm-3">
                      <input type="submit" class="btn btn-primary" value="Αποθήκευση">

                      <a class="btn btn-secondary" href="teacher-profile.php?id=<?= $teacher -> teacher_id; ?>">Πίσω</a>
                  </div>
              </div> -->




          <!-- </div> -->








      </div>
      <div class="modal-footer" align ="center">
          <div class="col-sm-12  ">
        <a class="btn btn-secondary border-button border-grey"  href="teacher-courses.php?id=<?= $teacher -> teacher_id; ?>"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Πίσω</a>


        <button type="submit" name="save_student_courses" class="btn btn-success border-button border-grey">
            <i class="fas fa-save"></i>&nbsp;&nbsp;Αποθήκευση
        </button>

        <!-- <input type="submit" class="btn btn-primary" value="Αποθήκευση"> -->
      </div>
      </div>
    </div>
  </div>
</div>

 </form>

    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">



                      <div class="row row-breadcrumb">
                          <div class="col p-0 m-0">
                              <div class="card-breadcrumb  py-1">

                                  <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-user-tie mr-1"></i>  Καρτέλα Καθηγητή : <span class="badge bg-success text-white"> <?= $teacher ->teacher_lastname ." ".  $teacher ->teacher_firstname; ?></span></h3>

                                      <ol class="breadcrumb m-3 ">
                                          <li class="breadcrumb-item"><a class="text-success" href="<?= basedir ?>index.php">Αρχική</a></li>
                                          <li class="breadcrumb-item"><a class="text-success" href="<?= basedir ?>teachers.php">Καθηγητές </a></li>
                                          <li class="breadcrumb-item active">Μαθήματα Καθηγητή</li>
                                  </ol>
                              </div>
                          </div>
                      </div>


                      <br>







<!--
                      <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center border-radius-7">

                          <li class="page-item "><a class="page-link" href="teacher-profile.php?id=<?= $teacher -> teacher_id; ?>"> Προφίλ </a></li>
                          <li class="page-item"><a class="page-link" href="#"> Ασφάλεια </a></li>
                          <li class="page-item active border-radius-7"><a class="page-link" href="teacher-courses.php?id=<?= $teacher -> teacher_id; ?>"> Μαθήματα </a></li>

                          <li class="page-item"><a class="page-link" href="#"> Πληρωμές </a></li>

                        </ul>
                      </nav> -->

                      <nav class="skew-menu teacher">
                          <ul>
                              <li class=""><a class="" href="teacher-profile.php?id=<?= $teacher -> teacher_id; ?>"><i class="fas fa-user"></i>&nbsp&nbspΠροφίλ</a></li>
                              <li class="active"><a class="" href="teacher-courses.php?id=<?= $teacher -> teacher_id; ?>"><i class="fas fa-book-open"></i>&nbsp&nbspΜαθήματα</a></li>
                              <!-- <li><a href="#">Shirts</a></li>
                              <li><a href="#">Jackets</a></li> -->
                          </ul>
                      </nav>




          <!-- Edit teacher courses [modal button] -->
          <div class="card-body no-border">
              <?php if (Auth::isAdmin() || Auth::isSecretary()): ?>
                  <button type="button" class="btn  btn-purple border-button border-radius-7" data-toggle="modal" data-target="#edit_teacher_courses_modal">
                      <i class="fas fa-edit"></i>&nbsp&nbsp</i>Επεξεργασία
                  </button>
              <?php endif; ?>
          </div>




           <div class="row gutters-sm">

            <?php foreach ($courses as $course) : ?>

                    <?php if (in_array($course['course_id'], $course_ids)) : ?>











                <div class="col-xl-4 mb-4">
                    <div class="card  lift h-100" href="student-course-view.php?id=<?= $teacher_course["tc_id"]; ?>">
                        <div class="card-body d-flex justify-content-center flex-column mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="me-3">

                                    <h5 class="text-purple"><a class="text-purple" href="../course/course-view.php?id=<?= $course['course_id']; ?>"><?= htmlspecialchars($course['course_code']) ?></a></h5>
                                    <br>
                                    <div class=" text-purple small"><?= ($course['course_title']) ?></div>
                                    <br>
                                    <div class="text-muted small"><?= ($course['course_description']) ?></div>
                                </div>
                                <img src="<?= basedir ?>/uploads/course_default_photo.png" alt="..." style="width: 6rem" />
                            </div>

                        </div>



                        <!-- <div class="d-flex  justify-content-center ">
                            <a href="teacher-course-view.php?id=<?= $teacher_course["tc_id"]; ?>" class="btn btn-outline-purple btn-sm "><i class="fas fa-info-circle"></i>&nbsp&nbspΠροβολή</a>
                        </div> -->

                <!-- <div class="card-footer"> -->




                 <?php
                 $data = array(
                     'teacher_id' => $_GET['id'],
                     'course_id' => $course['course_id'],

                 );


                 ?>
                 <?php $aa = 0; ?>
                 <?php foreach ($teacher_courses as $teacher_course) : ?>


                     <?php if ($teacher_course['tc_course_id'] == $course['course_id'] && $teacher_course['tc_teacher_id'] == $_GET['id']) : ?>



                         <!-- <a href="teacher-course-view.php?id=<?= $teacher_course['tc_id']; ?>" class="btn btn-outline-primary btn-sm">Πληροφορίες</a> -->

                         <div class="d-flex  justify-content-center mb-4">
                             <a href="teacher-course-view.php?id=<?= $teacher_course["tc_id"]; ?>" class="btn btn-outline-purple btn-sm "><i class="fas fa-info-circle"></i>&nbsp&nbspΠροβολή</a>
                         </div>
                     <?php endif;?>


                 <?php endforeach; ?>

              <!-- </div> -->
              </div>
            </div>



            <?php endif;?>


          <?php endforeach; ?>

      </main>


<?php

require '../footer.php';

?>
