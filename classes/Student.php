<?php

class Student
{
    public $student_id;
    public $student_username;
    public $student_password;
    public $student_firstname;
    public $student_lastname;
    public $student_fathername;
    public $student_mothername;
    public $student_email;
    public $student_mobile_phone;
    public $student_fixed_phone;
    public $student_address;
    public $student_city;
    public $student_county;
    public $student_postal_code;
    public $student_comments;
    public $student_gender;
    public $student_status;
    public $student_birthday;
    public $student_photo;
    public $row_count;
    public $errors = [];
    public $course_id;


    /**
     * [getStudentWithCourse description]
     * @param  integer $conn       [description]
     * @param  value $student_id [description]
     * @return [type]             [description]
     */
    public static function getStudentWithCourse($conn, $student_id)
    {
        $sql = "SELECT *
                FROM student
                LEFT JOIN student_course
                ON student.student_id = student_course.sc_student_id
                LEFT JOIN course
                ON student_course.sc_course_id = course.course_id
                WHERE student.student_id = :student_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':student_id', $student_id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public function getStudentCourses($conn)
    {
        $sql = "SELECT course.*
                FROM course
                JOIN student_course
                ON course.course_id = student_course.sc_course_id
                WHERE student_course.sc_student_id = :student_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student_id', $this ->student_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    /**
     * [getAllStudents description]
     * @param  [type] $conn [description]
     * @return [type]       [description]
     */
    public static function getAllStudents($conn)
    {
        $sql = "SELECT *
            FROM student
            ORDER BY student_id";

        $results = $conn -> query($sql);
        return $results -> fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    }


    /**
     * [getAllStudents for teacher description]
     * @param  [type] $conn [description]
     * @return [type]       [description]
     */
    public static function getAllStudentsForTeacher($conn, $teacher_id)
    {
        $sql = "SELECT DISTINCT student.*
                FROM student, teacher, class, teacher_course, student_course
                WHERE teacher.teacher_id = class.class_teacher_id
                AND class.class_id = student_course.sc_class_id
                AND student_course.sc_student_id = student.student_id
                AND teacher.teacher_id = :teacher_id";


                $stmt = $conn -> prepare($sql);
                $stmt -> bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
                $stmt -> execute();
                return $stmt -> fetchALL(PDO::FETCH_ASSOC);

        //
        // $results = $conn -> query($sql);
        // return $results -> fetchAll(PDO::FETCH_ASSOC);
        // echo json_encode($results);
    }

    /**
     *  @param object $conn Connection to the database
     *  @param value 'Active' for active students
     *
     *  @return rowCount for counting all the rows that have 'Active' as value
     */
    public static function getAllStudentsActiveRows($conn)
    {
        $sql = "SELECT *
                FROM student
                WHERE student_status='Ενεργός'";

        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        return $stmt -> rowCount();
    }


    /**
     *  @param object $conn Connection to the database
     *  @param value 'Inactive' for active students
     *
     *  @return rowCount for counting all the rows that have 'Inactive' as value
     */
    public static function getAllStudentsInactiveRows($conn)
    {
        $sql = "SELECT *
                FROM student
                WHERE student_status='Ανενεργός'";

        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        return $stmt -> rowCount();
    }


    /**
     * Get the student record based on the ID
     *
     * @param object $conn Connection to the database
     * @param integer $student_id for the student ID
     *
     * @return mixed An associative array containing the student with that ID, or null if not found
     */

    public static function getByStudentID($conn, $student_id, $columns = '*')
    {
        $sql = "SELECT $columns
                FROM student
                WHERE student_id = :student_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Student');
        if ($stmt ->execute()) {
            return $stmt -> fetch();
        }
    }


    /**
     * Update the student record based on the ID
     *
     * @param object $conn Connection to the database
     * @param integer $student_id for the student ID
     *
     * @return execute Update the record of the student with that ID
     */
    public function updateStudent($conn)
    {
        // if ($this -> validate()) {
        $sql = "UPDATE student
                SET student_username = :student_username,
                    student_password = :student_password,
                    student_firstname = :student_firstname,
                    student_lastname = :student_lastname,
                    student_fathername = :student_fathername,
                    student_mothername = :student_mothername,
                    student_email = :student_email,
                    student_mobile_phone = :student_mobile_phone,
                    student_fixed_phone = :student_fixed_phone,
                    student_address = :student_address,
                    student_city = :student_city,
                    student_county = :student_county,
                    student_postal_code = :student_postal_code,
                    student_gender = :student_gender,
                    student_birthday = :student_birthday,
                    student_status = :student_status,
                    student_comments = :student_comments,
                    student_photo = :student_photo
                WHERE student_id = :student_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':student_id', $this -> student_id, PDO::PARAM_INT);
        $stmt -> bindValue(':student_username', $this -> student_username, PDO::PARAM_STR);
        $stmt -> bindValue(':student_password', $this -> student_password, PDO::PARAM_STR);
        $stmt -> bindValue(':student_lastname', $this -> student_lastname, PDO::PARAM_STR);
        $stmt -> bindValue(':student_firstname', $this -> student_firstname, PDO::PARAM_STR);
        $stmt -> bindValue(':student_fathername', $this -> student_fathername, PDO::PARAM_STR);
        $stmt -> bindValue(':student_mothername', $this -> student_mothername, PDO::PARAM_STR);
        $stmt -> bindValue(':student_email', $this -> student_email, PDO::PARAM_STR);
        $stmt -> bindValue(':student_mobile_phone', $this -> student_mobile_phone, PDO::PARAM_STR);
        $stmt -> bindValue(':student_fixed_phone', $this -> student_fixed_phone, PDO::PARAM_STR);
        $stmt -> bindValue(':student_address', $this -> student_address, PDO::PARAM_STR);
        $stmt -> bindValue(':student_city', $this -> student_city, PDO::PARAM_STR);
        $stmt -> bindValue(':student_county', $this -> student_county, PDO::PARAM_STR);
        $stmt -> bindValue(':student_postal_code', $this -> student_postal_code, PDO::PARAM_INT);
        $stmt -> bindValue(':student_gender', $this -> student_gender, PDO::PARAM_STR);
        $stmt -> bindValue(':student_birthday', $this -> student_birthday, PDO::PARAM_STR);
        $stmt -> bindValue(':student_status', $this -> student_status, PDO::PARAM_STR);
        $stmt -> bindValue(':student_comments', $this -> student_comments, PDO::PARAM_STR);
        $stmt -> bindValue(':student_photo', $this -> student_photo, PDO::PARAM_STR);

        return $stmt -> execute();
    }


    /**
     * Validate the article properties
     *
     * @param string $title Title, required
     * @param string $content Content, required
     * @param string $published_at Published date and time, yyyy-mm-dd hh:mm:ss if not blank
     *
     * @return array An array of validation error messages
     */


    public function setStudentCourses($conn, $ids)
    {
        if ($ids) {
            $sql = "INSERT IGNORE INTO student_course (sc_student_id, sc_course_id)
                  VALUES ";

            $values = [];

            foreach ($ids as $ide) {
                $values[] = "({$this -> student_id}, ?)";
            }

            $sql .= implode(", ", $values);

            $stmt = $conn -> prepare($sql);

            foreach ($ids as $i => $ide) {
                $stmt -> bindValue($i + 1, $ide, PDO::PARAM_INT);
            }
            $stmt -> execute();
        }

        $sql = "DELETE FROM student_course
                WHERE sc_student_id = {$this -> student_id}";

        if ($ids) {
            $placeholders = array_fill(0, count($ids), '?');

            $sql .= " AND sc_course_id NOT IN (" . implode(", ", $placeholders) .")";
        }


        $stmt = $conn -> prepare($sql);

        foreach ($ids as $i => $ide) {
            $stmt -> bindValue($i + 1, $ide, PDO::PARAM_INT);
        }

        if ($stmt -> execute()) {
            return true;
        }
    }


    public function deleteAtendanceIfRemoveSC($conn, $student_id, $class_id)
    {
        $sql = "DELETE FROM attendance
                WHERE attendance.attendance_class_id = :class_id
                AND attendance.attendance_student_id = :student_id";
        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt -> bindValue(':class_id', $class_id, PDO::PARAM_INT);

        return $stmt -> execute();
    }



    protected function validateStudent()
    {
        if ($this -> title == '') {
            $this -> errors[] = 'Title is required';
        }
        if ($this -> content == '') {
            $this -> errors[] = 'Content is required';
        }


        return empty($this -> errors);
    }




        // Delete student

    // public function deleteStudent($conn)
    // {
    //     $sql = "DELETE FROM student
    //     WHERE student_id = :student_id";
    //
    //     $stmt = $conn -> prepare($sql);
    //
    //     $stmt -> bindValue(':student_id', $this ->student_id, PDO::PARAM_INT);
    //
    //
    //     return $stmt -> execute();
    // }



        // Delete classroom
    //
        public function deleteStudent($conn)
        {
            $sql = "DELETE FROM student
                    WHERE student_id = :student_id";

            $stmt = $conn -> prepare($sql);

            $stmt -> bindValue(':student_id', $this -> student_id, PDO::PARAM_INT);


            return $stmt -> execute();
        }




    public function createStudent($conn)
    {
        {
            $sql = "INSERT INTO student (student_username, student_password, student_lastname, student_firstname, student_fathername, student_mothername, student_email, student_mobile_phone, student_fixed_phone, student_address, student_city, student_county, student_postal_code, student_gender, student_birthday, student_status, student_comments, student_photo)
                    VALUES (:student_username, :student_password, :student_lastname, :student_firstname, :student_fathername, :student_mothername, :student_email, :student_mobile_phone, :student_fixed_phone, :student_address, :student_city, :student_county, :student_postal_code, :student_gender, :student_birthday, :student_status, :student_comments, :student_photo)";

            $stmt = $conn -> prepare($sql);
            $stmt -> bindValue(':student_username', $this -> student_username, PDO::PARAM_STR);
            $stmt -> bindValue(':student_password', $this -> student_password, PDO::PARAM_STR);
            $stmt -> bindValue(':student_lastname', $this -> student_lastname, PDO::PARAM_STR);
            $stmt -> bindValue(':student_firstname', $this -> student_firstname, PDO::PARAM_STR);
            $stmt -> bindValue(':student_fathername', $this -> student_fathername, PDO::PARAM_STR);
            $stmt -> bindValue(':student_mothername', $this -> student_mothername, PDO::PARAM_STR);
            $stmt -> bindValue(':student_email', $this -> student_email, PDO::PARAM_STR);
            $stmt -> bindValue(':student_mobile_phone', $this -> student_mobile_phone, PDO::PARAM_STR);
            $stmt -> bindValue(':student_fixed_phone', $this -> student_fixed_phone, PDO::PARAM_STR);
            $stmt -> bindValue(':student_address', $this -> student_address, PDO::PARAM_STR);
            $stmt -> bindValue(':student_city', $this -> student_city, PDO::PARAM_STR);
            $stmt -> bindValue(':student_county', $this -> student_county, PDO::PARAM_STR);
            $stmt -> bindValue(':student_postal_code', $this -> student_postal_code, PDO::PARAM_INT);
            $stmt -> bindValue(':student_gender', $this -> student_gender, PDO::PARAM_STR);
            $stmt -> bindValue(':student_birthday', $this -> student_birthday, PDO::PARAM_STR);
            $stmt -> bindValue(':student_status', $this -> student_status, PDO::PARAM_STR);
            $stmt -> bindValue(':student_comments', $this -> student_comments, PDO::PARAM_STR);
            $stmt -> bindValue(':student_photo', $this -> student_photo, PDO::PARAM_STR);

            if ($stmt -> execute()) {
                $this -> student_id = $conn -> lastInsertId();
                return true;
            }

        }
    }



    /**
     * Fetch drop down data based on selection
     * @param  object   $conn           connection to database
     * @param  Variable $course_id      The id of the course
     * @return FETCH_ASSOC              [description]
     */
    public static function getStudentCourseClassDROPDOWN($conn, $course_id)
    {
        $sql = "SELECT *
                FROM class
                LEFT JOIN student_course
                ON class.class_course_id = student_course.sc_course_id
                WHERE student_course.sc_course_id = :course_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':course_id', $course_id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }
}
