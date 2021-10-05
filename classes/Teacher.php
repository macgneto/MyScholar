<?php

class Teacher
{
    public $teacher_id;
    public $teacher_username;
    public $teacher_password;
    public $teacher_firstname;
    public $teacher_lastname;
    public $teacher_fathername;
    public $teacher_mothername;
    public $teacher_email;
    public $teacher_mobile_phone;
    public $teacher_fixed_phone;
    public $teacher_address;
    public $teacher_city;
    public $teacher_county;
    public $teacher_postal_code;
    public $teacher_comments;
    public $teacher_gender;
    public $teacher_status;
    public $teacher_birthday;
    public $teacher_photo;

    public $errors = [];


    public static function getAllTeachers($conn)
    {
        $sql = "SELECT *
                FROM teacher
                ORDER BY teacher_id;";

        $results = $conn -> query($sql);

        return $results -> fetchAll(PDO::FETCH_ASSOC);
    }



    public static function getByTeacherID($conn, $teacher_id, $columns = '*')
    {
        $sql = "SELECT $columns
                FROM teacher
                WHERE teacher_id = :teacher_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Teacher');

        if ($stmt ->execute()) {
            return $stmt -> fetch();
        }
    }


    public function updateTeacher($conn)
    {
        $sql = "UPDATE teacher
                SET teacher_username = :teacher_username,
                    teacher_password = :teacher_password,
                    teacher_firstname = :teacher_firstname,
                    teacher_lastname = :teacher_lastname,
                    teacher_fathername = :teacher_fathername,
                    teacher_mothername = :teacher_mothername,
                    teacher_email = :teacher_email,
                    teacher_mobile_phone = :teacher_mobile_phone,
                    teacher_fixed_phone = :teacher_fixed_phone,
                    teacher_address = :teacher_address,
                    teacher_city = :teacher_city,
                    teacher_county = :teacher_county,
                    teacher_postal_code = :teacher_postal_code,
                    teacher_gender = :teacher_gender,
                    teacher_birthday = :teacher_birthday,
                    teacher_status = :teacher_status,
                    teacher_comments = :teacher_comments,
                    teacher_photo = :teacher_photo
                WHERE teacher_id = :teacher_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':teacher_id', $this -> teacher_id, PDO::PARAM_INT);
        $stmt -> bindValue(':teacher_username', $this -> teacher_username, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_password', $this -> teacher_password, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_lastname', $this -> teacher_lastname, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_firstname', $this -> teacher_firstname, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_fathername', $this -> teacher_fathername, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_mothername', $this -> teacher_mothername, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_email', $this -> teacher_email, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_mobile_phone', $this -> teacher_mobile_phone, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_fixed_phone', $this -> teacher_fixed_phone, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_address', $this -> teacher_address, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_city', $this -> teacher_city, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_county', $this -> teacher_county, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_postal_code', $this -> teacher_postal_code, PDO::PARAM_INT);
        $stmt -> bindValue(':teacher_gender', $this -> teacher_gender, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_birthday', $this -> teacher_birthday, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_status', $this -> teacher_status, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_comments', $this -> teacher_comments, PDO::PARAM_STR);
        $stmt -> bindValue(':teacher_photo', $this -> teacher_photo, PDO::PARAM_STR);

        return $stmt -> execute();
    }



    protected function validateTeacher()
    {
        if ($this -> title == '') {
            $this -> errors[] = 'Title is required';
        }
        if ($this -> content == '') {
            $this -> errors[] = 'Content is required';
        }


        return empty($this -> errors);
    }



    public function deleteTeacher($conn)
    {
        $sql = "DELETE FROM article
                WHERE id = :id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':id', $this ->id, PDO::PARAM_INT);

        return $stmt -> execute();
    }



    public function createTeacher($conn)
    {
        {
            $sql = "INSERT INTO teacher (teacher_username,teacher_password,teacher_lastname, teacher_firstname, teacher_email, teacher_fathername, teacher_mothername, teacher_mobile_phone, teacher_fixed_phone, teacher_address, teacher_city, teacher_county, teacher_postal_code, teacher_gender, teacher_status, teacher_birthday, teacher_comments, teacher_photo)
                    VALUES (:teacher_username, :teacher_password, :teacher_lastname, :teacher_firstname, :teacher_email, :teacher_fathername, :teacher_mothername, :teacher_mobile_phone, :teacher_fixed_phone, :teacher_address, :teacher_city, :teacher_county, :teacher_postal_code, :teacher_gender, :teacher_status, :teacher_birthday, :teacher_comments, :teacher_photo)";

            $stmt = $conn -> prepare($sql);

            $stmt -> bindValue(':teacher_username', $this -> teacher_username, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_password', $this -> teacher_password, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_lastname', $this -> teacher_lastname, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_firstname', $this -> teacher_firstname, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_fathername', $this -> teacher_fathername, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_mothername', $this -> teacher_mothername, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_email', $this -> teacher_email, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_mobile_phone', $this -> teacher_mobile_phone, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_fixed_phone', $this -> teacher_fixed_phone, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_address', $this -> teacher_address, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_city', $this -> teacher_city, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_county', $this -> teacher_county, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_postal_code', $this -> teacher_postal_code, PDO::PARAM_INT);
            $stmt -> bindValue(':teacher_gender', $this -> teacher_gender, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_birthday', $this -> teacher_birthday, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_status', $this -> teacher_status, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_comments', $this -> teacher_comments, PDO::PARAM_STR);
            $stmt -> bindValue(':teacher_photo', $this -> teacher_photo, PDO::PARAM_STR);

            if ($stmt -> execute()) {
                $this -> teacher_id = $conn -> lastInsertId();
                return true;
            }

        }
    }



    public function getTeacherCourses($conn)
    {
        $sql = "SELECT course.*
                FROM course
                JOIN teacher_course
                ON course.course_id = teacher_course.tc_course_id
                WHERE teacher_course.tc_teacher_id = :teacher_id";


        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':teacher_id', $this ->teacher_id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }



    public function setTeacherCourses($conn, $ids)
    {
        if ($ids) {
            $sql = "INSERT IGNORE INTO teacher_course (tc_teacher_id, tc_course_id)
                  VALUES ";

            $values = [];

            foreach ($ids as $ide) {
                $values[] = "({$this -> teacher_id}, ?)";
            }

            $sql .= implode(", ", $values);

            $stmt = $conn -> prepare($sql);

            foreach ($ids as $i => $ide) {
                $stmt -> bindValue($i + 1, $ide, PDO::PARAM_INT);
            }
            $stmt -> execute();
        }

        $sql = "DELETE FROM teacher_course
                WHERE tc_teacher_id = {$this -> teacher_id}";

        if ($ids) {
            $placeholders = array_fill(0, count($ids), '?');

            $sql .= " AND tc_course_id NOT IN (" . implode(", ", $placeholders) .")";
        }


        $stmt = $conn -> prepare($sql);

        foreach ($ids as $i => $ide) {
            $stmt -> bindValue($i + 1, $ide, PDO::PARAM_INT);
        }

        $stmt -> execute();
    }
}
