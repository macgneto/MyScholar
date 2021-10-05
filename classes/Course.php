<?php

class Course
{
    public $course_id;
    public $course_code;
    public $course_title;
    public $course_description;
    public $course_year;
    public $course_cost_hour_student;
    public $course_cost_month_student;
    public $course_cost_hour_teacher;
    public $student_id;
    public $errors = [];


    public static function getAllCourses($conn)
    {
        $sql = "SELECT *
            FROM course
            -- WHERE id = 0
            ORDER BY course_title;";

        $results = $conn -> query($sql);

        return $results -> fetchAll(PDO::FETCH_ASSOC);
    }



    public static function getAllCoursesAvailable($conn, $student_id)
    {
        $sql = "SELECT *
                FROM course
                WHERE course.course_id NOT IN
                    (SELECT student_course.sc_course_id
                        FROM student_course
                        WHERE student_course.sc_student_id = :student_id)";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Get the course record based on the ID
     *
     * @param object $conn Connection to the database
     * @param integer $id the article ID
     *
     * @return mixed An associative array containing the article with that ID, or null if not found
     */
    public static function getByCourseID($conn, $course_id, $columns = '*')
    {
        $sql = "SELECT $columns
                FROM course
                WHERE course_id = :course_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':course_id', $course_id, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Course');

        if ($stmt ->execute()) {
            return $stmt -> fetch();
        }
    }

    public function updateCourse($conn)
    {
        $sql = "UPDATE course
                SET course_code = :course_code,
                    course_title = :course_title,
                    course_description = :course_description,
                    course_year = :course_year,
                    course_cost_hour_student = :course_cost_hour_student,
                    course_cost_hour_teacher = :course_cost_hour_teacher
              WHERE course_id = :course_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':course_id', $this ->course_id, PDO::PARAM_INT);
        $stmt -> bindValue(':course_code', $this ->course_code, PDO::PARAM_STR);
        $stmt -> bindValue(':course_title', $this ->course_title, PDO::PARAM_STR);
        $stmt -> bindValue(':course_description', $this ->course_description, PDO::PARAM_STR);
        $stmt -> bindValue(':course_year', $this ->course_year, PDO::PARAM_STR);
        $stmt -> bindValue(':course_cost_hour_student', $this ->course_cost_hour_student, PDO::PARAM_INT);
        $stmt -> bindValue(':course_cost_hour_teacher', $this ->course_cost_hour_teacher, PDO::PARAM_INT);

        return $stmt -> execute();
    }


    protected function validateCourse()
    {
        if ($this -> course_code == '') {
            $this -> errors[] = 'Πρέπει να συμπληρώσετε κωδικό μαθήματος';
        }
        if ($this -> course_title == '') {
            $this -> errors[] = 'Πρέπει να συμπληρώσετε Όνομα Μαθήματος';
        }
        if ($this -> course_description == '') {
            $this -> errors[] = 'Πρέπει να συμπληρώσετε μια σύντομή περιγραφή μαθήματος';
        }


        return empty($this -> errors);
    }








    public function getCourseStudents($conn)
    {
        $sql = "SELECT student.*
                FROM student
                JOIN student_course
                ON student.student_id = student_course.sc_student_id
                WHERE student_course.sc_course_id = :course_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':course_id', $this ->course_id, PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public function getCourseTeachers($conn)
    {
        $sql = "SELECT *
                FROM teacher
                JOIN teacher_course
                ON teacher.teacher_id = teacher_course.tc_teacher_id
                WHERE teacher_course.tc_course_id = :course_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':course_id', $this ->course_id, PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public static function getAllStudentsEnrolledToCourse($conn)
    {
        $sql = "SELECT *
                FROM student_course
                WHERE sc_course_id = :course_id
                ORDER BY sc_student_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':course_id', $course_id, PDO::PARAM_INT);
        $results = $conn -> query($sql);

        return $results -> fetchAll(PDO::FETCH_ASSOC);
    }



    public function createCourse($conn)
    {
        if ($this -> validateCourse()) {
            $sql = "INSERT INTO course (course_code, course_title, course_description, course_year, course_cost_hour_student, course_cost_hour_teacher)
                    VALUES (:course_code, :course_title, :course_description, :course_year, :course_cost_hour_student, :course_cost_hour_teacher)";

            $stmt = $conn -> prepare($sql);

            $stmt -> bindValue(':course_code', $this ->course_code, PDO::PARAM_STR);
            $stmt -> bindValue(':course_title', $this ->course_title, PDO::PARAM_STR);
            $stmt -> bindValue(':course_description', $this ->course_description, PDO::PARAM_STR);
            $stmt -> bindValue(':course_year', $this ->course_year, PDO::PARAM_STR);
            $stmt -> bindValue(':course_cost_hour_student', $this ->course_cost_hour_student, PDO::PARAM_INT);
            $stmt -> bindValue(':course_cost_hour_teacher', $this ->course_cost_hour_teacher, PDO::PARAM_INT);

            if ($stmt -> execute()) {
                $this -> course_id = $conn -> lastInsertId();
                return true;
            }
        } else {
            return false;
        }
    }
}
