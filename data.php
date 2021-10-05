<?php

require 'includes/init.php';

$conn = require 'includes/db.php';

if (isset($_POST['aid'])) {

    // $stmt = $conn->prepare("SELECT * FROM teacher_course WHERE tc_course_id = " . $_POST['aid']);
    $stmt = $conn->prepare("SELECT * FROM teacher_course,teacher WHERE teacher_course.tc_teacher_id = teacher.teacher_id AND teacher_course.tc_course_id = " . $_POST['aid']);
    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($teachers);
}


// if(isset($_POST['edit'])) {
//
//     // $stmt = $conn->prepare("SELECT * FROM teacher_course WHERE tc_course_id = " . $_POST['aid']);
//     $stmt = $conn->prepare("SELECT * FROM teacher_course,teacher WHERE teacher_course.tc_teacher_id = teacher.teacher_id AND teacher_course.tc_course_id = " . $_POST['edit']);
//     $stmt->execute();
//     $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     // echo json_encode($teachers);
//     $json = [];
//        while($row = $teachers){
//             $json[$row['tc_teacher_id']] = $row['tc_teacher_lastname'];
//
//
//             echo json_encode($json);
//         }
// }


if (isset($_POST['edit'])) {

    // $stmt = $conn->prepare("SELECT * FROM teacher_course WHERE tc_course_id = " . $_POST['aid']);
    $stmt = $conn->prepare("SELECT * FROM teacher_course,teacher WHERE teacher_course.tc_teacher_id = teacher.teacher_id AND teacher_course.tc_course_id = " . $_POST['edit']);
    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($teachers);
}

function loadCourses($conn)
{
    $stmt = $conn->prepare("SELECT * FROM course");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $courses;
}
