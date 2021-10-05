<?php

require '../includes/init.php';

$conn = require '../includes/db.php';


Auth::requireLogin();
// Auth::requireAdmin();
if (Auth::isStudent()) {
    Url::redirect("/main/index.php");
}

if (isset($_GET['id'])) {
    $teacher = Teacher::getByTeacherID($conn, $_GET['id']);
} else {
    $teacher = null;
}

$course_ids = array_column($teacher -> getTeacherCourses($conn), 'course_id');

$courses = TeacherCourses::getAllTeacherCourses($conn);


require '../header.php';

require '../sidebar.php';

?>

    <div id="layoutSidenav_content">
      <main>

          <div class="modal fade" id="edit-teacher-modal" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Επεξεργασία στοιχείων Καθηγητή</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>

                      <form class="needs-validation" novalidate action="<?= basedir ?>teacher/teacher-actions.php" method="post" enctype="multipart/form-data">
                          <div class="modal-body text-left align-middle">


                              <input type="hidden" name="teacherID" value="<?= $teacher-> teacher_id ;?>">

                              <div class="alert alert-primary" role="alert">
                                  Διορθώστε τα στοιχεία του καθηγητή και πατήστε αποθήκευση.
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
                                      value="<?= htmlspecialchars($teacher->teacher_password);?>">
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
                                      value="<?= htmlspecialchars($teacher->teacher_firstname);?>">
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
                                      value="<?= htmlspecialchars($teacher->teacher_fathername);?>">
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
                                      value="<?= htmlspecialchars($teacher->teacher_mothername);?>">
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
                                      value="<?= htmlspecialchars($teacher->teacher_email);?>">
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
                                      value="<?= htmlspecialchars($teacher->teacher_mobile_phone);?>">
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
                                      value="<?= htmlspecialchars($teacher->teacher_fixed_phone);?>">
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
                                      value = "<?= htmlspecialchars($teacher->teacher_address);?>">
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
                                      value = "<?= htmlspecialchars($teacher->teacher_city);?>">
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
                                      value = "<?= htmlspecialchars($teacher->teacher_county);?>">
                                      <div class="invalid-feedback">
                                          Παρακαλώ συμπληρώστε Νομό
                                      </div>
                                  </div>
                                  <div class="form-group col-md-2">
                                      <label for="teacherpostalCode">Τ.Κ</label>
                                      <input type="text"
                                      class="form-control"
                                      id="teacherpostalCode"
                                      name="teacherpostalCode"
                                      placeholder="Ταχυδρομικός Κώδικας"
                                      required
                                      value="<?= htmlspecialchars($teacher->teacher_postal_code);?>">
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
                                      value="<?= htmlspecialchars($teacher->teacher_comments);?>">

                                  </div>
                                  <div class="form-group col-md-3">
                                      <label for="inputBirthday">Ημερομηνία Γέννησης</label>
                                      <input type="date"
                                      class="form-control"
                                      name="teacherBirthday"
                                      required
                                      value="<?= ($teacher->teacher_birthday);?>">
                                  </div>
                              </div>

                              <div class="form-row">
                                  <div class="form-group col-md-5">
                                      <label for="inputAddress">Φύλλο</label>
                                      <div class="col-md-12">
                                          <div class="form form-inline">
                                              <input type="radio" required class="form-check-input" name="teacherGender" value="Άνδρας" <?= htmlspecialchars($teacher->teacher_gender == 'Άνδρας') ? 'checked' : ''; ?> > </input> Άνδρας<br/>
                                          </div>
                                          <div class="form form-inline">
                                              <input type="radio" required class="form-check-input" name="teacherGender" value="Γυναίκα" <?= htmlspecialchars($teacher->teacher_gender == 'Γυναίκα') ? 'checked' : ''; ?> > Γυναίκα<br />
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
                                      id="file"
                                      name="file"
                                      >

                                  </div>
                                  <div class="form-group col-md-3">
                                      <input type="hidden" name="photo_current" value="<?= ($teacher-> teacher_photo);?>">



                                      <?php if ($teacher-> teacher_photo) : ?>
                                          <img src="<?= basedir ?>uploads/<?= $teacher-> teacher_photo ?>" alt="photo" class="rounded-circle border-success" width="180">
                                      <?php else: ?>
                                          <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="photo" class="rounded-circle border-success" width="180">
                                      <?php endif; ?>




                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-danger border-button" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                              <button type="submit" name="edit_teacher_profile" class="btn btn-success border-button"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>




        <div class="container-fluid">


          <div class="row row-breadcrumb">
              <div class="col p-0 m-0">
                  <div class="card-breadcrumb  py-1">

                      <h3 class="mx-3 mt-3 mb-2"><i class="fas fa-user-tie mr-1"></i>  Καρτέλα Καθηγητή </h3>

                      <!-- <ol class="breadcrumb m-2 border-bottom-radius-7"> -->
                          <ol class="breadcrumb m-3 ">
                              <li class="breadcrumb-item"><a class="text-success" href="<?= basedir ?>index.php">Αρχική</a></li>
                              <li class="breadcrumb-item"><a class="text-success" href="<?= basedir ?>teachers.php">Καθηγητές </a></li>
                              <li class="breadcrumb-item active">Καρτέλα Καθηγητή</li>
                      </ol>
                  </div>
              </div>
          </div>
          <br>



          <!-- <nav class="nav nav-borders">
              <a class="nav-link" href="teacher-profile.php?id=<?= $teacher -> teacher_id; ?>">Προφίλ</a>
              <a class="nav-link" href="account-billing.html">Billing</a>
              <a class="nav-link" href="account-security.html">Security</a>
              <a class="nav-link" href="account-notifications.html">Notifications</a>
              <a class="nav-link active ms-0" href="teacher-courses.php">Μαθήματα</a>
          </nav>
          <hr class="mt-0 mb-4" /> -->

<!--
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center ">

              <li class="page-item active border-radius-7"><a class="page-link" > Προφίλ </a></li>
              <li class="page-item"><a class="page-link" href="#"> Ασφάλεια </a></li>
              <li class="page-item"><a class="page-link" href="teacher-courses.php?id=<?= $teacher -> teacher_id; ?>"> Μαθήματα </a></li>

              <li class="page-item"><a class="page-link" href="#"> Πληρωμές </a></li>

            </ul>
          </nav> -->


          <nav class="skew-menu teacher">
              <ul>
                  <li class="active"><a class="" href="teacher-profile.php?id=<?= $teacher -> teacher_id; ?>"><i class="fas fa-user"></i>&nbsp&nbspΠροφίλ</a></li>
                  <li class=""><a class="" href="teacher-courses.php?id=<?= $teacher -> teacher_id; ?>"><i class="fas fa-book-open"></i>&nbsp&nbspΜαθήματα</a></li>
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

          <!-- Success message on edit teacher -->
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

          <!-- Warning message on edit teacher -->
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
                      <?php if ($teacher-> teacher_photo) : ?>
                          <img src="../uploads/<?= $teacher -> teacher_photo ?>" alt="Admin" class="rounded-circle border-success" width="180">
                      <?php else: ?>
                      <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle border-success" width="180">
                      <?php endif; ?>
                      <div class="mt-3">
                        <h4><?= ($teacher-> teacher_lastname); ?> <?= ($teacher-> teacher_firstname); ?></h4>
                        <p class="text-secondary mb-1">Καθηγητής</p>
                        <p class="text-muted font-size-sm"><?= ($teacher-> teacher_address); ?>, <?= ($teacher-> teacher_city); ?>, <?= ($teacher-> teacher_county); ?>, <?= ($teacher-> teacher_postal_code); ?></p>


                         <div class="btn-group">
                            <button type="button" class="btn btn-warning btn-sm dropdown-toggle border-grey" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-edit"></i>&nbspΕπεξεργασία
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="#bannerformmodal" data-toggle="modal" data-target="#edit-teacher-modal">Προφίλ</a>
                              <!-- <a class="dropdown-item" href="#bannerformmodal" data-toggle="modal" data-target="#edit-teacher-modal1">Κωδικός Πρόσβασης</a> -->

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
                        <?= ($teacher-> teacher_lastname); ?> <?= ($teacher-> teacher_firstname); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Όνομα Πατέρα</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?= ($teacher-> teacher_fathername); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Όνομα Μητέρας</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?= ($teacher-> teacher_mothername); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?= ($teacher-> teacher_email); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Κινητό</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?= ($teacher-> teacher_mobile_phone); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Σταθερό</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?= ($teacher-> teacher_fixed_phone); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Address</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?= ($teacher-> teacher_address); ?>, <?= ($teacher-> teacher_city); ?>, <?= ($teacher-> teacher_county); ?>, <?= ($teacher-> teacher_postal_code); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Γέννηση</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?= (date('d-m-Y', strtotime($teacher-> teacher_birthday)));?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Φύλλο</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                         <?= ($teacher-> teacher_gender); ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Εγγραφή</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?= (date('d-m-Y', strtotime($teacher-> teacher_registered_at)));?>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                </div>















  </main>

<?php require '../footer.php'; ?>
