<?php

require '../includes/init.php';

$conn = require '../includes/db.php';


//
// if ($_SESSION['user_role'] == "student" && $_GET['id'] == $_SESSION['user_id']) {
//     if (isset($_GET['id'])) {
//         $student = Student::getByStudentID($conn, $_GET['id']);
//     } else {
//         $student = null;
//     }
// } else {
//     header('Location: ../index.php');
// }
//
//
//
//
//


if (Auth::isStudent()) {
    if ($_GET['id']!=$_SESSION['user_id']) {
        Url::redirect("/main/student/student-profile.php?id={$_SESSION['user_id']}");
    }
}

    if (isset($_GET['id'])) {
        if (Auth::isAdmin() || Auth::isSecretary()) {
            $student = Student::getByStudentID($conn, $_GET['id']);
        } elseif (Auth::isStudent()) {
            // $_GET['id'] = $_SESSION['user_id'];
            $student = Student::getByStudentID($conn, $_SESSION['user_id']);
        } else {
            // $student = null;
        }
    }


$course_ids = array_column($student -> getStudentCourses($conn), 'course_id');

$courses = Course::getAllCourses($conn);

$student_courses = StudentCourses::getAllStudentCourseTeacher($conn);

$classes = Classes::getAllClasses($conn);





if (isset($_GET['id'])) {
    $student = Student::getByStudentID($conn, $_GET['id']);
} else {
    $student = null;
}

    $course_ids = array_column($student -> getStudentCourses($conn), 'course_id');

    $courses = Course::getAllCourses($conn);
    // $courses = Course::getAllCoursesAvailable($conn, $_GET['id']);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_ids = $_POST['course'] ?? [];

    if ($student -> setStudentCourses($conn, $course_ids)) {
        $student -> deleteAtendanceIfRemoveSC($conn, $student, $class);
        Url::redirect("/main/student/student-courses.php?id={$student -> student_id}");
    }
}




require '../header.php';

require '../sidebar.php';

?>

<div id="layoutSidenav_content">

    <main>

        <div class="container-fluid">
            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb  py-1">
                        <h3 class="mx-3 mt-3 mb-2">
                            <i class="fas fa-table mr-1 fa-user-graduate"></i>  ?????????????? ???????????? : <span class="badge bg-primary text-white"> <?= $student ->student_lastname ." ".  $student ->student_firstname; ?></span>

                        </h3>
                        <ol class="breadcrumb m-3 ">
                            <li class="breadcrumb-item"><a href="<?= basedir ?>index.php">????????????</a></li>
                            <li class="breadcrumb-item"><a href="<?= basedir ?>student.php">?????????????? </a></li>
                            <li class="breadcrumb-item active">???????????????? ????????????</li>
                        </ol>
                    </div>
                </div>
            </div>
            <br>

            <nav class="skew-menu">
                <ul>
                    <li class=""><a class="" href="student-profile.php?id=<?= $student -> student_id; ?>"><i class="fas fa-user"></i>&nbsp&nbsp????????????</a></li>
                    <li class="active"><a class="" href="student-courses.php?id=<?= $student -> student_id; ?>"><i class="fas fa-book-open"></i>&nbsp&nbsp????????????????</a></li>
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
            <?php if (isset($_SESSION['success_edit_message']) && !empty($_SESSION['success_edit_message'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>????????????????????!</strong> ???? ?????????????? ?????????????????????????? ????????????????.
                    <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php

                unset($_SESSION['success_edit_message']);
            }
            ?>

            <!-- Warning message on edit student -->
            <?php if (isset($_SESSION['fail_edit_message']) && !empty($_SESSION['fail_edit_message'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>????????????????!</strong> ???? ?????????????? ?????? ??????????????????????????. ???????????? ???????????????? ???? ?????? ???????????????????? ?????? ???????? ??????????????????.
                    <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                unset($_SESSION['fail_edit_message']);
            }
            ?>



            <!-- Modal Edit student-courses-->
            <div class="modal fade" id="edit_student_courses_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">?????????????????????? ?????????????????? ?????? ?????? ????????????: <span class="text-primary"> <?= $student -> student_lastname ." ". $student -> student_firstname ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body bg-bg">

                            <div class="alert alert-warning" role="alert">
                                ???????????????? ???????????????? ???? ???????????????????????????? ???? ???????????????? ?????? ????????????.
                            </div>
                            <div class="alert alert-danger" role="alert">
                                ??????????????! ?????? ???????????????????? ?????? ???????????? ???????? ???? ???????????? ???????? ???? ?????????????????????? ?????? ??????????????????????. ???????????????? ?????????? ?????? ???????? ?????????????????????? ???? ???????????? ?????? ?????? ???? ?????????????? ?? ???????????????????? ????????????????????.
                            </div>
                            <form  method="POST">

                                <div class="row gutters-sm">

                                    <?php foreach ($courses as $course) : ?>

                                        <div class="col-sm-4 course-tile ">

                                            <div class="card h-100 ">

                                                <div class="card-body d-flex justify-content-center flex-column mb-3">

                                                    <div class="d-flex align-items-center justify-content-between">

                                                        <div class="me-3">

                                                            <h5 class="text-purple"><a class="text-purple" href="<?= basedir ?>course/course-view.php?id=<?= $course['course_id']; ?>"><?= ($course['course_code']) ?></a></h5>
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
                                                        <?php if (in_array($course['course_id'], $course_ids)) : ?>checked <?php endif;?>>



                                                        <label class="custom-control-label" for="course<?= $course['course_id'] ?>"></label>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                            <div class="modal-footer " align ="center" id="course_section">

                                <div class="col-sm-12  ">



                                    <a class="btn btn-secondary border-button border-grey"  href="student-courses.php?id=<?= $student -> student_id; ?>"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;????????</a>
                                    <button type="submit" name="save_student_courses" class="btn btn-success border-button border-grey">
                                        <i class="fas fa-save"></i>&nbsp;&nbsp;????????????????????
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <?php
                if (Auth::isAdmin()|| Auth::isSecretary()):
            ?>
            <!-- Edit student courses [modal button] -->
            <div class="card-body no-border">

                <button type="button" class="btn btn-purple border-button border-grey" data-toggle="modal" data-target="#edit_student_courses_modal">
                    <i class="fas fa-edit"></i>&nbsp&nbsp</i>??????????????????????
                </button>

            </div>
        <?php endif; ?>

                          <div class="row gutters-sm">
                          <?php foreach ($courses as $course) : ?>

                            <?php if (in_array($course['course_id'], $course_ids)) : ?>



                                <div class="col-xl-4 mb-4">
                                    <div class="card  lift h-100" href="student-course-view.php?id=<?= $student_course["sc_id"]; ?>">
                                        <div class="card-body d-flex justify-content-center flex-column mb-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="me-3">

                                                    <h5 class="text-purple"><a class="text-purple" href="<?= basedir ?>course/course-view.php?id=<?= $course['course_id']; ?>"><?= htmlspecialchars($course['course_code']) ?></a></h5>
                                                    <br>
                                                    <div class=" text-purple small"><?= ($course['course_title']) ?></div>
                                                    <br>
                                                    <div class="text-muted small"><?= ($course['course_description']) ?></div>
                                                </div>
                                                <img src="<?= basedir ?>uploads/course_default_photo.png" alt="..." style="width: 6rem" />
                                            </div>

                                        </div>



                                     <?php
                                     $data = array(
                                         'student_id' => $_GET['id'],
                                         'course_id' => $course['course_id'],
                                     );
                                     ?>

                                    <?php $aa = 0; ?>
                                    <?php foreach ($student_courses as $student_course) : ?>


                                        <?php if ($student_course["sc_course_id"] == $course['course_id'] && $student_course["sc_student_id"] == $_GET['id']) { ?>
                                            <!-- ???????????? ?????????????? -->
                                          <?php if ($student_course["sc_class_id"] == "") { ?>
                                              <?php
                                                  if (Auth::isAdmin()|| Auth::isSecretary()):
                                              ?>
                                          <div class="d-flex justify-content-center align-items-end">
                                             <button type="button" name="submit" value="<?= $student_course["sc_id"];?>"
                                             class="btn btn-outline-success btn-sm border-dark" data-toggle="modal" data-target="#add-student-course-to-class-modal-<?= $student_course["sc_id"];?>"><i class="fas fa-plus"></i>&nbsp&nbsp???????????????? ????????????????
                                          </div>
                                           <br>
                                       <?php else: ?>

                                           <div class="d-flex justify-content-center align-items-end">
                                               <div class="alert alert-info" role="alert">
                                                    ???????????????? ?? ???????????????????? ???? ??????????
                                                  </div>
                                           </div>
                                           <br>
                                       <?php endif; ?>
                                        <?php } else { ?>


                                                  <div class="d-flex  justify-content-center ">

                                          <a href="student-course-view.php?id=<?= $student_course["sc_id"]; ?>" class="btn btn-outline-purple btn-sm "><i class="fas fa-info-circle"></i>&nbsp&nbsp??????????????</a>



                                       </div>

                                       <br>
                                          </form>
                                        <?php }  ?>
                                      <?php }  ?>






                          <!-- Modal Add to Class-->
                          <div class="modal fade" id="add-student-course-to-class-modal-<?= $student_course["sc_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog " role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">???????????????? ???? ??????????</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                            <form class="needs-validation" action="student-actions.php" method="post" novalidate>
                                <div class="modal-body">

                                    <input type="hidden" name="sc_class_id" id="sc_class_id" value="<?= ($student_course["sc_course_id"]);?>">
                                      <input type="hidden" name="sc_id" id="sc_id" value="<?= ($student_course["sc_id"]);?>">
                                      <input type="hidden" name="student_id" id="student_id" value="<?= ($_GET["id"]);?>">
                                      <input type="hidden" name="course_id" id="course_id" value="<?= ($student_course["sc_course_id"]);?>">



                                      <div class="alert alert-primary" role="alert">
                                        ???????????????? ???? ?????????? ?????? ?????????? ???????????? ???? ???????????????????? ?????? ???????????? ?????? ???? ???????????????????????? ????????????.
                                      </div>

                                      <form>
                                        <div class="form-group">


                                        </div>

                                          <div class="form-row">
                                            <div class="form-group col-md-12">
                                              <label for="inputClassTeacher">???????????????? ??????????</label>
                                              <select name="class_id" id="inputClassId" class="form-control" required>
                                                <option value="" >???????????????? ??????????...</option>

                                                <?php foreach ($classes as $class):  ?>

                                                  <?php if ($student_course['sc_course_id'] == $class['class_course_id']) : ?>
                                                  <option  name="class_id" value="<?= $class["class_id"]; ?>">
                                                  <?php else: ?>

                                                  <?php endif; ?>
                                                    <?= htmlspecialchars($class["class_code"]); ?> | <?= htmlspecialchars($class["class_name"]); ?> | <?= ($class["teacher_lastname"]);?> <?= ($class["teacher_firstname"]);?> </option>
                                                <?php endforeach; ?>

                                              </select>
                                              <div class="invalid-feedback">
                                                  ???????????????? ???????????????? ?????????? ?????? ???? ??????????.
                                              </div>
                                            </div>
                                          </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbsp??????????????</button>
                                  <button type="submit" name="add_student_course_to_class" class="btn btn-success border-dark" value="<?= $class["class_id"]; ?>"><i class="fas fa-save"></i>&nbsp&nbsp????????????????????</button>
                                </div>
                            </form>
                          </div>
                          </div>
                          </div>

                          <?php endforeach; ?>
                      </div>
                      </div>










                    <?php endif;?>


                  <?php endforeach; ?>
      </div>


















  </main>

<?php require '../footer.php'; ?>
