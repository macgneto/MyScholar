<?php

require 'includes/init.php';
// session_start();
$conn = require 'includes/db.php';


Auth::requireLogin();
// Auth::requireAdmin();
if (Auth::isStudent()) {
    Url::redirect("/main/index.php");
} elseif (Auth::isTeacher()){



        Url::redirect("/main/teacher/teacher-profile.php?id={$_SESSION['user_id']}");

// $teachers = Teacher::getByTeacherID($conn, $_SESSION['user_id']);


}


//
// if (isset($_GET['id'])) {
//     if (Auth::isAdmin() || Auth::isSecretary()) {
//         $student = Student::getByStudentID($conn, $_GET['id']);
//     } elseif (Auth::isStudent()) {
//         // $_GET['id'] = $_SESSION['user_id'];
//         $student = Student::getByStudentID($conn, $_SESSION['user_id']);
//     } else {
//         Url::redirect("/main/index.php");
//     }
// }



$teachers = Teacher::getAllTeachers($conn);

 require 'header.php';
 require 'sidebar.php';
 ?>

<div id="layoutSidenav_content">

    <main>


        <!-- Modal Add New Teacher -->
        <div class="modal fade" id="add_teacher_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Δημιουργία καρτέλας Καθηγητή</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form class="needs-validation" novalidate action="teacher/teacher-actions.php" method="post" enctype="multipart/form-data">

                        <div class="modal-body">

                            <div class="alert alert-primary" role="alert">
                                Εισάγετε τα στοιχεία του καθηγητή που θέλετε να καταχωρήσετε και πατήστε αποθήκευση.
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6 ">
                                    <label for="teacherUsername">Username</label>
                                    <input type="text"
                                    class="form-control"
                                    id="teacherUsername"
                                    name="teacherUsername"
                                    placeholder="Username"
                                    required
                                    value="<?= htmlspecialchars($teacher-> teacher_username);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Username Καθηγητή
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="teacherPassword">Κωδικός</label>
                                    <input type="password"
                                    class="form-control"
                                    id="teacherPassword"
                                    name="teacherPassword"
                                    placeholder="Κωδικός"
                                    required
                                    value="<?= htmlspecialchars($teacher-> teacher_password);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε κωδικό Καθηγητή
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 ">
                                    <label for="teacherLastName">Επίθετο</label>
                                    <input type="text"
                                    class="form-control"
                                    id="teacherLastName"
                                    name="teacherLastName"
                                    placeholder="Επίθετο"
                                    required
                                    value="<?= htmlspecialchars($teacher-> teacher_lastname);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Επίθετο Καθηγητή
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="teacherFirstName">Όνομα</label>
                                    <input type="text"
                                    class="form-control"
                                    id="teacherFirstName"
                                    name="teacherFirstName"
                                    placeholder="Όνομα"
                                    required
                                    value="<?= htmlspecialchars($teacher-> teacher_firstname);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Όνομα Καθηγητή
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="teacherFatherName">Όνομα Πατέρα</label>
                                    <input type="text"
                                    class="form-control"
                                    id="teacherFatherName"
                                    name="teacherFatherName"
                                    placeholder="Όνομα Πατέρα"
                                    required
                                    value="<?= htmlspecialchars($teacher-> teacher_fathername);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Όνομα Πατέρα
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="teacherFatherName">Όνομα Μητέρας</label>
                                    <input type="text"
                                    class="form-control"
                                    id="teacherMotherName"
                                    name="teacherMotherName"
                                    placeholder="Όνομα Μητέρας"
                                    required
                                    value="<?= htmlspecialchars($teacher-> teacher_mothername);?>">
                                    <div class="invalid-feedback">
                                        Παρακαλώ συμπληρώστε Όνομα Μητέρας
                                    </div>
                                </div>

                            </div>

                              <div class="form-row">
                                  <div class="form-group col-md-4 ">
                                      <label for="teacherEmail">Email Address</label>
                                      <input type="email"
                                      class="form-control"
                                      id="teacherEmail"
                                      name="teacherEmail"
                                      placeholder="Διεύθυνση Email"
                                      required
                                      value="<?= htmlspecialchars($teacher-> teacher_email);?>">
                                      <div class="invalid-feedback">
                                          Παρακαλώ συμπληρώστε email καθηγητή
                                      </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label for="teacherMobile">Κινητό Τηλέφωνο</label>
                                      <input type="tel"
                                      pattern="[0-9]{10}"
                                      class="form-control"
                                      id="teacherMobile"
                                      name="teacherMobile"
                                      placeholder="Κινητό Τηλέφωνο"
                                      required
                                      value="<?= htmlspecialchars($teacher-> teacher_mobile_phone);?>">
                                      <div class="invalid-feedback">
                                          Παρακαλώ συμπληρώστε κινητό τηλέφωνο
                                      </div>
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label for="teacherFixedPhone">Σταθερό Τηλέφωνο</label>
                                      <input type="tel"
                                      pattern="[0-9]{10}"
                                      class="form-control"
                                      id="teacherFixedPhone"
                                      name="teacherFixedPhone"
                                      placeholder="Σταθερό Τηλέφωνο"
                                      required
                                      value="<?= htmlspecialchars($teacher-> teacher_fixed_phone);?>">
                                      <div class="invalid-feedback">
                                          Παρακαλώ συμπληρώστε σταθερό τηλέφωνο
                                      </div>
                                  </div>
                              </div>

                              <div class="form-row">
                                  <div class="form-group col-md-4">
                                      <label for="teacherAddress">Διεύθυνση</label>
                                      <input type="text"
                                      class="form-control"
                                      id="teacherAddress"
                                      name="teacherAddress"
                                      placeholder="Διεύθυνση Κατοικίας"
                                      required
                                      value = "<?= htmlspecialchars($teacher-> teacher_address);?>">
                                      <div class="invalid-feedback">
                                          Παρακαλώ συμπληρώστε οδό και αριθμό κατοικίας
                                      </div>
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label for="teacherCity">Πόλη/Δήμος</label>
                                      <input type="text"
                                      class="form-control"
                                      id="teacherCity"
                                      name="teacherCity"
                                      placeholder="Πόλη/Δήμος"
                                      required
                                      value = "<?= htmlspecialchars($teacher-> teacher_city);?>">
                                      <div class="invalid-feedback">
                                          Παρακαλώ συμπληρώστε Πόλη/Δήμο
                                      </div>
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label for="teacherCounty">Νομός</label>
                                      <input type="text"
                                      class="form-control"
                                      id="teacherCounty"
                                      name="teacherCounty"
                                      placeholder="Νομός"
                                      required
                                      value = "<?= htmlspecialchars($teacher-> teacher_county);?>">
                                      <div class="invalid-feedback">
                                          Παρακαλώ συμπληρώστε Νομό
                                      </div>
                                  </div>
                                  <div class="form-group col-md-2">
                                      <label for="teacherpostalCode">Τ.Κ</label>
                                      <input type="text"
                                      class="form-control"
                                      id="teacherpostalCode"
                                      name="teacherPostalCode"
                                      placeholder="Τ.Κ"
                                      required
                                      value="<?= htmlspecialchars($teacher-> teacher_postal_code);?>">
                                      <div class="invalid-feedback">
                                          Παρακαλώ συμπληρώστε Ταχυδρομικό Κώδικα
                                      </div>
                                  </div>
                              </div>

                              <div class="form-row">
                                  <div class="form-group col-md-9">
                                      <label for="teacherComments">Παρατηρήσεις -Σχόλια</label>
                                      <input type="text"
                                      class="form-control"
                                      id="teacherComments"
                                      name="teacherComments"
                                      placeholder="Σχόλια"
                                      value="<?= htmlspecialchars($teacher-> teacher_comments);?>">
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label for="inputBirthday">Ημερομηνία Γέννησης</label>
                                      <input type="date"
                                      class="form-control"
                                      name="teacherBirthday"
                                      required
                                      value="<?= (date('d-m-Y', strtotime($teacher-> teacher_birthday)));?>" />
                                  </div>
                              </div>

                              <div class="form-row">
                                  <div class="form-group col-md-5">
                                      <label for="inputAddress">Φύλλο</label>
                                      <div class="col-md-12">
                                          <div class="form form-inline">
                                              <input type="radio" required class="form-check-input" name="teacherGender" value="Άνδρας" <?= htmlspecialchars($teacher-> teacher_gender == 'Άνδρας') ? 'checked' : ''; ?> > </input> Άνδρας<br/>
                                          </div>
                                          <div class="form form-inline">
                                              <input type="radio" required class="form-check-input" name="teacherGender" value="Γυναίκα" <?= htmlspecialchars($teacher-> teacher_gender == 'Γυναίκα') ? 'checked' : ''; ?> > Γυναίκα<br />
                                              <div class="invalid-feedback">Παρακαλώ επιλέξτε φύλλο</div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label for="inputAddress">Κατάσταση</label>
                                      <div class="col-md-12">
                                          <div class="form form-inline">
                                              <input type="radio" class="mr-1" name="teacherStatus" value="Ενεργός" <?= htmlspecialchars($teacher-> teacher_status == 'Ενεργός') ? 'checked' : ''; checked?> /> Ενεργός<br />
                                          </div>
                                          <div class="form form-inline">
                                              <input type="radio" class="mr-1" name="teacherStatus" value="Ανενεργός" <?= htmlspecialchars($teacher-> teacher_status == 'Ανενεργός') ? 'checked' : ''; ?> /> Ανενεργός<br />
                                              <div class="invalid-feedback">Παρακαλώ επιλέξτε κατάσταση</div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <hr>
                              <div class="form-row">
                                  <div class="form-group col-md-9">
                                      <label for="teacherPhoto">Φωτογραφία</label>
                                      <input type="file"
                                      class="form-control-file"
                                      id="teacherPhoto"
                                      name="teacherPhoto"

                                      value="<?= htmlspecialchars($teacher-> teacher_photo);?>">
                                  </div>
                                  <div class="form-group col-md-3">

                                  </div>
                              </div>

                          </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                              <button type="submit" name="add_teacher" class="btn btn-success border-dark"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div><!-- (END) Modal Add New Teacher -->


        <div class="container-fluid">

            <div class="row row-breadcrumb">
                <div class="col p-0 m-0">
                    <div class="card-breadcrumb py-1">
                        <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-user-tie"></i>  Καθηγητές </h3>
                            <ol class="breadcrumb m-3 ">
                            <li class="breadcrumb-item"><a class="text-success" href="index.php">Αρχική</a></li>
                            <li class="breadcrumb-item active">Καθηγητές</li>
                        </ol>
                    </div>
                </div>
            </div>

            <br>

            <!-- Add new teacher [modal button] -->
            <div class="card-body no-border">
                <?php if (Auth::isAdmin() || Auth::isSecretary()): ?>
                    <button type="button" class="btn  btn-success border-button " data-toggle="modal" data-target="#add_teacher_modal">
                        <i class="fa fa-user-plus"></i>&nbsp&nbsp</i>Προσθήκη Καθηγητή
                    </button>
                <?php endif; ?>
            </div>

            <div class="card mb-4 ">

                <div class="card-body ">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-green bg-light border-radius-7 full-gradient-bg-green " id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <div class="mb-2 text-success">
                                    <h6 class="text-center">
                                        <i class="fas fa-user-tie"></i>
                                        Λίστα Καθηγητών
                                    </h6>
                                </div>
                                <tr align="center ">
                                    <th>A/A</th>
                                    <th>Ονοματεπώνυμο</th>
                                    <th>Email</th>
                                    <th>Κινητό</th>
                                    <th>Κατάσταση</th>
                                    <th>Ενέργειες</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (empty($teachers)): ?>

                                    <tr>
                                        <td colspan="7" align="center"><b>Δεν έχετε καταχωρήσει Καθηγητές</b></td>
                                    </tr>

                                <?php else: ?>
                                    <?php $aa = 0; ?>
                                    <?php foreach ($teachers as $teacher) : ?>
                                        <tr align="center">

                                            <td width="40px" class="align-middle" ><?php echo $aa = $aa + 1;  ?></td>


                                            <td align="left">
                                                <?php if ($teacher['teacher_photo']) : ?>

                                                    <div class="row align-middle">
                                                        <div class="col-4">
                                                            <img src="<?= basedir ?>uploads/<?= $teacher['teacher_photo'] ?>" alt="photo" class="rounded-circle border-success" width="50">
                                                        </div>
                                                        <div class="col-8 a align-self-center">
                                                            <?= ($teacher["teacher_lastname"])." ".($teacher["teacher_firstname"]); ?>
                                                        </div>
                                                    </div>

                                                <?php else: ?>

                                                    <div class="row align-middle">
                                                        <div class="col-4">
                                                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="photo" class="rounded-circle border-success" width="50">
                                                        </div>
                                                        <div class="col-8 align-self-start align-self-center">
                                                            <?= ($teacher["teacher_lastname"])." ".($teacher["teacher_firstname"]); ?>
                                                        </div>
                                                    </div>

                                                <?php endif; ?>
                                            </td>

                                            <td class="text-dark align-middle"><?= ($teacher["teacher_email"]); ?></td>
                                            <td class="text-dark align-middle"><?= ($teacher["teacher_mobile_phone"]); ?></td>
                                            <!-- <td class="text-dark align-middle"><?= ($teacher["teacher_gender"]); ?></td> -->
                                            <td class="text-dark align-middle"><?= ($teacher["teacher_status"]); ?></td>
                                            <td class="text-center align-middle">
                                                <div class="box-body">
                                                    <a class="btn btn-white btn-sm button-rounded " href="teacher/teacher-profile.php?id=<?= $teacher["teacher_id"]; ?>" role="button" data-toggle="tooltip" data-placement="top" title="Προβολή" ><i class="fas fa-eye text-success"></i></a>
                                                    <span data-toggle="tooltip" data-placement="top" title="Επεξεργασία" >
                                                    <button type="button" id="edit_teacher" name="submit" value="<?= $teacher["teacher_id"];?>"
                                                        class="btn btn-white btn-sm  button-rounded ml-1" data-toggle="modal" data-target="#edit-teacher-modal-<?= $teacher["teacher_id"];?>"><i class="fas fa-edit text-orange"></i>
                                                    </span>
                                                </div>

                                                <!-- Modal Edit Student-->
                                                <div class="modal fade" id="edit-teacher-modal-<?= $teacher["teacher_id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία Στοιχείων Καθηγητή</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <form class="needs-validation" novalidate action="<?= basedir ?>teacher/teacher-actions.php" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body text-left align-middle">

                                                                    <input type="hidden" name="teacherID" value="<?= $teacher["teacher_id"] ;?>">

                                                                    <div class="alert alert-primary" role="alert">
                                                                        Διορθώστε τα στοιχεία που επιθυμείτε και πατήστε αποθήκευση.
                                                                    </div>


                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6 ">
                                                                            <label for="teacherUsername">Username</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherUsername"
                                                                            name="teacherUsername"
                                                                            placeholder="Username"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_username"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Username Καθηγητή
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="teacherPassword">Κωδικός</label>
                                                                            <input type="password"
                                                                            class="form-control"
                                                                            id="teacherPassword"
                                                                            name="teacherPassword"
                                                                            placeholder="Κωδικός"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_password"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Κωδικό Καθηγητή
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6 ">
                                                                            <label for="teacherLastName">Επίθετο</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherLastName"
                                                                            name="teacherLastName"
                                                                            placeholder="Επίθετο"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_lastname"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Επίθετο Καθηγητή
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="teacherFirstName">Όνομα</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherFirstName"
                                                                            name="teacherFirstName"
                                                                            placeholder="Όνομα"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_firstname"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Όνομα Καθηγητή
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="teacherMotherName">Όνομα Πατέρα</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherFatherName"
                                                                            name="teacherFatherName"
                                                                            placeholder="Όνομα Πατέρα"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_fathername"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Όνομα Πατέρα
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="teacherMotherName">Όνομα Μητέρας</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherMotherName"
                                                                            name="teacherMotherName"
                                                                            placeholder="Όνομα Μητέρας"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_mothername"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Όνομα Μητέρας
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4 ">
                                                                            <label for="teacherEmail">Email Address</label>
                                                                            <input type="email"
                                                                            class="form-control"
                                                                            id="teacherEmail"
                                                                            name="teacherEmail"
                                                                            placeholder="Διεύθυνση Email"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_email"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε email μαθητή
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="teacherMobile">Κινητό Τηλέφωνο</label>
                                                                            <input type="tel"
                                                                            pattern="[0-9]{10}"
                                                                            class="form-control"
                                                                            id="teacherMobile"
                                                                            name="teacherMobile"
                                                                            placeholder="Κινητό Τηλέφωνο"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_mobile_phone"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε κινητό τηλέφωνο
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="teacherFixedPhone">Σταθερό Τηλέφωνο</label>
                                                                            <input type="tel"
                                                                            pattern="[0-9]{10}"
                                                                            class="form-control"
                                                                            id="teacherFixedPhone"
                                                                            name="teacherFixedPhone"
                                                                            placeholder="Σταθερό Τηλέφωνο"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_fixed_phone"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε σταθερό τηλέφωνο
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label for="teacherAddress">Διεύθυνση Κατοικίας</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherAddress"
                                                                            name="teacherAddress"
                                                                            placeholder="Διεύθυνση Κατοικίας"
                                                                            required
                                                                            value = "<?= htmlspecialchars($teacher["teacher_address"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε οδό και αριθμό κατοικίας
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="teacherCity">Πόλη/Δήμος</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherCity"
                                                                            name="teacherCity"
                                                                            placeholder="Πόλη/Δήμος"
                                                                            required
                                                                            value = "<?= htmlspecialchars($teacher["teacher_city"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Πόλη/Δήμο
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="teacherCounty">Νομός</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherCounty"
                                                                            name="teacherCounty"
                                                                            placeholder="Νομός"
                                                                            required
                                                                            value = "<?= htmlspecialchars($teacher["teacher_county"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Νομό
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label for="teacherpostalCode">Τ.Κ</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherPostalCode"
                                                                            name="teacherPostalCode"
                                                                            placeholder="Ταχυδρομικός Κώδικας"
                                                                            required
                                                                            value="<?= htmlspecialchars($teacher["teacher_postal_code"]);?>">
                                                                            <div class="invalid-feedback">
                                                                                Παρακαλώ συμπληρώστε Ταχυδρομικό Κώδικα
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-9">
                                                                            <label for="teacherComments">Παρατηρήσεις - Σχόλια</label>
                                                                            <input type="text"
                                                                            class="form-control"
                                                                            id="teacherComments"
                                                                            name="teacherComments"
                                                                            placeholder="Παρατηρήσεις/Σχόλια"
                                                                            value="<?= htmlspecialchars($teacher["teacher_comments"]);?>">

                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="inputBirthday">Ημερομηνία Γέννησης</label>
                                                                            <input type="date"
                                                                            class="form-control"
                                                                            name="teacherBirthday"
                                                                            required
                                                                            value="<?= ($teacher["teacher_birthday"]);?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-5">
                                                                            <label for="inputAddress">Φύλλο</label>
                                                                            <div class="col-md-12">
                                                                                <div class="form form-inline">
                                                                                    <input type="radio" required class="form-check-input" name="teacherGender" value="Άνδρας" <?= htmlspecialchars($teacher["teacher_gender"] == 'Άνδρας') ? 'checked' : ''; ?> > </input> Άνδρας<br/>
                                                                                </div>
                                                                                <div class="form form-inline">
                                                                                    <input type="radio" required class="form-check-input" name="teacherGender" value="Γυναίκα" <?= htmlspecialchars($teacher["teacher_gender"] == 'Γυναίκα') ? 'checked' : ''; ?> > Γυναίκα<br />
                                                                                    <div class="invalid-feedback">Παρακαλώ επιλέξτε φύλλο</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="inputAddress">Κατάσταση</label>
                                                                            <div class="col-md-12">
                                                                                <div class="form form-inline">
                                                                                    <input type="radio" class="mr-1" name="teacherStatus" value="Ενεργός" <?= htmlspecialchars($teacher["teacher_status"] == 'Ενεργός') ? 'checked' : ''; checked?> /> Ενεργός<br />
                                                                                </div>
                                                                                <div class="form form-inline">
                                                                                    <input type="radio" class="mr-1" name="teacherStatus" value="Ανενεργός" <?= htmlspecialchars($teacher["teacher_status"] == 'Ανενεργός') ? 'checked' : ''; ?> /> Ανενεργός<br />
                                                                                    <div class="invalid-feedback">Παρακαλώ επιλέξτε κατάσταση</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <hr>
                                                                    <div class=" d-flex justify-content-around">
                                                                        <div class="form-group col-md-8">
                                                                            <label for="teacherPhoto">Φωτογραφία</label>
                                                                            <input type="file"
                                                                            class="form-control-file"
                                                                            id="file"
                                                                            name="file"
                                                                            >

                                                                        </div>
                                                                        <div class="form-group col-md-4 align-left">
                                                                            <input type="hidden" name="photo_current" value="<?= ($teacher["teacher_photo"]);?>">

                                                                            <?php if ($teacher['teacher_photo']) : ?>
                                                                                <img src="<?php basedir ?>uploads/<?= $teacher['teacher_photo'] ?>" alt="photo" class="rounded-circle border-success" width="180">
                                                                            <?php else: ?>
                                                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="photo" class="rounded-circle border-success" width="180">
                                                                            <?php endif; ?>




                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                                                                    <button type="submit" name="edit_teacher" class="btn btn-success border-dark"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- (END) Modal Edit teacher -->

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
