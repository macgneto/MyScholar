<?php

// require 'classes/Url.php';
// require 'classes/User.php';
// require 'classes/Database.php';

require 'includes/init.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $db = new Database();
    // $conn = $db -> getConn();
    $conn = require 'includes/db.php';
    // if ($_POST['username'] == 'jim' && $_POST['password'] == '10254662') {
    //
    //
    if ($_POST['role'] == "student") {
        if (User::authenticateStudent($conn, $_POST['user_email'], $_POST['user_password'])) {
            Auth::login();
            Auth::setStudent();
            Url::redirect('/main/index.php');
        } else {
            $error = "Λανθασμένα στοιχεία, προσπαθήστε ξανά";
        }
    } elseif ($_POST['role'] == "teacher") {
        if (User::authenticateTeacher($conn, $_POST['user_email'], $_POST['user_password'])) {
            Auth::login();
            Auth::setTeacher();
            Url::redirect('/main/index.php');
        } else {
            $error = "Λανθασμένα στοιχεία, προσπαθήστε ξανά";
        }
    } elseif ($_POST['role'] == "secretary") {
        if (User::authenticateSecretary($conn, $_POST['user_email'], $_POST['user_password'])) {
            Auth::login();
            Auth::setSecretary();
            Url::redirect('/main/index.php');
        } else {
            $error = "Λανθασμένα στοιχεία, προσπαθήστε ξανά";
        }
    } elseif ($_POST['role'] == "admin") {
        if (User::authenticateAdmin($conn, $_POST['user_email'], $_POST['user_password'])) {
            Auth::login();
            Auth::setAdmin();
            Url::redirect('/main/index.php');
        } else {
            $error = "Λανθασμένα στοιχεία, προσπαθήστε ξανά!";
        }
    }





    //
    // if (User::authenticate($conn, $_POST['user_email'], $_POST['user_password'])) {
    //     Auth::login();
    //     Url::redirect('/admin/index.php');
    // } else {
    //     $error = "Λανθασμένα στοιχεία, προσπαθήστε ξανά";
    // }
}

?>

<!-- <?php require 'includes/header.php'; ?> -->












<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Page Title - SB Admin</title>
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->

        <link href="<?= basedir ?>css/styles.css" rel="stylesheet" />
        <link href="<?= basedir ?>css/custom-style.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
        <script src="js/scripts.js"></script>
    </head>

    <body class=" pattern">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="card shadow  rounded-xl mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Είσοδος</h3></div>
                                    <div class="card-body">
                                        <form method="post" class="needs-validation" novalidate>
                                          <?php if (!empty($error)) : ?>

                                            <div class="alert alert-danger" role="alert">
                                              <p><?= $error ?></p>
                                            </div>
                                          <?php endif; ?>


                                            <div class="form-group">
                                                <label class="small mb-1" for="user_email">Email</label>
                                                <input class="form-control py-1"
                                                name="user_email"
                                                id="user_email"
                                                type="email"
                                                placeholder="Εισάγετε το email σας"
                                                required
                                                />
                                                <div class="invalid-feedback">Παρακαλώ εισάγετε email</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="user_password">Κωδικός</label>
                                                <input class="form-control py-1"
                                                name="user_password"
                                                id="user_password"
                                                type="password"
                                                placeholder="Εισάγετε κωδικό πρόσβασης"
                                                required/>
                                                <div class="invalid-feedback">Παρακαλώ εισάγετε κωδικό πρόσβασης</div>
                                            </div>
                                            <div class="small mb-1">
                                                <label class="form-label">Επιλέξτε κατηγορία χρήστη</label>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <select class="form-control form-select-sm mb-3" name="role"  required>
                                                        <option value=""></option>
                                                        <option value="admin">Admin</option>
                                                        <option value="secretary">Γραμματεία</option>
                                                        <option value="teacher">Καθηγητής</option>
                                                        <option value="student">Μαθητής</option>
                                                        <div class="invalid-feedback">Παρακαλώ επιλέξτε κατάσταση</div>
                                                    </select>
                                                </div>

                                            </div>


                                            <!-- <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div> -->
                                            <div class="form-group d-flex justify-content-center  mt-4 mb-0">
                                                <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                                                <!-- <a class="btn btn-primary" href="index.php">Login</a> -->

                                                <button type="submit" name="LoginSubmit" class="btn btn-primary border-button border-radius-4"><i class="fas fa-sign-in-alt"></i>&nbsp&nbspΕίσοδος</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="card-footer text-center">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                    </div> -->
                                </div>
<!--
                                <div class="card shadow rounded-xl mt-3">
                                    <div class="card-body">

                                        <div class="row m-0">

                                            <div class="col-12 text-center">
                                                <a href="../app/myscholar.apk"><img src="images/android.png" alt="photo" class="" width="230px" ></a>
                                            </div>


                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>



                    </div>
                </main>
            </div>




            <div id="layoutAuthentication_footer">
                <footer class=" zero py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; MyScholar 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="<?= basedir ?>js/form-validation.js"></script>
    </body>
</html>

<!-- <?php require 'includes/footer.php'; ?> -->
