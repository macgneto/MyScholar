<?php

require 'includes/init.php';

Auth::requireLogin();

if (Auth::isStudent()) {
    Url::redirect("/main/student/student-profile.php?id={$_SESSION['user_id']}");
}



$conn = require 'includes/db.php';


if (Auth::isStudent()) {
    $students = Student::getByStudentID($conn, $_SESSION['user_id']);
}

if (Auth::isTeacher()) {
    $students = Student::getAllStudentsForTeacher($conn, $_SESSION['user_id']);
} elseif (Auth::isAdmin() || Auth::isSecretary()) {

    $students = Student::getAllStudents($conn);

}

// $students = Student::getAllStudents($conn);

$student = Student::getByStudentID($conn, $_GET['id']);

require 'header.php';

require 'sidebar.php';


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

        <!-- Modal Add New Student -->
        <div class="modal fade" id="add_student_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Δημιουργία καρτέλας Μαθητή</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form class="needs-validation" novalidate action="student/student-actions.php" method="post" enctype="multipart/form-data">

                        <div class="modal-body">

                            <div class="alert alert-primary" role="alert">
                                Εισάγετε τα στοιχεία του μαθητή που θέλετε να καταχωρήσετε και πατήστε αποθήκευση.
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
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

                                <div class="form-group col-md-6">
                                    <label for="studentLastName">Κωδικός Πρόσβασης</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentPassword"
                                    name="studentPassword"
                                    placeholder="Κωδικός"
                                    required
                                    value="<?= htmlspecialchars($student-> student_password);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Κωδικό πρόσβασης
                                    </div>
                                </div>




                            </div>



                            <div class="form-row">
                                <div class="form-group col-md-6">
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
                                    value="<?= htmlspecialchars($student-> student_firstname);?>">
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
                                    placeholder="Όνομα Πατέρα"
                                    required
                                    value="<?= htmlspecialchars($student["student_fathername"]);?>">
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
                                    placeholder="Όνομα Μητέρας"
                                    required
                                    value="<?= htmlspecialchars($student["student_mothername"]);?>">
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
                                    value="<?= htmlspecialchars($student-> student_email);?>">
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
                                    value="<?= htmlspecialchars($student-> student_mobile_phone);?>">
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
                                    value="<?= htmlspecialchars($student-> student_fixed_phone);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε σταθερό τηλέφωνο
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="studentAddress">Διεύθυνση</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentAddress"
                                    name="studentAddress"
                                    placeholder="Διεύθυνση Κατοικίας"
                                    required
                                    value = "<?= htmlspecialchars($student-> student_address);?>">
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
                                    value = "<?= htmlspecialchars($student-> student_city);?>">
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
                                    value = "<?= htmlspecialchars($student-> student_county);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Νομό
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="studentpostalCode">Τ.Κ</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentpostalCode"
                                    name="studentPostalCode"
                                    placeholder="Τ.Κ"
                                    required
                                    value="<?= htmlspecialchars($student-> student_postal_code);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Ταχυδρομικό Κώδικα
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="studentComments">Παρατηρήσεις -Σχόλια</label>
                                    <input type="text"
                                    class="form-control"
                                    id="studentComments"
                                    name="studentComments"
                                    placeholder="Σχόλια"
                                    value="<?= htmlspecialchars($student-> student_comments);?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputBirthday">Ημερομηνία Γέννησης</label>
                                    <input type="date"
                                    class="form-control"
                                    name="studentBirthday"
                                    required
                                    value="<?= (date('d-m-Y', strtotime($student-> student_birthday)));?>" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="inputAddress">Φύλλο</label>
                                    <div class="col-md-12">
                                        <div class="form form-inline">
                                            <input type="radio" required class="form-check-input" name="studentGender" value="Άνδρας" <?= htmlspecialchars($student-> student_gender == 'Άνδρας') ? 'checked' : ''; ?> > </input> Άνδρας<br/>
                                        </div>
                                        <div class="form form-inline">
                                            <input type="radio" required class="form-check-input" name="studentGender" value="Γυναίκα" <?= htmlspecialchars($student-> student_gender == 'Γυναίκα') ? 'checked' : ''; ?> > Γυναίκα<br />
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
                                    name="file"
                                    >

                                </div>
                                <div class="form-group col-md-3">
                                    <input type="hidden" name="photo_current" value="<?= ($student["student_photo"]);?>">



                                    <?php if ($student['student_photo']) : ?>
                                        <img src="<?= basedir ?>uploads/<?= $student['student_photo'] ?>" alt="photo" class="rounded-circle border-primary" width="180">
                                    <?php else: ?>
                                        <img src="<?= basedir ?>images/avatar.png" alt="photo" class="rounded-circle border-primary" width="180">
                                    <?php endif; ?>




                                </div>
                            </div>

                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-danger border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                            <button type="submit" name="add_student" class="btn btn-success border-button"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- (END) Modal Add New Student -->



        <div class="container-fluid">

            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb  py-1">

                        <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-table mr-1 fa-user-graduate"></i>  Μαθητές </h3>

                        <!-- <ol class="breadcrumb m-2 border-bottom-radius-7"> -->
                            <ol class="breadcrumb m-3 ">
                            <li class="breadcrumb-item"><a href="index.php">Αρχική</a></li>
                            <li class="breadcrumb-item active">Μαθητές</li>
                        </ol>
                    </div>
                </div>
            </div>










            <br>



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

            <!-- Warning message on add student -->
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



            <!-- Add new student [modal button] -->
            <div class="card-body no-border">
                <?php if (Auth::isAdmin() || Auth::isSecretary()) : ?>
                <button type="button" class="btn btn-primary border-button border-grey" data-toggle="modal" data-target="#add_student_modal">
                    <!-- <button type="button" class="btn btn-sm btn-primary button-white l-bg-blue-button border-button border-grey" data-toggle="modal" data-target="#add_student_modal"> -->
                    <i class="fa fa-user-plus"></i>&nbsp&nbsp</i>Προσθήκη Μαθητή
                </button>
            <?php endif; ?>
            </div>

            <div class="card mb-4">
                <!-- <div class="card-header">
                    <i class="fas fa-table mr-1 fa-user-graduate"></i>
                    Μαθητές
                </div> -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-blue bg-light border-radius-7 full-gradient-bg-blue" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <div class="mb-2 text-primary">
                                    <h6 class="text-center">
                                        <i class="fas fa-user-graduate"></i>
                                        Λίστα Μαθητών
                                    </h6>
                                </div>

                                <tr >
                                    <th class="text-center align-middle">A/A</th>
                                    <th class="text-center align-middle">Ονοματεπώνυμο</th>
                                    <!-- <th class="text-center align-middle">Όνομα</th> -->
                                    <th class="text-center align-middle">Email</th>
                                    <th class="text-center align-middle">Κινητό</th>
                                    <!-- <th class="text-center align-middle">Φύλλο</th> -->
                                    <th class="text-center align-middle">Κατάσταση</th>
                                    <th class="text-center align-middle">Ενέργειες</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php if (empty($students)): ?>
                                    <tr>
                                        <td colspan="8" align="center"><b>Δεν βρέθηκαν Μαθητές</b></td>
                                    </tr>

                                <?php else: ?>
                                    <?php $aa = 0; ?>
                                    <?php foreach ($students as $student) : ?>
                                        <tr>
                                            <td class="text-center align-middle" min-width="40px" align="center"><?php echo $aa = $aa + 1;  ?></td>

                                            <td align="left">
                                                <?php if ($student['student_photo']) : ?>

                                                    <div class="row align-middle">
                                                        <div class="col-4">
                                                            <img src="<?= basedir ?>uploads/<?= $student['student_photo'] ?>" alt="photo" class="rounded-circle border-primary" width="50">
                                                        </div>
                                                        <div class="col-8 a align-self-center">
                                                            <?= ($student["student_lastname"])." ".($student["student_firstname"]); ?>
                                                        </div>
                                                    </div>

                                                <?php else: ?>

                                                    <div class="row align-middle">
                                                        <div class="col-4">
                                                            <img src="<?= basedir ?>images/avatar.png" alt="photo" class="rounded-circle border-primary" width="50">
                                                        </div>
                                                        <div class="col-8 align-self-start align-self-center">
                                                            <?= ($student["student_lastname"])." ".($student["student_firstname"]); ?>
                                                        </div>
                                                    </div>

                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center align-middle"><?= ($student["student_email"]); ?></td>
                                            <td class="text-center align-middle"><?= ($student["student_mobile_phone"]); ?></td>

                                            <?php if ($student["student_status"] == "Ενεργός") : ?>
                                                <td class="text-center align-middle"><span class="badge badge-success"><?= ($student["student_status"]); ?></span></td>
                                            <?php else : ?>
                                                <td class="text-center align-middle"><span class="badge badge-danger"><?= ($student["student_status"]); ?></span></td>
                                            <?php endif; ?>





                                            <td class="text-center align-middle">
                                                <div class="box-body">
                                                    <?php if (Auth::isTeacher())  : ?>

                                                    <?php else: ?>

                                                    <a class="btn btn-white btn-sm button-rounded " href="student/student-profile.php?id=<?= $student["student_id"]; ?>" role="button" data-toggle="tooltip" data-placement="top" title="Προβολή"><i class="fas fa-eye text-primary"></i></a>
                                                <?php endif; ?>
                                                    <span data-toggle="tooltip" data-placement="top" title="Επεξεργασία" >

                                                        <?php if (Auth::isAdmin() || Auth::isSecretary()) : ?>
                                                    <button type="button" id="edit_student" name="submit" value="<?= $student["student_id"];?>"
                                                    class="btn btn-white btn-sm button-rounded mr-1" data-toggle="modal" data-target="#edit-student-modal-<?= $student["student_id"];?>"><i class="fas fa-edit text-orange"></i>
                                                <?php endif; ?>


                                                    </span>

                                                    <!-- Delete button show only for admin -->
            										    <?php if (Auth::isAdmin()) :?>

            									        <button type="button" name="deleteStudent" value="<?= $student["student_id"];?>"
            	   								        class="btn btn-white btn-sm button-rounded" data-toggle="modal" data-target="#delete-student-modal-<?= $student["student_id"];?>"><i class="fas fa-trash text-danger"></i>

            								            <?php endif; ?>
                                                </div>

                                                <!-- Modal Edit Student-->




                                                <div class="modal fade" id="edit-student-modal-<?= $student["student_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία στοιχείων Μαθητή</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <form class="needs-validation" novalidate action="<?= basedir ?>student/student-actions.php" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body text-left align-middle">


                                                                    <input type="hidden" name="studentID" value="<?= $student["student_id"] ;?>">

                                                                    <div class="alert alert-primary" role="alert">
                                                                        Διορθώστε τα στοιχεία του μαθητή και πατήστε αποθήκευση.
                                                                    </div>


                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="studentUsername">Username</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="studentUsername"
                                                                            name="studentUsername"
                                                                            placeholder="Username"
                                                                            required
                                                                            value="<?= htmlspecialchars($student["student_username"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Username μαθητή
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-md-6">
                                                                            <label for="studentLastName">Κωδικός Πρόσβασης</label>
                                                                            <input type="password"
                                                                            class="form-control"
                                                                            id="studentPassword"
                                                                            name="studentPassword"
                                                                            placeholder="Κωδικός"
                                                                            required
                                                                            value="<?= htmlspecialchars($student["student_password"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Κωδικό πρόσβασης
                                                                            </div>
                                                                        </div>




                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="studentLastName">Επίθετο</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="studentLastName"
                                                                            name="studentLastName"
                                                                            placeholder="Επίθετο"
                                                                            required
                                                                            value="<?= htmlspecialchars($student["student_lastname"]);?>">
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
                                                                            value="<?= htmlspecialchars($student["student_firstname"]);?>">
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
                                                                            placeholder="Όνομα Πατέρα"
                                                                            required
                                                                            value="<?= htmlspecialchars($student["student_fathername"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Όνομα Πατέρα
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-md-6">
                                                                            <label for="studentFatherName">Όνομα Μητέρας</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="studentMotherName"
                                                                            name="studentMotherName"
                                                                            placeholder="Όνομα Μητέρας"
                                                                            required
                                                                            value="<?= htmlspecialchars($student["student_mothername"]);?>">
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
                                                                            value="<?= htmlspecialchars($student["student_email"]);?>">
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
                                                                            value="<?= htmlspecialchars($student["student_mobile_phone"]);?>">
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
                                                                            value="<?= htmlspecialchars($student["student_fixed_phone"]);?>">
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
                                                                            value = "<?= htmlspecialchars($student["student_address"]);?>">
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
                                                                            value = "<?= htmlspecialchars($student["student_city"]);?>">
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
                                                                            value = "<?= htmlspecialchars($student["student_county"]);?>">
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
                                                                            placeholder="Τ.Κ"
                                                                            required
                                                                            value="<?= htmlspecialchars($student["student_postal_code"]);?>">
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
                                                                            value="<?= htmlspecialchars($student["student_comments"]);?>">

                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="inputBirthday">Ημερομηνία Γέννησης</label>
                                                                            <input type="date"
                                                                            class="form-control"
                                                                            name="studentBirthday"
                                                                            required
                                                                            value="<?= ($student["student_birthday"]);?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-5">
                                                                            <label for="inputAddress">Φύλλο</label>
                                                                            <div class="col-md-12">
                                                                                <div class="form form-inline">
                                                                                    <input type="radio" required class="form-check-input" name="studentGender" value="Άνδρας" <?= htmlspecialchars($student["student_gender"] == 'Άνδρας') ? 'checked' : ''; ?> > </input> Άνδρας<br/>
                                                                                </div>
                                                                                <div class="form form-inline">
                                                                                    <input type="radio" required class="form-check-input" name="studentGender" value="Γυναίκα" <?= htmlspecialchars($student["student_gender"] == 'Γυναίκα') ? 'checked' : ''; ?> > Γυναίκα<br />
                                                                                    <div class="invalid-feedback">Παρακαλώ επιλέξτε φύλλο</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="inputAddress">Κατάσταση</label>
                                                                            <div class="col-md-12">
                                                                                <div class="form form-inline">
                                                                                    <input type="radio" class="mr-1" name="studentStatus" value="Ενεργός" <?= htmlspecialchars($student["student_status"] == 'Ενεργός') ? 'checked' : ''; checked?> /> Ενεργός<br />
                                                                                </div>
                                                                                <div class="form form-inline">
                                                                                    <input type="radio" class="mr-1" name="studentStatus" value="Ανενεργός" <?= htmlspecialchars($student["student_status"] == 'Ανενεργός') ? 'checked' : ''; ?> /> Ανενεργός<br />
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
                                                                            name="file"
                                                                            >

                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <input type="hidden" name="photo_current" value="<?= ($student["student_photo"]);?>">



                                                                            <?php if ($student['student_photo']) : ?>
                                                                                <img src="<?= basedir ?>uploads/<?= $student['student_photo'] ?>" alt="photo" class="rounded-circle border-primary" width="180">
                                                                            <?php else: ?>
                                                                                <img src="<?= basedir ?>images/avatar.png" alt="photo" class="rounded-circle border-primary" width="180">
                                                                            <?php endif; ?>




                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-center">
                                                                    <button type="button" class="btn btn-danger border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                                                                    <button type="submit" name="edit_student" class="btn btn-success border-button"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- (END) Modal Edit student -->





                                                <!-- Delete student Modal -->
                                                <div class="modal fade" id="delete-student-modal-<?= $student["student_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog " role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Διαγραφή Μαθητή</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form action="student/student-actions.php" method="post" class="needs-validation" novalidate>

                                                        <div class="modal-body">


                                                            <input type="hidden" name="student_id" value="<?= $student['student_id'];?>">

                                                            <div class="alert alert-danger" role="alert">
                                                              <h4 class="alert-heading">Επιβεβαίωση Διαγραφής</h4>
                                                              <p>Είστε σίγουροι οτι θέλετε να διαγράψετε τον μαθητή με τα παρακάτω στοιχεία;</p>
                                                              <hr>
                                                              <p class="mb-0"><?= "Επίθετο : " . $student['student_lastname'];?></p>
                                                              <p class="mb-0"><?= "Όνομα : " . $student['student_firstname'];?></p>
                                                              <p class="mb-0"><?= "E-mail : " . $student['student_email'];?></p>
                                                              <p class="mb-0"><?= "Κινητό : " . $student['student_mobile_phone'];?></p>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                                                            <button type="submit" name="delete_student" class="btn btn-success border-dark" value="<?= $student["student_id"]; ?>"><i class="fas fa-save"></i>&nbsp&nbspΕπιβεβαίωση</button>
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

require 'footer.php';

?>
