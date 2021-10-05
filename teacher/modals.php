


<!-- Edit student inside student profile -->
<div class="modal fade" id="edit-student-modal-p" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Δημιουργία tffgejcejέου Τμήματος</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" novalidate action="<?= basedir ?>student/student-actions.php" method="post" enctype="multipart/form-data">
                <div class="modal-body text-left align-middle">


                    <input type="text" name="studentID" value="<?= $student-> student_id ;?>">

                    <div class="alert alert-primary" role="alert">
                        Εισάγετε τα στοιχεία του μαθητή που θέλετε να καταχωρήσετε.
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4 ">
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
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
                            <label for="studentFatherName">Πατρώνυμο</label>
                            <input type="text"
                            class="form-control"
                            id="studentFatherName"
                            name="studentFatherName"
                            placeholder="Όνομα Πατρός"
                            required
                            value="<?= htmlspecialchars($student->student_fathername);?>">
                            <div class="invalid-feedback">
                                Παρακαλώ συμπληρώστε Όνομα Πατρός
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
                            name="file"
                            >

                        </div>
                        <div class="form-group col-md-3">
                            <input type="hidden" name="photo_current" value="<?= ($student-> student_photo);?>">



                            <?php if ($student-> student_photo) : ?>
                                <img src="../admin/uploads/<?= $student-> student_photo ?>" alt="photo" class="rounded-circle" width="180">
                            <?php else: ?>
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="photo" class="rounded-circle" width="180">
                            <?php endif; ?>




                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger border-dark" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                    <button type="submit" name="edit_student" class="btn btn-success border-dark"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add Payment (money)-->
<div class="modal fade" id="add-payment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Καταχώρηση πληρωμής</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" novalidate action="student-actions.php" method="post" >
                <div class="modal-body">

                    <div class="alert alert-primary" role="alert">
                        Εισάγετε ποσό πληρωμής και πατήστε "Αποθήκευση"
                    </div>

                    <input type="hidden" name="payment_sc_id" class="form-control" id="inputClassCode" value="<?= ($student_course -> sc_id) ?>">

                        <!-- <table class="table table-striped table-bordered">
                            <tr>
                                <td class="text-center">
                                    <input type="datetime-local" name="attendance_date" value="<?php echo date('Y-m-d'); ?>" required/>
                                    <br/>

                                    <div class="invalid-feedback">
                                        Επιλέξτε ημερομηνία και ώρα διδασκαλίας
                                    </div>
                                </td>
                            </tr>

                        </table> -->
                    <div class="form-row">
                        <div class="form-group col-md-3 ">

                        </div>
                            <div class="form-group col-md-6 ">
                            <label for="inputClassCode">Ποσό Πληρωμής (€)</label>
                            <input type="number" min="1" name="payment_amount" class="form-control" id="inputClassCode" required >
                            <div class="invalid-feedback">
                                Παρακαλώ συμπληρώστε ποσό (>0)
                            </div>
                        </div>
                        <div class="form-group col-md-3 ">

                        </div>

                        <!-- <div class="form-group col-md-6">
                            <label for="inputClassName">Ονομασία Τμήματος</label>
                            <input type="text" name="class_name" class="form-control" id="inputClassName">
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="create_payment" class="btn btn-primary">Αποθήκευση</button>
                </div>

            </form>
        </div>
    </div>
</div>



<!-- Modal Add cost value and type inside student's course-->
<div class="modal fade" id="add-cost-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Διαχείρηση κόστους</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="student-actions.php" method="post">
                <div class="modal-body">
                    <div class="alert alert-primary" role="alert">
                        Παρακάτω μπορείτε να διαχειριστείτε το κόστος καθώς και το τρόπο χρέωσης που μπορεί να είναι ανα <b>ώρα</b> ή ανα <b>μήνα</b>.
                    </div>

                    <div class="form-group">
                        <input type="hidden" class="form-control" name="sc_id" value="<?= $student_course-> sc_id ?>" id="inputClassDescription" placeholder="Περιγραφή">
                    </div>

                    <div class="form-group">
                        <label for="inputClassDescription">Κόστος (€)</label>
                        <input type="text" class="form-control" name="special_cost" value="<?= $student_course-> sc_special_cost ?>" id="inputSpecialCost" placeholder="Κόστος">
                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <label for="cost_type_dd">Επιλέξτε τρόπο χρέωσης</label>
                            <select name="cost_type_dd" id="cost_type_dd" class="form-control">
                                <option disabled>Επιλέξτε...</option>
                                <option name="cost_type_dd" value="hour" <?php if ($student_course -> sc_cost_type == "hour") {
    echo 'selected="selected"';
} ?> >ανα ώρα</option>

                                <option name="cost_type_dd" value="month" <?php if ($student_course -> sc_cost_type == "month") {
    echo 'selected="selected"';
} ?> >ανα μήνα</option>

                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp&nbspΑκύρωση</button>
                    <button type="submit" name="update_cost_modal_submit_button" class="btn btn-success"><i class="fas fa-save"></i>&nbsp&nbspΑποθήκευση</button>
                </div>
            </form>
        </div>
    </div>
</div>
