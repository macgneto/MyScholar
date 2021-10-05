<?php


class Attendance
{
    public $attendance_id;
    public $attendance_class_id;
    public $attendance_student_id;
    public $attendance_date;
    public $attendance_duration;
    public $attendance_status;
    public $class_id;
    public $message ='0';
    public $student_id;


    public function notificationAttendance($conn, $student_id)
        {
            // select all query with user inputed username and password
            $sql = "SELECT *
                      FROM student
                      LEFT JOIN student_course
                      ON student_course.sc_student_id = student.student_id
                      LEFT JOIN course
                      ON  student_course.sc_course_id = course.course_id
                      LEFT JOIN class
                      ON  student_course.sc_class_id = class.class_id
                      LEFT JOIN attendance
                      ON attendance.attendance_class_id = student_course.sc_class_id
                      LEFT JOIN teacher
                      ON teacher.teacher_id = class.class_teacher_id
                      WHERE attendance.attendance_class_id = student_course.sc_class_id
                      AND attendance.attendance_status = 'Present'
                      AND attendance.attendance_verify = '0'
                      AND attendance.attendance_student_id = student.student_id
                      AND student.student_id = :student_id
                         GROUP BY course.course_id";

            // prepare query statement
            $stmt = $conn -> prepare($sql);

            //Bind the parameters
            $stmt -> bindValue(':student_id', $student_id, PDO::PARAM_INT);

            // execute query
            $stmt->execute();
            return $stmt-> fetchALL(PDO::FETCH_ASSOC);
        }


        
    public function updateAttendanceStatus($conn)
    {
        $sql = "UPDATE attendance
                SET attendance_status = :attendance_status,
                    attendance_duration = :attendance_duration,
                    attendance_date = :attendance_date,
                    attendance_verify = '0'
                    WHERE attendance_id = :attendance_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':attendance_date', $this -> attendance_date, PDO::PARAM_STR);
        $stmt -> bindValue(':attendance_id', $this -> attendance_id, PDO::PARAM_INT);
        $stmt -> bindValue(':attendance_status', $this -> attendance_status, PDO::PARAM_STR);
        $stmt -> bindValue(':attendance_duration', $this -> attendance_duration, PDO::PARAM_INT);

        return $stmt -> execute();
    }

    public static function getAllAttendances($conn, $class_id)
    {
        $sql = "SELECT *
                FROM attendance
                LEFT JOIN student
                ON attendance.attendance_student_id = student.student_id
                WHERE attendance.attendance_class_id = :class_id
                ORDER BY attendance_date DESC";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':class_id', $class_id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Attendance');

        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    
    public static function getAttendancesByStudentId($conn, $class_id, $student_id)
    {
        $sql = "SELECT *
                FROM attendance
                LEFT JOIN student
                ON attendance.attendance_student_id = student.student_id
                WHERE attendance.attendance_class_id = :class_id
                AND attendance.attendance_student_id = :student_id
                ORDER BY attendance_date DESC";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt -> bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public static function getAttendanceByClass($conn, $class_id)
    {
        $sql = "SELECT *
                  FROM class, student, student_course, teacher
                  WHERE student.student_id = student_course.sc_student_id
                  and student_course.sc_class_id = class.class_id
                  and class.class_teacher_id = teacher.teacher_id
                  and class.class_id = :class_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':class_id', $class_id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Attendance');

        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public static function getStudentCoursesTeachers($conn, $sc_student_id, $sc_course_id)
    {
        $sql = "SELECT *
            FROM  student_course
            WHERE student_course.sc_student_id = :sc_student_id;
            AND student_course.sc_course_id = :sc_course_id;";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':sc_student_id', $sc_student_id, PDO::PARAM_INT);
        $stmt -> bindValue(':sc_course_id', $sc_course_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public static function getAllStudentCourseTeacher($conn)
    {
        $sql = "SELECT *
                FROM student_course
                ORDER BY sc_id;";

        $results = $conn -> query($sql);
        return $results -> fetchAll(PDO::FETCH_ASSOC);
    }


    public function getByStudentCourseTeacher($conn)
    {
        $sql = "SELECT *
                FROM  student_course
                WHERE student_course.sc_student_id = :sc_student_id
                AND student_course.sc_course_id = :sc_course_id;";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':sc_student_id', $this -> sc_student_id, PDO::PARAM_INT);
        $stmt -> bindValue(':sc_course_id', $this -> sc_course_id, PDO::PARAM_INT);
        $stmt ->execute();
        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }

    public static function getAllStudentCourses($conn)
    {
        $sql = "SELECT *
                FROM course
                ORDER BY course_name;";

        $results = $conn -> query($sql);
        return $results -> fetchAll(PDO::FETCH_ASSOC);
    }


    public function createStudentEnrollCourse($conn, $arithmos)
    {
        $sql = "UPDATE student_course
                SET student_course.sc_test = :arithmos
                WHERE student_course.sc_student_id = '30'
                AND student_course.sc_course_id = '27'";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':arithmos', $this -> arithmos, PDO::PARAM_INT);
        return $stmt -> execute();
    }


    public function verifyAttendance($conn)
    {
        $sql = "UPDATE attendance
                SET attendance_verify = '1'
                WHERE attendance_id = :attendance_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':attendance_id', $this -> attendance_id, PDO::PARAM_INT);
        return $stmt -> execute();
    }
}