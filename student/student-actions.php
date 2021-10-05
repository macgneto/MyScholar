<?php

require '../includes/init.php';

$student_course = new StudentCourses();

$student_id = $_POST['student_id'];

$student = new Student();

$payment = new Payment();

$attendance = new Attendance();
/**
 * Add new student [code called upon modal submit button from student.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_student']))) {
    $conn = require '../includes/db.php';
    $student -> student_username = $_POST['studentUsername'];
    $student -> student_password = $_POST['studentPassword'];
    $student -> student_lastname = $_POST['studentLastName'];
    $student -> student_firstname = $_POST['studentFirstName'];
    $student -> student_fathername = $_POST['studentFatherName'];
    $student -> student_mothername = $_POST['studentMotherName'];
    $student -> student_email = $_POST['studentEmail'];
    $student -> student_mobile_phone = $_POST['studentMobile'];
    $student -> student_fixed_phone = $_POST['studentFixedPhone'];
    $student -> student_address = $_POST['studentAddress'];
    $student -> student_city = $_POST['studentCity'];
    $student -> student_county = $_POST['studentCounty'];
    $student -> student_postal_code = $_POST['studentPostalCode'];
    $student -> student_birthday = $_POST['studentBirthday'];
    $student -> student_gender = $_POST['studentGender'];
    $student -> student_status = $_POST['studentStatus'];
    $student -> student_comments = $_POST['studentComments'];
    $student -> student_photo = $_POST['studentPhoto'];
    $student -> student_comments = $_POST['studentComments'];

    if ($_FILES['file']['name']=='') {
        $student -> student_photo = $_POST['photo_current'] ;
    } else {

    // Restrict the file size
        if ($_FILES['file']['size'] > 10000000) {
            throw new Exception('File is too large');
        }

        // Restrict the file type
        $mime_types = ['image/gif', 'image/png', 'image/jpeg'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if (! in_array($mime_type, $mime_types)) {
            throw new Exception('Invalid file type');
        }

        // Move the uploaded file
        $pathinfo = pathinfo($_FILES["file"]["name"]);

        $base = $pathinfo['filename'];

        // Replace any characters that aren't letters, numbers, underscores or hyphens with an underscore
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);

        // Restrict the filename to 200 characters
        $base = mb_substr($base, 0, 200);

        $filename = $base . "." . $pathinfo['extension'];

        $destination = "../uploads/$filename";

        // Add a numeric suffix to the filename to avoid overwriting existing files
        $i = 1;

        while (file_exists($destination)) {
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "../uploads/$filename";

            $i++;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            // if ($article->setImageFile($conn, $filename)) {
        // }
        } else {
            throw new Exception('Unable to move uploaded file');
        }

        $student -> student_photo = $filename;
    }


    if ($student -> createStudent($conn)) {
        session_start();
        $_SESSION['success_add_message'] = "success";
        Url::redirect("/main/student/student-profile.php?id={$student -> student_id}");
    } else {
        session_start();
        $_SESSION['fail_add_message'] = "fail";
        Url::redirect("/main/student.php?");
    }
}


/**
 * Edit student [code called upon modal submit button from student.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_student']))) {
    $conn = require '../includes/db.php';

    $student -> student_id = $_POST['studentID'];
    $student -> student_username = $_POST['studentUsername'];
    $student -> student_password = $_POST['studentPassword'];
    $student -> student_lastname = $_POST['studentLastName'];
    $student -> student_firstname = $_POST['studentFirstName'];
    $student -> student_fathername = $_POST['studentFatherName'];
    $student -> student_mothername = $_POST['studentMotherName'];
    $student -> student_email = $_POST['studentEmail'];
    $student -> student_mobile_phone = $_POST['studentMobile'];
    $student -> student_fixed_phone = $_POST['studentFixedPhone'];
    $student -> student_address = $_POST['studentAddress'];
    $student -> student_city = $_POST['studentCity'];
    $student -> student_county = $_POST['studentCounty'];
    $student -> student_postal_code = $_POST['studentpostalCode'];
    $student -> student_birthday = $_POST['studentBirthday'];
    $student -> student_gender = $_POST['studentGender'];
    $student -> student_status = $_POST['studentStatus'];
    $student -> student_comments = $_POST['studentComments'];
    // $student -> student_photo = $_POST['file'];


    if ($_FILES['file']['name']=='') {
        $student -> student_photo = $_POST['photo_current'] ;
    } else {

    // Restrict the file size
        if ($_FILES['file']['size'] > 10000000) {
            throw new Exception('File is too large');
        }

        // Restrict the file type
        $mime_types = ['image/gif', 'image/png', 'image/jpeg'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if (! in_array($mime_type, $mime_types)) {
            throw new Exception('Invalid file type');
        }

        // Move the uploaded file
        $pathinfo = pathinfo($_FILES["file"]["name"]);

        $base = $pathinfo['filename'];

        // Replace any characters that aren't letters, numbers, underscores or hyphens with an underscore
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);

        // Restrict the filename to 200 characters
        $base = mb_substr($base, 0, 200);

        $filename = $base . "." . $pathinfo['extension'];

        $destination = "../uploads/$filename";

        // Add a numeric suffix to the filename to avoid overwriting existing files
        $i = 1;

        while (file_exists($destination)) {
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "../uploads/$filename";

            $i++;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            // if ($article->setImageFile($conn, $filename)) {
        // }
        } else {
            throw new Exception('Unable to move uploaded file');
        }

        $student -> student_photo = $filename;
    }


    if ($student -> updateStudent($conn)) {
        // session_start();
        $_SESSION['success_edit_message'] = "success";
        Url::redirect("/main/student.php");
    } else {
        session_start();
        $_SESSION['fail_edit_message'] = "fail";
        Url::redirect("/main/student.php");
    }
}



/**
 * Edit student [code called upon modal submit button from student-profile.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_student_profile']))) {
    $conn = require '../includes/db.php';

    $student -> student_id = $_POST['studentID'];
    $student -> student_username = $_POST['studentUsername'];
    $student -> student_password = $_POST['studentPassword'];
    $student -> student_lastname = $_POST['studentLastName'];
    $student -> student_firstname = $_POST['studentFirstName'];
    $student -> student_fathername = $_POST['studentFatherName'];
    $student -> student_mothername = $_POST['studentMotherName'];
    $student -> student_email = $_POST['studentEmail'];
    $student -> student_mobile_phone = $_POST['studentMobile'];
    $student -> student_fixed_phone = $_POST['studentFixedPhone'];
    $student -> student_address = $_POST['studentAddress'];
    $student -> student_city = $_POST['studentCity'];
    $student -> student_county = $_POST['studentCounty'];
    $student -> student_postal_code = $_POST['studentpostalCode'];
    $student -> student_birthday = $_POST['studentBirthday'];
    $student -> student_gender = $_POST['studentGender'];
    $student -> student_status = $_POST['studentStatus'];
    $student -> student_comments = $_POST['studentComments'];
    // $student -> student_photo = $_POST['file'];


    if ($_FILES['file']['name']=='') {
        $student -> student_photo = $_POST['photo_current'] ;
    } else {

    // Restrict the file size
        if ($_FILES['file']['size'] > 10000000) {
            throw new Exception('File is too large');
        }

        // Restrict the file type
        $mime_types = ['image/gif', 'image/png', 'image/jpeg'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if (! in_array($mime_type, $mime_types)) {
            throw new Exception('Invalid file type');
        }

        // Move the uploaded file
        $pathinfo = pathinfo($_FILES["file"]["name"]);

        $base = $pathinfo['filename'];

        // Replace any characters that aren't letters, numbers, underscores or hyphens with an underscore
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);

        // Restrict the filename to 200 characters
        $base = mb_substr($base, 0, 200);

        $filename = $base . "." . $pathinfo['extension'];

        $destination = "../uploads/$filename";

        // Add a numeric suffix to the filename to avoid overwriting existing files
        $i = 1;

        while (file_exists($destination)) {
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "../uploads/$filename";

            $i++;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            // if ($article->setImageFile($conn, $filename)) {
        // }
        } else {
            throw new Exception('Unable to move uploaded file');
        }

        $student -> student_photo = $filename;
    }


    if ($student -> updateStudent($conn)) {
        session_start();
        $_SESSION['success_edit_message'] = "success";
        Url::redirect("/main/student/student-profile.php?id={$student -> student_id}");
    } else {
        session_start();
        $_SESSION['fail_edit_message'] = "fail";
        Url::redirect("/main/student/student-profile.php?id={$student -> student_id}");
    }
}



// delete student
//
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['delete_student']))) {
    $conn = require '../includes/db.php';
    $student -> student_id = $_POST['student_id'];
    // $class -> class_code = $_POST['class_code'];
    // $class -> class_name = $_POST['class_name'];
    // $class -> class_description = $_POST['class_description'];
    // $class -> class_teacher_id = $_POST['class_teacher_id_edit'];
    // $class -> class_course_id = $_POST['class_course_id_edit'];
    // var_dump($class -> class_id);
    // exit;
    if ($student -> deleteStudent($conn)) {
        Url::redirect("/main/student.php");
    }
}



/**
 * Register student-course to class [code called upon modal submit button from student-course-view.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_student_course_to_class']))) {
    $conn = require '../includes/db.php';

    $student_course -> sc_class_id = $_POST['class_id'];
    $student_course -> sc_id = $_POST['sc_id'];
    $student_course -> sc_course_id = $_POST['course_id'];


    // dokimastiko gia kostos to opoio doylevei
    // $course = Course::getByCourseID($conn, $student_course -> sc_course_id );
    // $student_course -> sc_cost_student = $course -> course_cost_for_student;

    if ($student_course -> registerStudentCourseToClass($conn)) {
        Url::redirect("/main/student/student-profile.php?id={$student_id}");
    }
}




if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_class']))) {
    $conn = require '../includes/db.php';



    $class -> class_id = $_POST['class_id'];
    $class -> class_code = $_POST['class_code'];
    $class -> class_name = $_POST['class_name'];
    $class -> class_description = $_POST['class_description'];
    $class -> class_teacher_id = $_POST['class_teacher_id'];
    $class -> class_course_id = $_POST['class_course_id'];
    // $class -> class_description = $_POST['class_description'];


    if ($class -> updateClass($conn)) {
        Url::redirect("/main/classrooms.php");
    }
}





$class_id = $_POST['class_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_attendance']))) {
    $conn = require '../includes/db.php';


    $attendance_update -> attendance_id = $_POST['attendance_id'];
    $attendance_update -> attendance_status = $_POST['attendance_status'];
    $attendnance_class_id = $_POST['attendnace_class_id'];

    if ($attendance_update -> updateAttendanceStatus($conn)) {
        echo "
            <script>
                alert('Record updated successfully!');
            </script>";

        header("location:class-view.php?id={$attendnance_class_id}");
    }
}








if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['update_cost_modal_submit_button']))) {
    $conn = require '../includes/db.php';


    $student_course -> sc_id = $_POST['sc_id'];
    $student_course -> sc_special_cost = $_POST['special_cost'];
    $student_course -> sc_cost_type = $_POST['cost_type_dd'];
    $sc_id = $_POST['sc_id'];
    // $student_class -> class_name = $_POST['class_name'];
    // $class -> class_description = $_POST['class_description'];
    // $class -> class_teacher_id = $_POST['class_teacher_id'];
    // $class -> class_course_id = $_POST['class_course_id'];
    // $class -> class_description = $_POST['class_description'];


    if ($student_course -> updateStudentCourseCost($conn)) {
        Url::redirect("/main/student/student-course-view.php?id={$sc_id}");
        // echo "geia";
        // exit;
    }
}






/**
 * Add payment
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['create_payment']))) {
    $conn = require '../includes/db.php';

    $payment -> payment_amount = $_POST['payment_amount'];
    $payment -> payment_sc_id = $_POST['payment_sc_id'];
    // $sc_id = $_POST['sc_id'];
    // $payment -> payment_date_time = $_POST['payment_date_time'];
    // $student -> student_email = $_POST['studentEmail'];
    // $student -> student_mobile = $_POST['studentMobile'];
    // $student -> student_fixedphone = $_POST['studentFixedPhone'];
    // $student -> student_address = $_POST['studentAddress'];
    // $student -> student_city = $_POST['studentCity'];
    // $student -> student_county = $_POST['studentCounty'];
    // $student -> student_postal_code = $_POST['studentpostalCode'];
    // $student -> student_birthdate = $_POST['studentBirthDate'];
    // $student -> student_gender = $_POST['studentGender'];
    // $student -> student_status = $_POST['studentStatus'];
    // $student -> student_comments = $_POST['studentComments'];

    if ($payment -> createPayment($conn)) {
        session_start();
        $_SESSION['success_add_message'] = "success";
        Url::redirect("/main/student/student-course-view.php?id={$payment -> payment_sc_id}");
    } else {
        session_start();
        $_SESSION['fail_add_message'] = "fail";
        Url::redirect("/main/student/student-course-view.php?{}");
    }
}



/**
 * Edit payment
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_student_course_payment_record']))) {
    $conn = require '../includes/db.php';
    $sc_id = $_POST['sc_id'];
    $payment_amount = $_POST['payment_amount'];
    $payment_id = $_POST['payment_id'];

    if ($payment -> editStudentCoursePayment($conn, $payment_id, $payment_amount)) {
        session_start();
        $_SESSION['success_add_message'] = "success";
        Url::redirect("/main/student/student-course-view.php?id={$sc_id}");
    } else {
        session_start();
        $_SESSION['fail_add_message'] = "fail";
        Url::redirect("/main/student/student-course-view.php?{$sc_id}");
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['verify_attendance']))) {
    $conn = require '../includes/db.php';

    $attendance -> attendance_id = $_POST['attendance_id'];
    $sc_id = $_POST['sc_id'];


    if ($attendance -> verifyAttendance($conn)) {
        session_start();
        $_SESSION['success_verify_attendance_message'] = "success";
        Url::redirect("/main/student/student-course-view.php?id={$sc_id}");
    } else {
        session_start();
        $_SESSION['fail_verify_attendance_message'] = "fail";
        Url::redirect("/main/student/student-course-view.php?id={$sc_id}");
    }
}
