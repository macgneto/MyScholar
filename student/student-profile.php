<?php

require '../includes/init.php';

$conn = require '../includes/db.php';

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
        Url::redirect("/main/index.php");
    }
}

$course_ids = array_column($student -> getStudentCourses($conn), 'course_id');

$courses = Course::getAllCourses($conn);

$student_courses = StudentCourses::getAllStudentCourseTeacher($conn);

$classes = Classes::getAllClasses($conn);

require '../header.php';

require '../sidebar.php';

?>

<div id="layoutSidenav_content">

    <main>

        <!-- Modal for Edit student inside student profile -->
        <div class="modal fade" id="edit-student-modal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία Στοιχείων Μαθητή</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- <script type="text/javascript">


                    $(document).ready(function() {
                        $('#identicalForm').bootstrapValidator({
                            feedbackIcons: {
                                valid: 'glyphicon glyphicon-ok',
                                invalid: 'glyphicon glyphicon-remove',
                                validating: 'glyphicon glyphicon-refresh'
                            },
                            fields: {
                                password: {
                                    validators: {
                                        identical: {
                                            field: 'studentPassword',
                                            message: 'The password and its confirm are not the same'
                                        }
                                    }
                                },
                                confirmPassword: {
                                    validators: {
                                        identical: {
                                            field: 'studentConfirmPassword',
                                            message: 'The password and its confirm are not the same'
                                        }
                                    }
                                }
                            }
                        });
                    });
                    </script> -->

                    <script>
                    $(document).ready(function() {
                        $('#identicalForm').bootstrapValidator();
                    });
                    </script>
                    <form id="identicalForm" class="needs-validation" novalidate action="<?= basedir ?>student/student-actions.php" method="post" enctype="multipart/form-data"
                        >
                        <div class="modal-body text-left align-middle">

                            <input type="hidden" name="studentID" value="<?= $student-> student_id ;?>">

                            <div class="alert alert-primary" role="alert">
                                Διορθώστε τα στοιχεία του μαθητή και πατήστε αποθήκευση.
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6 ">
                                    <label for="studentUsername">Username</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentUsername"
                                    name="studentUsername"
                                    placeholder="Username"
                                    required
                                    value="<?= htmlspecialchars($student-> student_username);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Username μαθητή
                                    </div>
                                </div>

                                <div class="form-group col-md-6 ">
                                    <label for="studentPassword">Κωδικός Πρόσβασης</label>
                                    <input type="password"
                                    class="form-control"
                                    id="studentPassword"
                                    name="studentPassword"
                                    placeholder="Password"
                                    required
                                    value="<?= htmlspecialchars($student-> student_password);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Κωδικό Πρόσβασης μαθητή
                                    </div>
                                </div>

                            </div>



                            <div class="form-row">
                                <div class="form-group col-md-6 ">
                                    <label for="studentLastName">Επίθετο</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentLastName"
                                    name="studentLastName"
                                    placeholder="Επίθετο"
                                    required
                                    value="<?= htmlspecialchars($student-> student_lastname);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Επίθετο μαθητή
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="studentFirstName">Όνομα</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentFirstName"
                                    name="studentFirstName"
                                    placeholder="Όνομα"
                                    required
                                    value="<?= htmlspecialchars($student->student_firstname);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Όνομα μαθητή
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="studentFatherName">Όνομα Πατέρα</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentFatherName"
                                    name="studentFatherName"
                                    placeholder="Όνομα Πατρός"
                                    required
                                    value="<?= htmlspecialchars($student->student_fathername);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Όνομα Πατέρα
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="studentMotherName">Όνομα Μητέρας</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentMotherName"
                                    name="studentMotherName"
                                    placeholder="Όνομα Πατρός"
                                    required
                                    value="<?= htmlspecialchars($student->student_mothername);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Όνομα Μητέρας
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4 ">
                                    <label for="studentEmail">Email Address</label>
                                    <input type="email"
                                    class="form-control"
                                    id="studentEmail"
                                    name="studentEmail"
                                    placeholder="Διεύθυνση Email"
                                    required
                                    value="<?= htmlspecialchars($student->student_email);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε email μαθητή
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="studentMobile">Κινητό Τηλέφωνο</label>
                                    <input type="tel"
                                    pattern="[0-9]{10}"
                                    class="form-control"
                                    id="studentMobile"
                                    name="studentMobile"
                                    placeholder="Κινητό Τηλέφωνο"
                                    required
                                    value="<?= htmlspecialchars($student->student_mobile_phone);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε κινητό τηλέφωνο
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="studentFixedPhone">Σταθερό Τηλέφωνο</label>
                                    <input type="tel"
                                    pattern="[0-9]{10}"
                                    class="form-control"
                                    id="studentFixedPhone"
                                    name="studentFixedPhone"
                                    placeholder="Σταθερό Τηλέφωνο"
                                    required
                                    value="<?= htmlspecialchars($student->student_fixed_phone);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε σταθερό τηλέφωνο
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="studentAddress">Διεύθυνση Κατοικίας</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentAddress"
                                    name="studentAddress"
                                    placeholder="Διεύθυνση Κατοικίας"
                                    required
                                    value = "<?= htmlspecialchars($student->student_address);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε οδό και αριθμό κατοικίας
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="studentCity">Πόλη/Δήμος</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentCity"
                                    name="studentCity"
                                    placeholder="Πόλη/Δήμος"
                                    required
                                    value = "<?= htmlspecialchars($student->student_city);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Πόλη/Δήμο
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="studentCounty">Νομός</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentCounty"
                                    name="studentCounty"
                                    placeholder="Νομός"
                                    required
                                    value = "<?= htmlspecialchars($student->student_county);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Νομό
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="studentpostalCode">Τ.Κ</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentpostalCode"
                                    name="studentpostalCode"
                                    placeholder="Ταχυδρομικός Κώδικας"
                                    required
                                    value="<?= htmlspecialchars($student->student_postal_code);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Ταχυδρομικό Κώδικα
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="studentComments">Παρατηρήσεις - Σχόλια</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentComments"
                                    name="studentComments"
                                    placeholder="Παρατηρήσεις/Σχόλια"
                                    value="<?= htmlspecialchars($student->student_comments);?>">

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputBirthday">Ημερομηνία Γέννησης</label>
                                    <input type="date"
                                    class="form-control"
                                    name="studentBirthday"
                                    required
                                    value="<?= ($student->student_birthday);?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="inputAddress">Φύλλο</label>
                                    <div class="col-md-12">
                                        <div class="form form-inline">
                                            <input type="radio" required class="form-check-input" name="studentGender" value="Άνδρας" <?= htmlspecialchars($student->student_gender == 'Άνδρας') ? 'checked' : ''; ?> > </input> Άνδρας<br/>
                                        </div>
                                        <div class="form form-inline">
                                            <input type="radio" required class="form-check-input" name="studentGender" value="Γυναίκα" <?= htmlspecialchars($student->student_gender == 'Γυναίκα') ? 'checked' : ''; ?> > Γυναίκα<br />
                                            <div class="invalid-feedback">Παρακαλώ επιλέξτε φύλλο</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputAddress">Κατάσταση</label>
                                    <div class="col-md-12">
                                        <div class="form form-inline">
                                            <input type="radio" class="mr-1" name="studentStatus" value="Ενεργός" <?= htmlspecialchars($student-> student_status == 'Ενεργός') ? 'checked' : ''; checked?> /> Ενεργός<br />
                                        </div>
                                        <div class="form form-inline">
                                            <input type="radio" class="mr-1" name="studentStatus" value="Ανενεργός" <?= htmlspecialchars($student-> student_status == 'Ανενεργός') ? 'checked' : ''; ?> /> Ανενεργός<br />
                                            <div class="invalid-feedback">Παρακαλώ επιλέξτε κατάσταση</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="studentPhoto">Φωτογραφία</label>
                                    <input type="file"
                                    class="form-control-file"
                                    id="file"
                                    name="file">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="hidden" name="photo_current" value="<?= ($student-> student_photo);?>">

                                    <?php if ($student-> student_photo) : ?>
                                        <img src="<?= basedir ?>uploads/<?= $student-> student_photo ?>" alt="photo" class="rounded-circle border-primary" width="180">
                                    <?php else: ?>
                                        <img src="<?= basedir ?>images/avatar.png" alt="photo" class="rounded-circle border-primary" width="180">
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-danger border-button border-grey" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                            <button type="submit" name="edit_student_profile" class="btn btn-success border-button border-grey"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="container-fluid">

            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb  py-1">

                        <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-table mr-1 fa-user-graduate"></i>  Καρτέλα Μαθητή :<span class="text-primary"> <?= $student ->student_lastname ." ".  $student ->student_firstname; ?></span></h3>

                        <ol class="breadcrumb m-3 ">
                            <li class="breadcrumb-item"><a href="<?= basedir ?>index.php">Αρχική</a></li>
                            <li class="breadcrumb-item"><a href="<?= basedir ?>student.php">Μαθητές </a></li>
                            <li class="breadcrumb-item active">Καρτέλα Μαθητή</li>
                        </ol>
                    </div>
                </div>
            </div>

            <br>


            <nav class="skew-menu">
                <ul>
                    <li class="active"><a class="" href="student-profile.php?id=<?= $student -> student_id; ?>"><i class="fas fa-user"></i>&nbsp&nbspΠροφίλ</a></li>
                    <li class=""><a class="" href="student-courses.php?id=<?= $student -> student_id; ?>"><i class="fas fa-book-open"></i>&nbsp&nbspΜαθήματα</a></li>
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
                    <strong>Αποθήκευση!</strong> Οι αλλαγές καταχωρήθηκαν επιτυχώς.
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
                    <strong>Αποτυχία!</strong> Οι αλλαγές δεν καταχωρήθηκαν. Υπήρξε πρόβλημα με την αποθήκευση στη βάση δεδομένων.
                    <button type="button" class="close" data-dismiss="alert"  aria-label="Close" id="success_edit_message">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                unset($_SESSION['fail_edit_message']);
            }
            ?>

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <?php if ($student-> student_photo) : ?>
                                    <img src="../uploads/<?= $student -> student_photo ?>" alt="Admin" class="rounded-circle border-primary" width="180">
                                <?php else: ?>
                                    <img src="<?= basedir ?>images/avatar.png" alt="Admin" class="rounded-circle border-primary" width="180">
                                <?php endif; ?>
                                <div class="mt-3">
                                    <h4><?= ($student-> student_lastname); ?> <?= ($student-> student_firstname); ?></h4>
                                    <p class="text-secondary mb-1">Μαθητής</p>
                                    <p class="text-muted font-size-sm"><?= ($student-> student_address); ?>, <?= ($student-> student_city); ?>, <?= ($student-> student_county); ?>, <?= ($student-> student_postal_code); ?></p>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning btn-sm dropdown-toggle border-grey" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-edit"></i>&nbspΕπεξεργασία
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#bannerformmodal" data-toggle="modal" data-target="#edit-student-modal">Προφίλ</a>
                                            <!-- <a class="dropdown-item" href="#bannerformmodal" data-toggle="modal" data-target="#edit-student-modal1">Κωδικός Πρόσβασης</a> -->

                                            <!-- <div class="dropdown-divider"></div> -->
                                            <!-- <a class="dropdown-item" href="#">Separated link</a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Ονοματεπώνυμο</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($student-> student_lastname); ?> <?= ($student-> student_firstname); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Όνομα Πατέρα</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($student-> student_fathername); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Όνομα Μητέρας</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($student-> student_mothername); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($student-> student_email); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Κινητό</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($student-> student_mobile_phone); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Σταθερό</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($student-> student_fixed_phone); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Διεύθυνση</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($student-> student_address); ?>, <?= ($student-> student_city); ?>, <?= ($student-> student_county); ?>, <?= ($student-> student_postal_code); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Γέννηση</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= (date('d-m-Y', strtotime($student-> student_birthday)));?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Φύλλο</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($student-> student_gender); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Εγγραφή</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= (date('d-m-Y', strtotime($student-> student_registered_at)));?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

<?php require '../footer.php'; ?>
