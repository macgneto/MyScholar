<?php

require '../includes/init.php';
// Auth::requireLogin();
// $conn = require '../includes/db.php';








// if (isset($_POST['class_id']) ) {
    $conn = require '../includes/db.php';





        $sql = "SELECT *
            FROM class, teacher, course
            WHERE class_id = :class_id";

            $stmt = $conn -> prepare($sql); // !!!!!!!!!!!!!!!!   01 - PREPARE !!!!!!!!!!


            $stmt -> bindValue(':class_id', $_POST['class_id'], PDO::PARAM_INT);





        $stmt->execute();
        $stmt -> fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($stmt);
// }
