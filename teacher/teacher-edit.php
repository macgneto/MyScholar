<?php




require '../includes/init.php';
$conn = require '../includes/db.php';


if (isset($_GET['id'])) {
    $teacher = Teacher::getByTeacherID($conn, $_GET['id']);
} else {
    $teacher = null;
}
// var_dump($teacher->getStudentEnrollCourse($conn));
// $teacher_enroll_courses = StudentEnrollCourse::getAllStudentEnrollCourse($conn);
// var_dump($teacher_enroll_courses);
// $teacher->getStudentEnrollCourse($conn);



    $course_ids = array_column($teacher -> getTeacherCourses($conn), 'course_id');
    $courses = TeacherCourses::getAllTeacherCourses($conn);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $title = $_POST['title'];
    // $content = $_POST['content'];
    // $published_at = $_POST['published_at'];

    // $teacher -> teacher_lastname = $_POST['teacherLastName'];
    // $teacher -> teacher_firstname = $_POST['teacherFirstName'];
    // $teacher -> teacher_email = $_POST['teacherEmail'];
    // $teacher -> teacher_mobile = $_POST['teacherMobile'];
    // $teacher -> teacher_address = $_POST['teacherAddress'];
    // $teacher -> teacher_zip_code = $_POST['teacherZipCode'];
    // $teacher -> teacher_gender = $_POST['teacherGender'];
    // $teacher -> teacher_status = $_POST['teacherStatus'];

    $course_ids = $_POST['course'] ?? [];
    // $category_id = $_POST['course'] ?? [];
    // var_dump($course_ids);
    // exit;
    // var_dump($teacher -> setStudentCourses($conn, $course_ids));
    // var_dump($teacher -> updateStudent($conn));
    // exit;
    // if ($teacher -> updateTeacher($conn)) {
    // $teacher -> setStudentCourses($conn, $course_ids);
    if ($teacher -> setTeacherCourses($conn, $course_ids)) {
        // $jimakos = StudentCourses::setStudentCourses($conn, $course_ids);
        Url::redirect("/admin/teacher/teacher-profile.php?id={$teacher -> teacher_id}");
    }
}

?>

<?php require '../header.php';?>
<?php require '../sidebar.php';?>

    <div id="layoutSidenav_content">
      <main>













        <div class="container-fluid">
          <h1 class="mt-4">Επεξεργασία Καρτέλα Μαθητή</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= basedir ?>index.php">Αρχική</a></li>
            <li class="breadcrumb-item"><a href="<?= basedir ?>teacher.php">Καθηγητές</a></li>
            <li class="breadcrumb-item active">Επεξεργασία Καρτέλας Καθηγητή</li>
          </ol>
          <!-- <div class="card mb-4">
            <div class="card-body">
              Μπορείτε να διαχειριστείτε τα στοιχεία των μαθητών παρακάτω
            </div>
          </div> -->

          <div class="card border-primary mb-4">
            <div class="card-header">

              <i class='fas fa-user-graduate'></i>
              &nbsp;&nbsp;Καρτέλα Καθηγητή: <?= htmlspecialchars($teacher-> teacher_lastname);?>&nbsp;<?= htmlspecialchars($teacher-> teacher_firstname); ?>
            </div>

          <div class="card-body">
        <div>

            <form   method="post"  novalidate>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="teacherLastName">Επίθετο:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="teacherLastName" name="teacherLastName" placeholder="Επίθετο" required value="<?= htmlspecialchars($teacher-> teacher_lastname);?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="teacherFirstName">Όνομα:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="teacherFirstName" name="teacherFirstName" placeholder="Όνομα" required value="<?= htmlspecialchars($teacher-> teacher_firstname);?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="teacherEmail">Email Address:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="teacherEmail" name="teacherEmail" placeholder="Διεύθυνση Email" required value="<?= htmlspecialchars($teacher-> teacher_email);?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="teacherMobile">Κινητό Τηλέφωνο:</label>
                    <div class="col-sm-9">
                        <input type="tel" pattern="[0-9]{10}" class="form-control" id="teacherMobile" name="teacherMobile" placeholder="Κινητό Τηλέφωνο" required value="<?= htmlspecialchars($teacher-> teacher_mobile);?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="teacherAddress">Διεύθυνση Κατοικίας:</label>
                    <div class="col-sm-9">
                        <textarea rows="3" class="form-control" id="teacherAddress" name="teacherAddress" placeholder="Διεύθυνση Κατοικίας" required><?= htmlspecialchars($teacher-> teacher_address);?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="teacherZipCode">Ταχυδρομικός Κώδικας:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="teacherZipCode" name="teacherZipCode" placeholder="Ταχυδρομικός Κώδικας" required value="<?= htmlspecialchars($teacher-> teacher_zip_code);?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Φύλλο:</label>
                    <div class="col-sm-9 mt-2">
                        <label class="mb-0 mr-3">

                          <input type="radio" class="mr-1" name="teacherGender" value="Άνδρας" <?= htmlspecialchars($teacher-> teacher_gender == 'Άνδρας') ? 'checked' : ''; ?> /> Άνδρας<br />

                        </label>
                        <label class="mb-0 mr-3">
                            <input type="radio" class="mr-1" name="teacherGender" value="Γυναίκα" <?= htmlspecialchars($teacher-> teacher_gender == 'Γυναίκα') ? 'checked' : ''; ?> /> Γυναίκα<br />
                        </label>
                    </div>
                </div>



                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Κατάσταση:</label>
                    <div class="col-sm-9 mt-2">
                        <label class="mb-0 mr-3">
                          <input type="radio" class="mr-1" name="teacherStatus" value="Ενεργός" <?= htmlspecialchars($teacher-> teacher_status == 'Ενεργός') ? 'checked' : ''; ?> /> Ενεργός<br />
                            <!-- <input type="radio" class="mr-1" name="gender"> Άνδρας -->
                        </label>
                        <label class="mb-0 mr-3">
                            <input type="radio" class="mr-1" name="teacherStatus" value="Ανενεργός" <?= htmlspecialchars($teacher-> teacher_status == 'Ανενεργός') ? 'checked' : ''; ?> /> Ανενεργός<br />
                        </label>
                    </div>
                </div>






                </div>
              </div>


              </div>




  <div class="card border-primary mb-4">






  <div class="card-header">
    <i class='fas fa-user-graduate'></i>
    &nbsp;&nbsp;Καρτέλα Καθηγητή: <?= htmlspecialchars($teacher-> teacher_lastname);?>&nbsp;<?= htmlspecialchars($teacher-> teacher_firstname); ?>
  </div>







        <div class="card-body">



            <div class="row">


                <?php foreach ($courses as $course) : ?>

                    <div class="col-sm-4 course-tile">
                        <div class="card h-100 bg-light">

                            <div class="card-body">

                                <h5 class="card-title"><a href="../course/course-view.php?id=<?= $course['course_id']; ?>"><?= htmlspecialchars($course['course_code']) ?></a></h5>
                                <h6><i><?= htmlspecialchars($course['course_name']) ?></i></h6>
                                <p class="card-text"><?= htmlspecialchars($course['course_description']) ?></p>

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




            <div class="form-group row">
                <div class="col-sm-9 offset-sm-3">
                    <input type="submit" class="btn btn-primary" value="Αποθήκευση">

                    <a class="btn btn-secondary" href="teacher-profile.php?id=<?= $teacher -> teacher_id; ?>">Πίσω</a>
                </div>
            </div>

        </div>

    </form>

</main>

<?php require '../footer.php'; ?>
