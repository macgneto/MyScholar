<?php


class User
{
    public $student_id;

    public $student_username;

    public $student_email;

    public $student_password;

    public $student_role;

    // public $student_photo;

    public static function authenticate($conn, $student_email, $student_password)
    {
        $sql = "SELECT *
                FROM student
                WHERE student_email = :student_email";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student_email', $student_email, PDO::PARAM_STR);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt -> execute();

        if ($student_user = $stmt -> fetch()) {
            // if ($user -> password == $password) {
            //     return true;
            // }
            // session_start();
            $_SESSION['user_username'] = $student_user -> student_username;
            $_SESSION['user_role'] = $student_user -> student_role;
            $_SESSION['user_id'] = $student_user -> student_id;
            return $student_user -> student_password == $student_password;
        }
    }


    // Student Authenticate
    public static function authenticateStudent($conn, $student_email, $student_password)
    {
        $sql = "SELECT *
                FROM student
                WHERE student_email = :student_email";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student_email', $student_email, PDO::PARAM_STR);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt -> execute();

        if ($student_user = $stmt -> fetch()) {
            // if ($user -> password == $password) {
            //     return true;
            // }
            // session_start();
            $_SESSION['user_username'] = $student_user -> student_username;
            $_SESSION['user_role'] = $student_user -> student_role;
            $_SESSION['user_id'] = $student_user -> student_id;
            $_SESSION['user_photo'] = $student_user -> student_photo;
            return $student_user -> student_password == $student_password;
        }
    }


    //  Teacher Authenticate
    public static function authenticateTeacher($conn, $teacher_email, $teacher_password)
    {
        $sql = "SELECT *
                FROM teacher
                WHERE teacher_email = :teacher_email";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':teacher_email', $teacher_email, PDO::PARAM_STR);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt -> execute();

        if ($teacher_user = $stmt -> fetch()) {
            // if ($user -> password == $password) {
            //     return true;
            // }
            // session_start();
            $_SESSION['user_username'] = $teacher_user -> teacher_username;
            $_SESSION['user_role'] = $teacher_user -> teacher_role;
            $_SESSION['user_id'] = $teacher_user -> teacher_id;
            $_SESSION['user_photo'] = $teacher_user -> teacher_photo;

            return $teacher_user -> teacher_password == $teacher_password;
        }
    }

    //  Secretary Authenticate
    public static function authenticateSecretary($conn, $secretary_email, $secretary_password)
    {
        $sql = "SELECT *
                FROM secretary
                WHERE secretary_email = :secretary_email";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':secretary_email', $secretary_email, PDO::PARAM_STR);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt -> execute();

        if ($secretary_user = $stmt -> fetch()) {
            // if ($user -> password == $password) {
            //     return true;
            // }
            // session_start();
            $_SESSION['user_username'] = $secretary_user -> secretary_username;
            $_SESSION['user_role'] = $secretary_user -> secretary_role;
            $_SESSION['user_id'] = $secretary_user -> secretary_id;
            return $secretary_user -> secretary_password == $secretary_password;
        }
    }


    //  Teacher Authenticate
    public static function authenticateAdmin($conn, $admin_email, $admin_password)
    {
        $sql = "SELECT *
                FROM admin
                WHERE admin_email = :admin_email";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':admin_email', $admin_email, PDO::PARAM_STR);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt -> execute();

        if ($admin_user = $stmt -> fetch()) {
            // if ($user -> password == $password) {
            //     return true;
            // }
            // session_start();
            $_SESSION['user_username'] = $admin_user -> admin_username;
            $_SESSION['user_role'] = $admin_user -> admin_role;
            $_SESSION['user_id'] = $admin_user -> admin_id;
            return $admin_user -> admin_password == $admin_password;
        }
    }
}
