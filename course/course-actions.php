<?php

require '../includes/init.php';

$course = new Course();


// $student_course = new StudentCourses();

$course_id = $_POST['course_id'];




/**
 * Add new course [code called upon modal submit button from course.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_course']))) {
    $conn = require '../includes/db.php';

    $course -> course_code = $_POST['course_code'];
    $course -> course_title = $_POST['course_title'];
    $course -> course_description = $_POST['course_description'];
    $course -> course_year = $_POST['course_year'];
    $course -> course_cost_hour_student = $_POST['course_cost_hour_student'];
    $course -> course_cost_hour_teacher = $_POST['course_cost_hour_teacher'];
    // $course -> course_cost_month_student = $_POST['course_cost_month_student'];

    if ($course -> createCourse($conn)) {
        session_start();
        $_SESSION['success_add_message'] = "success";
        Url::redirect("/main/course/course-view.php?id={$course -> course_id}");
    } else {
        session_start();
        $_SESSION['fail_add_message'] = "fail";
        Url::redirect("/main/course.php");
    }
}



/**
 * Edit course [code called upon modal submit button from course.php]
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_course']))) {
    $conn = require '../includes/db.php';

    $course -> course_id = $_POST['courseID'];
    $course -> course_code = $_POST['course_code'];
    $course -> course_title = $_POST['course_title'];
    $course -> course_description = $_POST['course_description'];
    $course -> course_year = $_POST['course_year'];
    $course -> course_cost_hour_student = $_POST['course_cost_hour_student'];
    $course -> course_cost_hour_teacher = $_POST['course_cost_hour_teacher'];
    // $course -> course_cost_month_student = $_POST['course_cost_month_student'];

    if ($course -> updateCourse($conn)) {
        session_start();
        $_SESSION['success_edit_message'] = "success";
        Url::redirect("/main/courses.php");
    } else {
        session_start();
        $_SESSION['fail_edit_message'] = "fail";
        Url::redirect("/main/courses.php");
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit-course-modal-btn']))) {
    $conn = require '../includes/db.php';


    $course -> course_id = $_POST['courseID'];
    $course -> course_code = $_POST['course_code'];
    $course -> course_title = $_POST['course_title'];
    $course -> course_description = $_POST['course_description'];
    $course -> course_year = $_POST['course_year'];
    $course -> course_cost_hour_student = $_POST['course_cost_hour_student'];
    $course -> course_cost_hour_teacher = $_POST['course_cost_hour_teacher'];
    // $course -> course_cost_month_student = $_POST['course_cost_month_student'];


    if ($course -> updateCourse($conn)) {
        session_start();
        $_SESSION['success_edit_message'] = "success";
        Url::redirect("/main/course/course-view.php?id={$course -> course_id}");
    } else {
        session_start();
        $_SESSION['fail_edit_message'] = "fail";
        Url::redirect("/main/course/course-view.php?id={$course -> course_id}");
    }
}

//
// /**
//  * Register student-course to class [code called upon modal submit button from student-course-view.php]
//  */
// if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_student_course_to_class'])) ) {
//
//     $conn = require '../includes/db.php';
//
//     $student_course -> sc_class_id = $_POST['class_id'];
//     $student_course -> sc_id = $_POST['sc_id'];
//     $student_course -> sc_course_id = $_POST['course_id'];
//
//
// // dokimastiko gia kostos to opoio doylevei
//     // $course = Course::getByCourseID($conn, $student_course -> sc_course_id );
//     // $student_course -> sc_cost_student = $course -> course_cost_for_student;
//
//     if ($student_course -> registerStudentCourseToClass($conn)) {
//
//         Url::redirect("/main/student/student-profile.php?id={$student_id}");
//
//     }
// }
//
//
//
//
// if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_class'])) ) {
//     $conn = require '../includes/db.php';
//
//
//
//     $class -> class_id = $_POST['class_id'];
//     $class -> class_code = $_POST['class_code'];
//     $class -> class_name = $_POST['class_name'];
//     $class -> class_description = $_POST['class_description'];
//     $class -> class_teacher_id = $_POST['class_teacher_id'];
//     $class -> class_course_id = $_POST['class_course_id'];
//
//
//
//     if ($class -> updateClass($conn)) {
//         Url::redirect("/main/classrooms.php");
//     }
// }
//
//
//
//
//
//
//
// if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_attendance'])) ) {
//
//     $conn = require '../includes/db.php';
//
// $class_id = $_POST['class_id'];
//
//     $attendance_update -> attendance_id = $_POST['attendance_id'];
//     $attendance_update -> attendance_status = $_POST['attendance_status'];
//     $attendnance_class_id = $_POST['attendance_class_id'];
//
//     if ($attendance_update -> updateAttendanceStatus($conn)) {
//
//             //     echo "
//             // <script>
//             //     alert('Record updated successfully!');
//             // </script>";
//
//         // header( "location:class-view.php?id={$attendnance_class_id}" );
//
//     }
// }
//
//
//
//
//
//
//
//
// if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['update_cost_modal_submit_button'])) ) {
//     $conn = require '../includes/db.php';
//
//
//     $student_course -> sc_id = $_POST['sc_id'];
//     $student_course -> sc_special_cost = $_POST['special_cost'];
//     $student_course -> sc_cost_type = $_POST['cost_type_dd'];
//     $sc_id = $_POST['sc_id'];
//
//
//
//     if ($student_course -> updateStudentCourseCost($conn)) {
//         Url::redirect("/main/student/student-course-view.php?id={$sc_id}");
//
//     }
// }
//
//
