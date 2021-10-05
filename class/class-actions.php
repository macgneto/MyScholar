<?php

require '../includes/init.php';
Auth::requireLogin();
$conn = require '../includes/db.php';


/**
 *  Define new objects from class and attendance to use below
 */
$class = new Classes();
$attendance_update = new Attendance();



/**
 *  Creating a new classroom
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add_class']))) {
    $class -> class_code = $_POST['class_code'];
    $class -> class_name = $_POST['class_name'];
    $class -> class_description = $_POST['class_description'];
    $class -> class_teacher_id = $_POST['class_teacher_id'];
    $class -> class_course_id = $_POST['class_course_id'];
    // $class -> class_description = $_POST['class_description'];


    if ($class -> createClass($conn)) {
        $class -> message = "success";
        echo '<script language="javascript">';
        echo 'alert("Successfully Registered"); location.href="/main/classrooms.php"';
        echo '</script>';
        // Url::redirect("/main/classrooms.php");
    }
}

//
// if (isset($_GET['class_id'])) {
//     $class = Classes::getByClassID($conn, $_GET['class_id']);
//
// }

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_class']))) {
    $class -> class_id = $_POST['class_id'];
    $class -> class_code = $_POST['class_code'];
    $class -> class_name = $_POST['class_name'];
    $class -> class_description = $_POST['class_description'];
    // $class -> class_teacher_id = $_POST['class_teacher_id_edit'];
    // $class -> class_course_id = $_POST['class_course_id_edit'];

    if ($class -> updateClass($conn)) {
        Url::redirect("/main/classrooms.php");
    }
}


// delete classroom
//
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['delete_class']))) {
    $class -> class_id = $_POST['class_id'];
    // $class -> class_code = $_POST['class_code'];
    // $class -> class_name = $_POST['class_name'];
    // $class -> class_description = $_POST['class_description'];
    // $class -> class_teacher_id = $_POST['class_teacher_id_edit'];
    // $class -> class_course_id = $_POST['class_course_id_edit'];
    // var_dump($class -> class_id);
    // exit;
    if ($class -> deleteClass($conn)) {
        Url::redirect("/main/classrooms.php");
    }
}




$class_id = $_POST['class_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_attendance']))) {
    // $conn = require '../includes/db.php';

    $attendance_date = date('Y-m-d H:i:s', strtotime($_POST['attendance_date']));
    // var_dump($attendance_date);
    // exit;
    $attendance_update -> attendance_date = $attendance_date;
    $attendance_update -> attendance_id = $_POST['attendance_id'];
    $attendance_update -> attendance_status = $_POST['attendance_status'];
    $attendance_update -> attendance_duration = $_POST['attendance_duration'];
    $attendance_class_id = $_POST['attendnace_class_id'];

    if ($attendance_update -> updateAttendanceStatus($conn)) {
        // Url::redirect("/main/classrooms.php");
        // echo '<script language="javascript">';
        // echo 'alert("Successfully Registered"); location.href="/main/class/class-view.php?id=$attendance_class_id"';
        // echo 'alert("Successfully Registered")';
        //
        // echo '</script>';
        //         header("location:class-view.php?id={$attendnance_class_id}");

        // echo "<script> alert('Record updated successfully!'); </script>";
        // var_dump($attendance_update -> student_mail);
        // exit;
        header("location:class-view.php?id={$attendance_class_id}");
    }
}



/**
 *  We check to see if there is any attendance record with the same record, if there isn't then execute the the insert
 */

if (isset($_POST['add-attendance-data-modal-button'])) {
    // $class->message = 0;
    $class_id = $_POST['class_id'];

    $sc_id = $_POST['sc_id'];

    $class_profile = Classes::getByClassID($conn, $class_id);

    $course_profile = Course::getByCourseID($conn, $class_profile -> class_course_id);

    $attendances = Attendance::getAttendanceByClass($conn, $_POST['class_id']);
    // $att_xi = 0;
    foreach ($attendances as $attendance) {
        $sql = "SELECT COUNT(*) FROM attendance
          WHERE attendance.attendance_student_id = :attendance_student_id
          AND attendance.attendance_class_id = :attendance_class_id
          AND attendance.attendance_date = :attendance_date";

        $stmt = $conn->prepare($sql);

        $class_id = $attendance["class_id"];
        $student_id = $attendance["student_id"];
        // $attendance_student_present = $attendance["attendance_student_present"];
        // $attendance_status = $_POST["attendance_status".$attendance["student_id"]] ;
        $attendance_date = $_POST["attendance_date"];
        // var_dump($class_id);
        // var_dump($student_id);
        // var_dump($attendance_date);
        // exit;
        // jim
        // $sc_id = $attendance["sc_id"];

        $stmt -> bindValue(':attendance_class_id', $class_id, PDO::PARAM_INT);
        $stmt -> bindValue(':attendance_student_id', $student_id, PDO::PARAM_INT);
        // $stmt -> bindValue(':attendance_status', $attendance_status, PDO::PARAM_STR);
        $stmt -> bindValue(':attendance_date', $attendance_date, PDO::PARAM_STR);
        // $stmt -> bindValue(':attendance_sc_id', $attendance_sc_id, PDO::PARAM_INT);
        $stmt->execute();
        // $att_xi = $att_xi + 1 ;
        // $xx = $stmt -> rowCount();
    }
    if ($stmt->fetchColumn()) {
        // var_dump($xx);
        // exit;
        // if ($xx > 0) {
        // echo "('found')";


        session_start();
        $_SESSION['fail_edit_message'] = "fail";
        Url::redirect("/main/class/class-view.php?id={$class_id}");
    // echo "Επιστροφή" .header("location:class-view.php?id={$class_id}");
    } else {
        $sql = "INSERT INTO attendance (attendance_class_id, attendance_student_id, attendance_sc_id, attendance_status, attendance_duration, attendance_date)
          VALUES (:attendance_class_id, :attendance_student_id, :attendance_sc_id, :attendance_status, :attendance_duration, :attendance_date)";


        $stmt = $conn -> prepare($sql);

        foreach ($attendances as $attendance) {
            $class_id = $attendance["class_id"];
            $student_id = $attendance["student_id"];
            $sc_id = $attendance["sc_id"];
            // $attendance_student_present = $attendance["attendance_student_present"];
            $attendance_status = $_POST["attendance_status".$attendance["student_id"]] ;
            $attendance_date = $_POST["attendance_date"];
            $attendance_duration = $_POST["attendance_duration".$attendance["student_id"]];

            // $attendance_date = date('d-m-Y',strtotime($_POST['attendance_date']));
            // $attendance_date_formated = strtotime ($attendance_date ("d-m-Y"));
            // $attendance_student_present$attendance["student_id"]
            // $attendance_student_present = . $attendance_student_present ;
            $stmt -> bindValue(':attendance_class_id', $class_id, PDO::PARAM_INT);
            $stmt -> bindValue(':attendance_student_id', $student_id, PDO::PARAM_INT);
            $stmt -> bindValue(':attendance_sc_id', $sc_id, PDO::PARAM_INT);
            $stmt -> bindValue(':attendance_status', $attendance_status, PDO::PARAM_STR);
            $stmt -> bindValue(':attendance_date', $attendance_date, PDO::PARAM_STR);
            $stmt -> bindValue(':attendance_duration', $attendance_duration, PDO::PARAM_INT);

            $stmt->execute();
            // echo "kalimera";


            // header("location:class-view.php?id={$class_id}");
        }

        // $class -> message = 1;
        session_start();
        $_SESSION['success_edit_message'] = "success";
        Url::redirect("/main/class/class-view.php?id={$class_id}");
    }
}



/**
 * Change class teacher []
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['edit_class_teacher']))) {
    $conn = require '../includes/db.php';

    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];

    // $student_course -> sc_id = $_POST['sc_id'];
    // $student_course -> sc_course_id = $_POST['course_id'];


    // dokimastiko gia kostos to opoio doylevei
    // $course = Course::getByCourseID($conn, $student_course -> sc_course_id );
    // $student_course -> sc_cost_student = $course -> course_cost_for_student;

    if ($class -> updateClassTeacher($conn, $class_id, $teacher_id)) {
        Url::redirect("/main/class/class-view.php?id={$class_id}");
    }
}
//
// if (isset($_POST['add_class'])){
//   // $class_id = $_POST['class_id'];
//
//   // $class_code = $_POST['class_code'];
//   $class_id = presentation["class_id"];
//   $student_id = presentation["student_id"];
//
//
//
//
//
//
//   if ($_SERVER["REQUEST_METHOD"] == "POST") {
//       $conn = require '../includes/db.php';
//       // $title = $_POST['title'];
//       // $content = $_POST['content'];
//       // $published_at = $_POST['published_at'];
//
//       $teacher_id -> student_lastname = $_POST['studentLastName'];
//       $student -> student_firstname = $_POST['studentFirstName'];
//       $student -> student_email = $_POST['studentEmail'];
//       $student -> student_mobile = $_POST['studentMobile'];
//       $student -> student_address = $_POST['studentAddress'];
//       $student -> student_zip_code = $_POST['studentZipCode'];
//       $student -> student_gender = $_POST['studentGender'];
//       $student -> student_status = $_POST['studentStatus'];
//
//       if ($student -> createStudent($conn)) {
//           Url::redirect("/main/student/student-profile.php?id={$student -> student_id}");
//       }
//   }






// foreach ($presentations as $presentation) {
//
//   $sql = "INSERT INTO presentation (presentation_class_id, presentation_student_id)
//         VALUES (:presentation_class_id, presentation_student_id)";
//
//
//         $stmt = $conn -> prepare($sql);
//
//         $stmt -> bindValue(':presentation_class_id', $class_id, PDO::PARAM_INT);
//         $stmt -> bindValue(':presentation_student_id', $student_id, PDO::PARAM_INT);
//         // $stmt -> bindValue(':student_firstname', $this -> student_firstname, PDO::PARAM_STR);
//         // $stmt -> bindValue(':student_email', $this -> student_email, PDO::PARAM_STR);
//         // $stmt -> bindValue(':student_mobile', $this -> student_mobile, PDO::PARAM_STR);
//         // $stmt -> bindValue(':student_address', $this -> student_address, PDO::PARAM_STR);
//         // $stmt -> bindValue(':student_zip_code', $this -> student_zip_code, PDO::PARAM_INT);
//         // $stmt -> bindValue(':student_gender', $this -> student_gender, PDO::PARAM_STR);
//         // $stmt -> bindValue(':student_status', $this -> student_status, PDO::PARAM_STR);
//         // if ($this -> published_at == '') {
//         //     $stmt -> bindValue(':published_at', null, PDO::PARAM_NULL);
//         // } else {
//         //     $stmt -> bindValue(':published_at', $this -> published_at, PDO::PARAM_STR);
//         // }
//         var_dump($stmt);
//         if ($stmt ->execute()) {
//             return true;
//           // echo "<script> alert('Data updated'); </script>";
//           // header("location:class-profile.php?id={$class_id}");
//
//         }
//
// }
