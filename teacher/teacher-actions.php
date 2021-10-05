<?php

require '../includes/init.php';

$teacher_course = new TeacherCourses();

$teacher_id = $_POST['teacher_id'];

$teacher = new Teacher();

// $payment = new Payment();

// $attendance = new Attendance();


/**
 * Add new teacher [code called upon modal submit button from teacher.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_teacher']))) {
    $conn = require '../includes/db.php';

    $teacher -> teacher_username = $_POST['teacherUsername'];
    $teacher -> teacher_password = $_POST['teacherPassword'];
    $teacher -> teacher_lastname = $_POST['teacherLastName'];
    $teacher -> teacher_firstname = $_POST['teacherFirstName'];
    $teacher -> teacher_fathername = $_POST['teacherFatherName'];
    $teacher -> teacher_mothername = $_POST['teacherMotherName'];
    $teacher -> teacher_email = $_POST['teacherEmail'];
    $teacher -> teacher_mobile_phone = $_POST['teacherMobile'];
    $teacher -> teacher_fixed_phone = $_POST['teacherFixedPhone'];
    $teacher -> teacher_address = $_POST['teacherAddress'];
    $teacher -> teacher_city = $_POST['teacherCity'];
    $teacher -> teacher_county = $_POST['teacherCounty'];
    $teacher -> teacher_postal_code = $_POST['teacherPostalCode'];
    $teacher -> teacher_birthday = $_POST['teacherBirthday'];
    $teacher -> teacher_gender = $_POST['teacherGender'];
    $teacher -> teacher_status = $_POST['teacherStatus'];
    $teacher -> teacher_comments = $_POST['teacherComments'];
    $teacher -> teacher_photo = $_POST['teacherPhoto'];

    if ($_FILES['file']['name']=='') {
        $teacher -> teacher_photo = $_POST['photo_current'] ;
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

        $teacher -> teacher_photo = $filename;
    }

    $teacher -> teacher_comments = $_POST['teacherComments'];
    if ($teacher -> createTeacher($conn)) {
        session_start();
        $_SESSION['success_add_message'] = "success";
        Url::redirect("/main/teacher/teacher-profile.php?id={$teacher -> teacher_id}");
    } else {
        session_start();
        $_SESSION['fail_add_message'] = "fail";
        Url::redirect("/main/teacher.php?");
    }
}


/**
 * Edit teacher [code called upon modal submit button from teacher.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_teacher']))) {
    $conn = require '../includes/db.php';

    $teacher -> teacher_id = $_POST['teacherID'];
    $teacher -> teacher_username = $_POST['teacherUsername'];
    $teacher -> teacher_password = $_POST['teacherPassword'];
    $teacher -> teacher_lastname = $_POST['teacherLastName'];
    $teacher -> teacher_firstname = $_POST['teacherFirstName'];
    $teacher -> teacher_fathername = $_POST['teacherFatherName'];
    $teacher -> teacher_mothername = $_POST['teacherMotherName'];
    $teacher -> teacher_email = $_POST['teacherEmail'];
    $teacher -> teacher_mobile_phone = $_POST['teacherMobile'];
    $teacher -> teacher_fixed_phone = $_POST['teacherFixedPhone'];
    $teacher -> teacher_address = $_POST['teacherAddress'];
    $teacher -> teacher_city = $_POST['teacherCity'];
    $teacher -> teacher_county = $_POST['teacherCounty'];
    $teacher -> teacher_postal_code = $_POST['teacherPostalCode'];
    $teacher -> teacher_birthday = $_POST['teacherBirthday'];
    $teacher -> teacher_gender = $_POST['teacherGender'];
    $teacher -> teacher_status = $_POST['teacherStatus'];
    $teacher -> teacher_comments = $_POST['teacherComments'];
    // $teacher -> teacher_photo = $_POST['file'];


    if ($_FILES['file']['name']=='') {
        $teacher -> teacher_photo = $_POST['photo_current'] ;
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

        $teacher -> teacher_photo = $filename;
    }


    if ($teacher -> updateTeacher($conn)) {
        session_start();
        $_SESSION['success_edit_message'] = "success";
        Url::redirect("/main/teachers.php");
    } else {
        session_start();
        $_SESSION['fail_edit_message'] = "fail";
        Url::redirect("/main/teacher.php");
    }
}



/**
 * Edit teacher [code called upon modal submit button from teacher-profile.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_teacher_profile']))) {
    $conn = require '../includes/db.php';

    $teacher -> teacher_id = $_POST['teacherID'];
    $teacher -> teacher_username = $_POST['teacherUsername'];
    $teacher -> teacher_password = $_POST['teacherPassword'];
    $teacher -> teacher_lastname = $_POST['teacherLastName'];
    $teacher -> teacher_firstname = $_POST['teacherFirstName'];
    $teacher -> teacher_fathername = $_POST['teacherFatherName'];
    $teacher -> teacher_mothername = $_POST['teacherMotherName'];
    $teacher -> teacher_email = $_POST['teacherEmail'];
    $teacher -> teacher_mobile_phone = $_POST['teacherMobile'];
    $teacher -> teacher_fixed_phone = $_POST['teacherFixedPhone'];
    $teacher -> teacher_address = $_POST['teacherAddress'];
    $teacher -> teacher_city = $_POST['teacherCity'];
    $teacher -> teacher_county = $_POST['teacherCounty'];
    $teacher -> teacher_postal_code = $_POST['teacherpostalCode'];
    $teacher -> teacher_birthday = $_POST['teacherBirthday'];
    $teacher -> teacher_gender = $_POST['teacherGender'];
    $teacher -> teacher_status = $_POST['teacherStatus'];
    $teacher -> teacher_comments = $_POST['teacherComments'];
    // $teacher -> teacher_photo = $_POST['file'];


    if ($_FILES['file']['name']=='') {
        $teacher -> teacher_photo = $_POST['photo_current'] ;
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

        $teacher -> teacher_photo = $filename;
    }


    if ($teacher -> updateTeacher($conn)) {
        session_start();
        $_SESSION['success_edit_message'] = "success";
        Url::redirect("/main/teacher/teacher-profile.php?id={$teacher -> teacher_id}");
    } else {
        session_start();
        $_SESSION['fail_edit_message'] = "fail";
        Url::redirect("/main/teacher/teacher-profile.php?id={$teacher -> teacher_id}");
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
