<?php

require '../includes/init.php';

$conn = require '../includes/db.php';

if (isset($_GET['id'])) {
    $course = Course::getByCourseID($conn, $_GET['id']);
} else {
    $course = null;
}

$student_ids = array_column($course -> getCourseStudents($conn), 'student_id');

$teacher_ids = array_column($course -> getCourseTeachers($conn), 'teacher_id');

$students = Student::getAllStudents($conn);

$teachers = Teacher::getAllTeachers($conn);

require '../header.php';

require '../sidebar.php';

?>

<script>
window.setTimeout(function() {
    $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>

<div id="layoutSidenav_content">

    <main>





                <!-- Modal Edit Course-->
                <div class="modal fade" id="edit-course-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία Μαθήματος</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form class="needs-validation" novalidate action="course-actions.php" method="post">
                                <div class="modal-body text-left align-middle">

                                    <div class="alert alert-warning" role="alert">
                                        Διορθώστε τα στοιχεία του μαθήματος που θέλετε και πατήστε αποθήκευση.
                                    </div>

                                    <input type="hidden" name="courseID" value="<?= $course->course_id ;?>">

                                    <div class="form-row">
                                        <div class="form-group col-md-5 ">
                                            <label for="course_code">Κωδικός</label>
                                            <input type="text"
                                            class="form-control"
                                            id="course_code"
                                            name="course_code"
                                            placeholder="Κωδικός"
                                            required
                                            value="<?= htmlspecialchars($course->course_code);?>">
                                            <div class="invalid-feedback">
                                                Παρακαλώ συμπληρώστε κωδικό μαθήματος
                                            </div>
                                        </div>

                                        <div class="form-group col-md-7">
                                            <label for="course_title">Τίτλος</label>
                                            <input type="text"
                                            class="form-control"
                                            id="course_title"
                                            name="course_title"
                                            placeholder="Τίτλος"
                                            required
                                            value="<?= htmlspecialchars($course->course_title);?>">
                                            <div class="invalid-feedback">
                                                Παρακαλώ συμπληρώστε τίτλο μαθήματος
                                            </div>
                                        </div>


                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12 ">
                                            <label for="course_description">Περιγραφή</label>
                                            <textarea rows="2" type="textarea"
                                            class="form-control"
                                            id="course_description"
                                            name="course_description"
                                            placeholder="Περιγραφή"
                                            required
                                            ><?= htmlspecialchars($course->course_description);?></textarea>
                                            <div class="invalid-feedback">
                                                Παρακαλώ συμπληρώστε μία συνοπτική περιγραφή
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="course_cost_month_student">Ακαδημαϊκό Έτος</label>

                                            <select class="custom-select" name="course_year" required>
                                                <option value="">Έτος</option>
                                                <option name="course_year" value="2018 - 2019" <?php if ($course->course_year == "2018 - 2019") {
    echo 'selected="selected"';
} ?> >2018 - 2019</option>
                                                <option name="course_year" value="2019 - 2020" <?php if ($course->course_year == "2019 - 2020") {
    echo 'selected="selected"';
} ?> >2019 - 2020</option>
                                                <option name="course_year" value="2020 - 2021" <?php if ($course->course_year == "2020 - 2021") {
    echo 'selected="selected"';
} ?> >2020 - 2021</option>
                                                <option name="course_year" value="2021 - 2022" <?php if ($course->course_year == "2021 - 2022") {
    echo 'selected="selected"';
} ?> >2021 - 2022</option>
                                                <option name="course_year" value="2022 - 2023" <?php if ($course->course_year == "2022 - 2023") {
    echo 'selected="selected"';
} ?> >2022 - 2023</option>
                                                <option name="course_year" value="2023 - 2024" <?php if ($course->course_year == "2023 - 2024") {
    echo 'selected="selected"';
} ?> >2023 - 2024</option>
                                                <option name="course_year" value="2024 - 2025" <?php if ($course->course_year == "2024 - 2025") {
    echo 'selected="selected"';
} ?> >2024 - 2025</option>
                                                <option name="course_year" value="2025 - 2026" <?php if ($course->course_year == "2025 - 2026") {
    echo 'selected="selected"';
} ?> >2025 - 2026</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Παρακαλώ επιλέξτε Ακαδημαϊκό Έτος
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="course_cost_hour_student">Κόστος/Ώρα (Μαθητές)</label>
                                            <input type="number"
                                            min="0"
                                            class="form-control"
                                            id="course_cost_hour_student"
                                            name="course_cost_hour_student"
                                            placeholder="Κόστος ανά ώρα"
                                            required
                                            value = "<?= htmlspecialchars($course->course_cost_hour_student);?>">
                                            <div class="invalid-feedback">
                                                Παρακαλώ συμπληρώστε κόστος/ώρα
                                            </div>
                                        </div>
                                        <!-- <div class="form-group col-md-6">
                                            <label for="course_cost_month_student">Κόστος/Μήνα (Μαθητές)</label>
                                            <input type="number"
                                            min="0"
                                            class="form-control"
                                            id="course_cost_month_student"
                                            name="course_cost_month_student"
                                            placeholder="Κόστος ανά μήνα"
                                            required
                                            value = "<?= htmlspecialchars($course->course_cost_month_student);?>">
                                            <div class="invalid-feedback">
                                                Παρακαλώ συμπληρώστε κόστος/μήνα
                                            </div>
                                        </div> -->
                                        <div class="form-group col-md-6">
                                            <label for="course_cost_hour_teacher">Μισθός/Ώρα (Καθηγητές)</label>
                                            <input type="number"
                                            min="0"
                                            class="form-control"
                                            id="course_cost_hour_teacher"
                                            name="course_cost_hour_teacher"
                                            placeholder="Κόστος ανά ώρα"
                                            required
                                            value = "<?= htmlspecialchars($course-> course_cost_hour_teacher);?>">
                                            <div class="invalid-feedback">
                                                Παρακαλώ συμπληρώστε κόστος/ώρα
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                                    <button type="submit" name="edit-course-modal-btn" class="btn btn-success border-dark"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- (END) Modal Edit student -->



        <div class="container-fluid">






            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb  py-1">
                        <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-book-open"></i>
                            Καρτέλα Μαθήματος: <span class="badge bg-purple text-white"> <?= $course ->course_code ." : ".  $course ->course_title; ?></span>
                        </h3>
                        <ol class="breadcrumb m-3 ">
                            <li class="breadcrumb-item"><a class="text-purple" href="<?= basedir ?>index.php">Αρχική</a></li>
                            <li class="breadcrumb-item"><a class="text-purple" href="<?= basedir ?>courses.php">Μαθήματα</a></li>
                            <li class="breadcrumb-item active">Καρτέλα Μαθήματος</li>
                        </ol>
                    </div>
                </div>
            </div>
            <br>







            <!-- Success message on edit course -->
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

            <!-- Warning message on edit course -->
            <?php if (isset($_SESSION['fail_edit_message']) && !empty($_SESSION['fail_edit_message'])) { ?>
                <div class="alert alert-danger alert-dismissible border-danger fade show" role="alert">
                    <strong>Αποτυχία!</strong> Οι αλλαγές δεν καταχωρήθηκαν. Υπήρξε πρόβλημα με την αποθήκευση στη βάση δεδομένων.
                    <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                unset($_SESSION['fail_edit_message']);
            }
            ?>









            <?php if (Auth::isAdmin() || Auth::isSecretary()) : ?>
            <!-- Add new course [modal button] -->
            <div class="card-body no-border">
                <button type="button" class="btn btn-purple border-button " data-toggle="modal" data-target="#edit-course-modal">
                    <i class="fas fa-edit"></i>&nbsp;&nbsp;Επεξεργασία Μαθήματος
                </button>
            </div>
        <?php endif; ?>

            <div class="row gutters-sm">

                <div class="col-7">
                  <div class="card mb-3">
                    <div class="card-body">







                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Κωδικός Μαθήματος</h6>
                        </div>
                        <div class="col-sm-9 text-purple">
                          <?=  ($course-> course_code); ?>
                        </div>
                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Τίτλος Μαθήματος</h6>
                        </div>
                        <div class="col-sm-9 text-purple">
                          <?= ($course-> course_title);?>
                        </div>
                      </div>

                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Περιγραφή</h6>
                        </div>
                        <div class="col-sm-9 text-purple">
                          <?= ($course-> course_description);?>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Ακαδημαικό Έτος</h6>
                        </div>
                        <div class="col-sm-9 text-purple">
                            <?php if ($course -> course_year == "2018 - 2019") {
                echo '2018 - 2019';
            } ?>
                            <?php if ($course -> course_year == "2019 - 2020") {
                echo '2019 - 2020';
            } ?>
                            <?php if ($course -> course_year == "2020 - 2021") {
                echo '2020 - 2021';
            } ?>
                            <?php if ($course -> course_year == "2021 - 2022") {
                echo '2021 - 2022';
            } ?>
                            <?php if ($course -> course_year == "2022 - 2023") {
                echo '2022 - 2023';
            } ?>
                            <?php if ($course -> course_year == "2023 - 2024") {
                echo '2023 - 2024';
            } ?>
                            <?php if ($course -> course_year == "2024 - 2025") {
                echo '2024 - 2025';
            } ?>
                            <?php if ($course -> course_year == "2025 - 2026") {
                echo '2025 - 2026';
            } ?>
                        </div>
                      </div>



                    </div>
                  </div>
                  </div>





                  <div class="col-5">



                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-6 ">
                            <h6 class="mb-0">Κόστος Μαθητή</h6>
                          </div>
                          <div class="col-6 text-primary">
                            <i display="block">€ </i><?= ($course-> course_cost_hour_student)." / ώρα";?>
                          </div>
                        </div>

                        <?php if (Auth::isAdmin() || Auth::isSecretary() || Auth::isTeacher()) : ?>
                        <hr>
                        <div class="row">
                          <div class="col-6">
                            <h6 class="mb-0">Μισθός Καθηγητή</h6>
                          </div>
                          <div class="col-6 text-success">
                            <i display="block">€ </i><?= ($course-> course_cost_hour_teacher)." / ώρα";?>
                          </div>
                        </div>
                    <?php endif; ?>


                      </div>
                    </div>









                    </div>


                  </div>



<?php if (Auth::isAdmin() || Auth::isSecretary() || Auth::isTeacher()) : ?>
<div class="d-flex justify-content-center">
    <p>
    <button class="btn btn-sm btn-purple border-button border-radius-7" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="dataTable"><i class="fas fa-chevron-circle-down"></i>&nbsp&nbspΜαθητές - Καθηγητές&nbsp&nbsp<i class="fas fa-chevron-circle-down"></i></button>
    </p>
</div>
<?php endif; ?>







                  <script>
                  $(document).ready( function () {
                      $('.students-table').DataTable();
                  } );
                  </script>



                  <script>
                  $(document).ready( function () {
                      $('.teachers-table').DataTable();
                  } );
                  </script>



                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">


                            <div class="table-responsive">
                                <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">

                                    <thead>
                                        <div class="mb-2 text-primary">
                                            <h6 class="text-center">
                                            <i class="fas fa-table mr-1 fa-user-graduate"></i>
                                            Εγγεγραμένοι Μαθητές

                                        </h6>

                                        </div>

                                        <tr>

                                            <th class="text-center align-middle">A/A</th>
                                            <th class="text-center align-middle">Ονοματεπώνυμο</th>
                                            <th class="text-center align-middle">Email</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php if (empty($students)): ?>
                                            <tr>
                                                <td colspan="3" align="center"><b>Δεν βρέθηκαν Μαθητές</b></td>
                                            </tr>

                                        <?php else: ?>
                                            <?php $aa = 0; ?>
                                            <?php foreach ($students as $student) : ?>
                                                <?php if (in_array($student['student_id'], $student_ids)) : ?>
                                                    <tr>
                                                        <td width="40px" class="text-center align-middle" ><?php echo $aa = $aa + 1;  ?></td>

                                                        <td align="left">
                                                            <?php if ($student['student_photo']) : ?>

                                                                <div class="row align-middle">
                                                                    <div class="col-4">
                                                                        <img src="<?= basedir ?>uploads/<?= $student['student_photo'] ?>" alt="photo" class="rounded-circle border-primary" width="50">
                                                                    </div>
                                                                    <div class="col-8 a align-self-center">
                                                                        <a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= ($student["student_lastname"])." ".($student["student_firstname"]); ?></a>
                                                                    </div>
                                                                </div>

                                                            <?php else: ?>

                                                                <div class="row align-middle">
                                                                    <div class="col-4">
                                                                        <img src="<?= basedir ?>images/avatar.png" alt="photo" class="rounded-circle border-primary" width="50">
                                                                    </div>
                                                                    <div class="col-8 align-self-start align-self-center">
                                                                        <a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= ($student["student_lastname"])." ".($student["student_firstname"]); ?></a>
                                                                    </div>
                                                                </div>

                                                            <?php endif; ?>

                                                        </td>





                              <!-- <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_firstname"]); ?></a></td> -->
                              <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= ($student["student_email"]); ?></td>
                              <!-- <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_mobile"]); ?></a></td>
                              <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_gender"]); ?></a></td>
                              <td class="text-center align-middle"><a href="../student/student-profile.php?id=<?= $student["student_id"]; ?>"><?= htmlspecialchars($student["student_status"]); ?></a></td> -->



                                </tr>

                              <?php endif; ?>

                            <?php endforeach; ?>

                            <?php endif; ?>

                            </tbody>

                            </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered teachers-table" id="dataTable" width="100%" cellspacing="0">

                                    <thead>
                                        <div class="mb-2 text-success">
                                            <h6 class="text-center">
                                            <!-- <i class="fas fa-table mr-1 fa-user-graduate"></i> -->
                                            <i class="fas mr-1 fa-chalkboard-teacher"></i>
                                            Διδάσκοντες Καθηγητές

                                        </h6>

                                        </div>
                                        <tr>

                                            <th class="text-center align-middle">A/A</th>
                                            <th class="text-center align-middle">Ονοματεπώνυμο</th>
                                            <th class="text-center align-middle">Email</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php if (empty($teachers)): ?>
                                            <tr>
                                                <td colspan="3" align="center"><b>Δεν βρέθηκαν Καθηγητές</b></td>
                                            </tr>

                                        <?php else: ?>
                                            <?php $aa = 0; ?>
                                            <?php foreach ($teachers as $teacher) : ?>
                                                <?php if (in_array($teacher['teacher_id'], $teacher_ids)) : ?>
                                                    <tr>
                                                        <td width="20px" class="text-center align-middle" ><?php echo $aa = $aa + 1;  ?></td>

                                                        <td align="left">
                                                            <?php if ($teacher['teacher_photo']) : ?>

                                                                <div class="row align-middle">
                                                                    <div class="col-4">
                                                                        <img src="<?= basedir ?>uploads/<?= $teacher['teacher_photo'] ?>" alt="photo" class="rounded-circle border-success" width="50">
                                                                    </div>
                                                                    <div class="col-8 a align-self-center">
                                                                        <a class="text-success" href="../teacher/teacher-profile.php?id=<?= $teacher["teacher_id"]; ?>"><?= ($teacher["teacher_lastname"])." ".($teacher["teacher_firstname"]); ?></a>
                                                                    </div>
                                                                </div>

                                                            <?php else: ?>

                                                                <div class="row align-middle">
                                                                    <div class="col-4">
                                                                        <img src="<?= basedir ?>images/avatar.png" alt="photo" class="rounded-circle border-success" width="50">
                                                                    </div>
                                                                    <div class="col-8 align-self-start align-self-center">
                                                                        <a class="text-success" href="../teacher/teacher-profile.php?id=<?= $teacher["teacher_id"]; ?>"><?= ($teacher["teacher_lastname"])." ".($teacher["teacher_firstname"]); ?></a>
                                                                    </div>
                                                                </div>

                                                            <?php endif; ?>

                                                        </td>






                              <td class="text-center align-middle"><a class="text-success" href="../teacher/teacher-profile.php?id=<?= $teacher["teacher_id"]; ?>"><?= ($teacher["teacher_email"]); ?></td>



                                </tr>

                              <?php endif; ?>

                          <?php endforeach; ?>

                          <?php endif; ?>

                      </tbody>

                    </table>
                  </div>

                        </div>
                      </div>
                    </div>
                  </div>





















    </main>

<?php

require '../footer.php';

?>
