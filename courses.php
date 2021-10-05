<?php

require 'includes/init.php';

Auth::requireLogin();

$conn = require 'includes/db.php';

$courses = Course::getAllCourses($conn);

$course = Course::getByCourseID($conn, $_GET['id']);

require 'header.php';

require 'sidebar.php';

?>


<div id="layoutSidenav_content">

    <main>

        <!-- Modal Add New Course -->
        <div class="modal fade" id="add_course_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Δημιουργία Μαθήματος</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form class="needs-validation" novalidate action="course/course-actions.php" method="post">

                        <div class="modal-body">

                            <div class="alert alert-primary" role="alert">
                                Εισάγετε τα στοιχεία του μαθήματος που θέλετε να καταχωρήσετε και πατήστε αποθήκευση.
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-5 ">
                                    <label for="course_code">Κωδικός</label>
                                    <input type="text"
                                    class="form-control"
                                    id="course_code"
                                    name="course_code"
                                    placeholder="Κωδικός"
                                    required
                                    value="<?= htmlspecialchars($course-> course_code);?>">
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
                                    value="<?= htmlspecialchars($course-> course_title);?>">
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
                                    ><?= htmlspecialchars($course-> course_description);?></textarea>
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
                                        <option name="course_year" value="2018 - 2019" <?php if ($course -> course_year == "2018 - 2019") {
    echo 'selected="selected"';
} ?> >2018 - 2019</option>
                                        <option name="course_year" value="2019 - 2020" <?php if ($course -> course_year == "2019 - 2020") {
    echo 'selected="selected"';
} ?> >2019 - 2020</option>
                                        <option name="course_year" value="2020 - 2021" <?php if ($course -> course_year == "2020 - 2021") {
    echo 'selected="selected"';
} ?> >2020 - 2021</option>
                                        <option name="course_year" value="2021 - 2022" <?php if ($course -> course_year == "2021 - 2022") {
    echo 'selected="selected"';
} ?> >2021 - 2022</option>
                                        <option name="course_year" value="2022 - 2023" <?php if ($course -> course_year == "2022 - 2023") {
    echo 'selected="selected"';
} ?> >2022 - 2023</option>
                                        <option name="course_year" value="2023 - 2024" <?php if ($course -> course_year == "2023 - 2024") {
    echo 'selected="selected"';
} ?> >2023 - 2024</option>
                                        <option name="course_year" value="2024 - 2025" <?php if ($course -> course_year == "2024 - 2025") {
    echo 'selected="selected"';
} ?> >2024 - 2025</option>
                                        <option name="course_year" value="2025 - 2026" <?php if ($course -> course_year == "2025 - 2026") {
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
                                    value = "<?= htmlspecialchars($course-> course_cost_hour_student);?>">
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
                                    value = "<?= htmlspecialchars($course-> course_cost_month_student);?>">
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
                            <button type="submit" name="add_course" class="btn btn-success border-dark"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- (END) Modal Add New Course -->



        <div class="container-fluid">


            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb  py-1">
                        <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-book-open"></i>
                            Μαθήματα
                        </h3>
                        <ol class="breadcrumb m-3 ">
                            <li class="breadcrumb-item"><a class="text-purple" href="index.php">Αρχική</a></li>
                            <li class="breadcrumb-item active">Μαθήματα</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- <div class="alert alert-primary">
                Μπορείτε να διαχειριστείτε τα μαθήματα παρακάτω
            </div> -->
<br>
            <br>
            <script>
            window.setTimeout(function() {
                $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 3000);
            </script>
            <!-- Success message on edit course -->
            <?php if (isset($_SESSION['success_edit_message']) && !empty($_SESSION['success_edit_message'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
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

            <!-- Warning message on edit student -->
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


            <?php if (Auth::isAdmin() || Auth::isSecretary()) : ?>
            <!-- Add new course [modal button] -->
            <div class="card-body no-border">
                <button type="button" class="btn btn-purple border-button " data-toggle="modal" data-target="#add_course_modal">
                    <i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Δημιουργία Μαθήματος
                </button>
            </div>
        <?php endif; ?>

            <div class="card mb-4 ">
                <!-- <div class="card-header">
                    <i class="fas fa-table mr-1 fa-book-open"></i>
                    Μαθήματα
                </div> -->

                <div class="card-body ">
                    <div class="table-responsive  ">
                        <table class="table table-bordered table-purple table-hover bg-light  full-gradient-bg-purple border-radius-7" id="dataTable" width="100%" cellspacing="0">
                            <thead >
                                <div class="mb-2 text-purple ">
                                    <h6 class="text-center">
                                        <i class="fas fa-book-open"></i>
                                        Λίστα Μαθημάτων
                                    </h6>
                                </div>
                                <tr>
                                    <th class="text-center align-middle">A/A</th>
                                    <th class="text-center align-middle">Κωδικός</th>
                                    <th class="text-center align-middle">Τίτλος</th>
                                    <th class="text-center align-middle">Περιγραφή</th>
                                    <th class="text-center align-middle" width="100px">Έτος</th>
                                    <th class="text-center align-middle">Ενέργειες</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (empty($courses)): ?>

                                    <tr>

                                        <td colspan="7" align="center"><b>Δεν έχετε καταχωρήσει μαθήματα.</b></td>

                                    </tr>

                                <?php else: ?>
                                    <?php $aa = 0; ?>
                                    <?php foreach ($courses as $course) : ?>
                                        <tr>
                                            <td width="40px" class="text-center align-middle"><?php echo $aa = $aa + 1;  ?></td>
                                            <td class="text-dark text-center align-middle"><?= ($course["course_code"]); ?></td>
                                            <td class="text-dark text-center align-middle"><?= ($course["course_title"]); ?></a></td>
                                            <td class="text-dark text-center align-middle"><?= ($course["course_description"]); ?></a></td>
                                            <td class="text-dark text-center align-middle"><?= ($course["course_year"]); ?></a></td>
                                            <td class="text-dark text-center align-middle">
                                                <div class="box-body">

                                                    <a class="btn btn-primary btn-sm btn-white button-rounded" href="course/course-view.php?id=<?= $course["course_id"]; ?>" role="button" data-toggle="tooltip" data-placement="top" title="Προβολή" ><i class="fas fa-eye text-purple"></i></a>
                                                    <span data-toggle="tooltip" data-placement="top" title="Επεξεργασία" >
                                                <?php if (Auth::isAdmin() || Auth::isSecretary()) : ?>
                                                    <button type="button" id="edit_course" name="submit" value="<?= $course["course_id"];?>"
                                                    class="btn  btn-sm  btn-white button-rounded " data-toggle="modal" data-target="#edit-course-modal-<?= $course["course_id"];?>"><i class="fas fa-edit text-orange"></i>
                                                    <span data-toggle="tooltip" data-placement="top" title="Επεξεργασία" >
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Modal Edit Course-->
                                                <div class="modal fade" id="edit-course-modal-<?= $course["course_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία Μαθήματος</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <form class="needs-validation" novalidate action="course/course-actions.php" method="post">
                                                                <div class="modal-body text-left align-middle">

                                                                    <div class="alert alert-warning" role="alert">
                                                                        Διορθώστε τα στοιχεία του μαθήματος που θέλετε και πατήστε αποθήκευση.
                                                                    </div>

                                                                    <input type="hidden" name="courseID" value="<?= $course["course_id"] ;?>">

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-5 ">
                                                                            <label for="course_code">Κωδικός</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="course_code"
                                                                            name="course_code"
                                                                            placeholder="Κωδικός"
                                                                            required
                                                                            value="<?= htmlspecialchars($course["course_code"]);?>">
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
                                                                            value="<?= htmlspecialchars($course["course_title"]);?>">
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
                                                                            ><?= htmlspecialchars($course["course_description"]);?></textarea>
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
                                                                                <option name="course_year" value="2018 - 2019" <?php if ($course["course_year"] == "2018 - 2019") {
                echo 'selected="selected"';
            } ?> >2018 - 2019</option>
                                                                                <option name="course_year" value="2019 - 2020" <?php if ($course["course_year"] == "2019 - 2020") {
                echo 'selected="selected"';
            } ?> >2019 - 2020</option>
                                                                                <option name="course_year" value="2020 - 2021" <?php if ($course["course_year"] == "2020 - 2021") {
                echo 'selected="selected"';
            } ?> >2020 - 2021</option>
                                                                                <option name="course_year" value="2021 - 2022" <?php if ($course["course_year"] == "2021 - 2022") {
                echo 'selected="selected"';
            } ?> >2021 - 2022</option>
                                                                                <option name="course_year" value="2022 - 2023" <?php if ($course["course_year"] == "2022 - 2023") {
                echo 'selected="selected"';
            } ?> >2022 - 2023</option>
                                                                                <option name="course_year" value="2023 - 2024" <?php if ($course["course_year"] == "2023 - 2024") {
                echo 'selected="selected"';
            } ?> >2023 - 2024</option>
                                                                                <option name="course_year" value="2024 - 2025" <?php if ($course["course_year"] == "2024 - 2025") {
                echo 'selected="selected"';
            } ?> >2024 - 2025</option>
                                                                                <option name="course_year" value="2025 - 2026" <?php if ($course["course_year"] == "2025 - 2026") {
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
                                                                            value = "<?= htmlspecialchars($course["course_cost_hour_student"]);?>">
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
                                                                            value = "<?= htmlspecialchars($course["course_cost_month_student"]);?>">
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
                                                                            value = "<?= htmlspecialchars($course['course_cost_hour_teacher']);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε κόστος/ώρα
                                                                            </div>
                                                                        </div>
                                                                    </div>



                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                                                                    <button type="submit" name="edit_course" class="btn btn-success border-dark"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div><!-- (END) Modal Edit student -->

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- to check -->

    </main>

<?php

require 'footer.php';

?>
