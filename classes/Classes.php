<?php

class Classes
{
    public $class_id;
    public $class_code;
    public $student_id;
    public $student_firstname;
    public $student_lastname;
    public $student_email;
    public $student_mobile;
    public $student_address;
    public $student_zip_code;
    public $student_gender;
    public $student_status;
    public $class;


    public $teacher_lastname;
    public $row_count;
    public $errors = [];
    public $teacher_id;
    public $sql_id;


    public $class_name;
    public $class_description;
    public $class_teacher_id;
    public $class_course_id;

    public $row_class;
    public $message = "";



    public static function countStudentsInClassByID($conn, $class)
    {
        $sql = "SELECT COUNT(*) AS num
                FROM student_course
                WHERE student_course.sc_class_id = :class";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':class', $class, PDO::PARAM_INT);
        $stmt -> execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //The $row array will contain "num". Print it out.
        return $row['num'] ;
    }



    public static function getStudentsRegisteredToClass($conn, $class_id)
    {
        $sql = "SELECT *
                FROM class, student_course, student
                WHERE class.class_id = student_course.sc_class_id
                AND student_course.sc_student_id = student.student_id
                AND class.class_id = :class_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public static function getByID($conn, $sql_table, $column_name, $sql_id, $columns = '*')
    {
        $sql = "SELECT $columns
                FROM $sql_table
                WHERE $column_name = :sql_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':sql_id', $sql_id, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Classes');

        if ($stmt ->execute()) {
            return $stmt -> fetch();
        }
    }

    // Get list of all classrooms
    public static function getAllClasses($conn)
    {
        $sql = "SELECT *
                FROM class
                LEFT JOIN teacher
                ON class.class_teacher_id = teacher.teacher_id
                LEFT JOIN course
                ON class.class_course_id = course.course_id
                ORDER BY class_id";

        $results = $conn -> query($sql);

        return $results -> fetchAll(PDO::FETCH_ASSOC);
    }

    // Get List of Classrooms for specific teacher id (when teacher is logged in)
    public static function getAllClassesForTeacherOnly($conn, $teacher_id)
    {
        $sql = "SELECT *
                FROM class
                LEFT JOIN teacher
                ON class.class_teacher_id = teacher.teacher_id
                LEFT JOIN course
                ON class.class_course_id = course.course_id
                WHERE class.class_teacher_id = :teacher_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    // Get List of Classrooms for specific student id (when student is logged in)
    public static function getAllClassesForStudentOnly($conn, $student_id)
    {
        $sql = "SELECT *
                FROM student, class, student_course, course, teacher
               WHERE student_course.sc_class_id = class.class_id
               AND student_course.sc_student_id = student.student_id
               AND course.course_id = student_course.sc_course_id
               AND class.class_teacher_id = teacher.teacher_id
               AND student.student_id = :student_id
               GROUP BY class.class_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }



    public function createClass($conn)
    {
        $sql = "INSERT INTO class (class_code, class_name, class_description, class_teacher_id, class_course_id)
                    VALUES (:class_code, :class_name, :class_description, :class_teacher_id, :class_course_id)";


        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':class_code', $this ->class_code, PDO::PARAM_STR);
        $stmt -> bindValue(':class_name', $this ->class_name, PDO::PARAM_STR);
        $stmt -> bindValue(':class_description', $this ->class_description, PDO::PARAM_STR);
        $stmt -> bindValue(':class_teacher_id', $this ->class_teacher_id, PDO::PARAM_INT);
        $stmt -> bindValue(':class_course_id', $this ->class_course_id, PDO::PARAM_INT);

        if ($stmt -> execute()) {
            return true;
        }
    }

    public function updateClassTeacher($conn, $class_id, $teacher_id)
    {
        $sql = "UPDATE class
                SET class_teacher_id = :teacher_id
                WHERE class_id = :class_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt -> bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);

        return $stmt -> execute();
    }



    public function updateClass($conn)
    {
        $sql = "UPDATE class
                SET class_code = :class_code,
                    class_name = :class_name,
                    class_description = :class_description

              WHERE class_id = :class_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':class_id', $this -> class_id, PDO::PARAM_INT);
        $stmt -> bindValue(':class_code', $this -> class_code, PDO::PARAM_STR);
        $stmt -> bindValue(':class_name', $this -> class_name, PDO::PARAM_STR);
        $stmt -> bindValue(':class_description', $this -> class_description, PDO::PARAM_STR);

        return $stmt -> execute();
    }



    // Delete classroom
//
    public function deleteClass($conn)
    {
        $sql = "DELETE FROM class
                WHERE class_id = :class_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':class_id', $this -> class_id, PDO::PARAM_INT);


        return $stmt -> execute();
    }




    public static function getByClassID($conn, $class_id, $columns = '*')
    {
        $sql = "SELECT $columns
                FROM class
                WHERE class_id = :class_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Classes');

        if ($stmt ->execute()) {
            return $stmt -> fetch();
        }
    }


    public static function getTeacherByCourse($conn, $course_id)
    {
        $sql = "SELECT *
                FROM teacher, teacher_course
                WHERE teacher_course.tc_course_id = :course_id
                AND teacher_course.tc_teacher_id = teacher.teacher_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':course_id', $course_id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt ->execute()) {
            return $stmt -> fetchAll();
        }
    }


    public function updateClassEnroll($conn)
    {
        $sql = "UPDATE class
              SET class_code = :class_code
              WHERE class_id = :class_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':class_code', $this -> class_code, PDO::PARAM_STR);
        $stmt -> bindValue(':class_id', $this -> class_id, PDO::PARAM_INT);

        return $stmt -> execute();
    }


    public static function getTeacherClass($conn, $teacher_id)
    {
        $sql = "SELECT *
                FROM  teacher
                WHERE teacher_id = :teacher_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Classes');

        $stmt -> execute();

        return $stmt -> fetch();
    }


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




    public static function getAvailableStudentsForClass($conn, $class_id)
    {
        $sql = "SELECT *
                FROM student, class, student_course
                WHERE student.student_id = student_course.sc_student_id
                AND class.class_course_id = student_course.sc_course_id
                AND class.class_id = :class_id";


        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':class_id', $class_id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public static function getAllStudentsActiveRows($conn)
    {
        $sql = "SELECT *
                FROM student
                WHERE student_status='Ενεργός'";

        $stmt = $conn -> prepare($sql);

        $stmt -> execute();

        return $stmt -> rowCount();
    }


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
     * Get the article record based on the ID
     *
     * @param object $conn Connection to the database
     * @param integer $id the article ID
     *
     * @return mixed An associative array containing the article with that ID, or null if not found
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

    public function updateStudent($conn)
    {
        $sql = "UPDATE student
                SET student_firstname = :student_firstname,
                    student_lastname = :student_lastname,
                    student_email = :student_email,
                    student_mobile = :student_mobile,
                    student_address = :student_address,
                    student_zip_code = :student_zip_code,
                    student_gender = :student_gender,
                    student_status = :student_status
                WHERE student_id = :student_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':student_id', $this -> student_id, PDO::PARAM_INT);
        $stmt -> bindValue(':student_lastname', $this -> student_lastname, PDO::PARAM_STR);
        $stmt -> bindValue(':student_firstname', $this -> student_firstname, PDO::PARAM_STR);
        $stmt -> bindValue(':student_email', $this -> student_email, PDO::PARAM_STR);
        $stmt -> bindValue(':student_mobile', $this -> student_mobile, PDO::PARAM_STR);
        $stmt -> bindValue(':student_address', $this -> student_address, PDO::PARAM_STR);
        $stmt -> bindValue(':student_zip_code', $this -> student_zip_code, PDO::PARAM_INT);
        $stmt -> bindValue(':student_gender', $this -> student_gender, PDO::PARAM_STR);
        $stmt -> bindValue(':student_status', $this -> student_status, PDO::PARAM_STR);


        return $stmt -> execute();
    }


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

        $stmt -> execute();
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


    public function deleteStudent($conn)
    {
        $sql = "DELETE FROM student
                WHERE id = :id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':id', $this ->id, PDO::PARAM_INT);


        return $stmt -> execute();
    }



    public function createStudent($conn)
    {
        {
            $sql = "INSERT INTO student (student_lastname, student_firstname, student_email, student_mobile, student_address, student_zip_code, student_gender, student_status)
                    VALUES (:student_lastname, :student_firstname, :student_email, :student_mobile, :student_address, :student_zip_code, :student_gender, :student_status)";

            $stmt = $conn -> prepare($sql);


            $stmt -> bindValue(':student_lastname', $this -> student_lastname, PDO::PARAM_STR);
            $stmt -> bindValue(':student_firstname', $this -> student_firstname, PDO::PARAM_STR);
            $stmt -> bindValue(':student_email', $this -> student_email, PDO::PARAM_STR);
            $stmt -> bindValue(':student_mobile', $this -> student_mobile, PDO::PARAM_STR);
            $stmt -> bindValue(':student_address', $this -> student_address, PDO::PARAM_STR);
            $stmt -> bindValue(':student_zip_code', $this -> student_zip_code, PDO::PARAM_INT);
            $stmt -> bindValue(':student_gender', $this -> student_gender, PDO::PARAM_STR);
            $stmt -> bindValue(':student_status', $this -> student_status, PDO::PARAM_STR);


            if ($stmt -> execute()) {
                $this -> student_id = $conn -> lastInsertId();
                return true;
            }

        }
    }
}
