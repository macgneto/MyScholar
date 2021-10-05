<?php

require '../includes/init.php';

$conn = require '../includes/db.php';

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
        Url::redirect("/main/student/student-profile.php?id={$student -> student_id}");
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

                                <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-table mr-1 fa-user-graduate"></i>  Καρτέλα Μαθητή </h3>

                                <!-- <ol class="breadcrumb m-2 border-bottom-radius-7"> -->
                                    <ol class="breadcrumb m-3 ">
                                        <li class="breadcrumb-item"><a href="<?= basedir ?>index.php">Αρχική</a></li>
                                        <li class="breadcrumb-item"><a href="<?= basedir ?>student.php">Μαθητές </a></li>
                                        <li class="breadcrumb-item active">Επεξεργασία Μαθημάτων</li>
                                </ol>
                            </div>
                        </div>
                    </div>


          <br>



          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center border-radius-7">
              <!-- <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
              </li> -->
              <li class="page-item "><a class="page-link" href="student-profile.php?id=<?= $student -> student_id; ?>"> Προφίλ </a></li>
              <li class="page-item"><a class="page-link" href="#"> Ασφάλεια </a></li>
              <li class="page-item active border-radius-7"><a class="page-link bg-danger " href="student-courses.php?id=<?= $student -> student_id; ?>"> Μαθήματα </a></li>

              <li class="page-item"><a class="page-link" href="#"> Πληρωμές </a></li>
              <!-- <li class="page-item">
                <a class="page-link" href="#">Next</a>
              </li> -->
            </ul>
          </nav>






<form  method="POST">
    <div class="mt-5 mb-3" align ="center" id="course_section">

        <div class="col-sm-12">
          <button type="submit" name="save_student_courses" class="btn btn-success border-dark">
            <i class="fas fa-save"></i>&nbsp;&nbsp;Αποθήκευση

          </button>

          <a class="btn btn-secondary border-dark"  href="student-courses.php?id=<?= $student -> student_id; ?>"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Πίσω</a>
        </div>

    </div>
  <!-- <div class="card-body"> -->

    <div class="row gutters-sm">

      <?php foreach ($courses as $course) : ?>
        <div class="col-sm-4 course-tile ">
          <div class="card h-100 ">





            <div class="card-body d-flex justify-content-center flex-column mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="me-3">

                        <h5 class="text-purple"><a class="text-purple" href="../course/course-view.php?id=<?= $course['course_id']; ?>"><?= htmlspecialchars($course['course_code']) ?></a></h5>
                        <br>
                        <div class=" text-purple small"><?= ($course['course_title']) ?></div>
                        <br>
                        <div class="text-muted small"><?= ($course['course_description']) ?></div>
                    </div>
                    <img src="<?php basedir ?>uploads/course_default_photo.png" alt="..." style="width: 6rem" />
                </div>


            </div>
            <div class="card-footer" align = "center">







              <div class="custom-control ">
                <input class="form-check-input" type="checkbox" name="course[]"  value="<?= $course['course_id'] ?>"
                id="course<?= $course['course_id'] ?>"
                <?php if (in_array($course['course_id'], $course_ids)) : ?>checked <?php endif;?>>



                <label class="form-check-input" for="course<?= $course['course_id'] ?>"></label>
              </div>

            </div>

          </div>

        </div>

      <?php endforeach; ?>

    </div>





</form>





</main>

<?php require '../footer.php'; ?>
