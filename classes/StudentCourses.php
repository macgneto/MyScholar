<?php



class StudentCourses
{
    public $sc_id;
    public $sc_student_id;
    public $sc_course_id;
    public $sc_class_id;
    public $sc_cost;
    public $sc_special_cost;
    public $sc_cost_type;
    // public $class_id;

    /**
     *  Get all the info for Student, Course, Class, Teacher
     */
    public static function getStudentCourseΙnfoByID($conn, $sc_id)
    {
        $sql = "SELECT *
                  FROM student
                  LEFT JOIN student_course
                  ON student_course.sc_student_id = student.student_id
                  LEFT JOIN course
                  ON  student_course.sc_course_id = course.course_id
                  LEFT JOIN class
                  ON  student_course.sc_class_id = class.class_id
                  LEFT JOIN teacher
                  ON teacher.teacher_id = class.class_teacher_id
                  LEFT JOIN payment
                  ON payment.payment_sc_id = student_course.sc_id
                  WHERE student_course.sc_id = :sc_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':sc_id', $sc_id, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'StudentCourses');
        if ($stmt ->execute()) {
            return $stmt -> fetch();
        }
    }


    public static function getStudentCourseTeacherInfoByID($conn, $sc_id)
    {
        $sql = "SELECT *
                  FROM student, course, teacher, student_course , teacher_course
                  WHERE student_course.sc_student_id = student.student_id
                  and student_course.sc_course_id = course.course_id
                  and student_course.sc_course_id = teacher_course.tc_course_id
                  and teacher.teacher_id=teacher_course.tc_teacher_id
                  and student_course.sc_id = :sc_id;";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':sc_id', $sc_id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'StudentCourses');

        if ($stmt ->execute()) {
            return $stmt -> fetch();
        }
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



    public function registerStudentCourseToClass($conn)
    {
        $sql = "UPDATE student_course
                SET student_course.sc_class_id = :sc_class_id
                WHERE student_course.sc_id = :sc_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':sc_class_id', $this -> sc_class_id, PDO::PARAM_INT);
        $stmt -> bindValue(':sc_id', $this -> sc_id, PDO::PARAM_INT);

        return $stmt -> execute();
    }



    public static function getHoursPresent($conn, $student, $class)
    {
        $sql = "SELECT SUM(attendance_duration) as value_sum
                FROM attendance
                WHERE attendance.attendance_student_id = :student
                AND attendance.attendance_class_id = :class
                AND attendance.attendance_status = 'Present'";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student', $student, PDO::PARAM_INT);
        $stmt -> bindValue(':class', $class, PDO::PARAM_INT);
        $stmt -> execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $sum = $row['value_sum'];
        return $sum;
    }


    public static function getHoursAbsent($conn, $student, $class)
    {
        $sql = "SELECT SUM(attendance_duration) as value_sum
              FROM attendance
              WHERE attendance.attendance_student_id = :student
              AND attendance.attendance_class_id = :class
              AND attendance.attendance_status = 'Absent'";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student', $student, PDO::PARAM_INT);
        $stmt -> bindValue(':class', $class, PDO::PARAM_INT);
        $stmt -> execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $sum = $row['value_sum'];
        return $sum;
    }

    public static function getHoursUnverified($conn, $student, $class)
    {
        $sql = "SELECT SUM(attendance_duration) as value_sum
              FROM attendance
              WHERE attendance.attendance_student_id = :student
              AND attendance.attendance_class_id = :class
              AND attendance.attendance_status = 'Absent'";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student', $student, PDO::PARAM_INT);
        $stmt -> bindValue(':class', $class, PDO::PARAM_INT);
        $stmt -> execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $sum = $row['value_sum'];
        return $sum;
    }

    public static function getHoursVerified($conn, $student, $class)
    {
        $sql = "SELECT SUM(attendance_duration) as value_sum
              FROM attendance
              WHERE attendance.attendance_student_id = :student
              AND attendance.attendance_class_id = :class
              AND attendance.attendance_status = 'Present'
              AND attendance.attendance_verify= '1'";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student', $student, PDO::PARAM_INT);
        $stmt -> bindValue(':class', $class, PDO::PARAM_INT);

        $stmt -> execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $sum = $row['value_sum'];
        return $sum;
    }


    public static function getUnverifiedRequests($conn, $student, $class)
    {
        $sql = "SELECT *
                FROM attendance
                WHERE attendance.attendance_student_id = :student
                AND attendance.attendance_class_id = :class
                AND attendance.attendance_status = 'Present'
                AND attendance.attendance_verify= '0'
                ORDER BY attendance_date";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':student', $student, PDO::PARAM_INT);
        $stmt -> bindValue(':class', $class, PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * Update the student record based on the ID
     *
     * @param object $conn Connection to the database
     * @param integer $student_id for the student ID
     *
     * @return execute Update the record of the student with that ID
     */
    public function updateStudentCourseCost($conn)
    {
        $sql = "UPDATE student_course
                SET sc_special_cost = :sc_special_cost,
                    sc_cost_type = :sc_cost_type

                WHERE sc_id = :sc_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':sc_id', $this -> sc_id, PDO::PARAM_INT);
        $stmt -> bindValue(':sc_special_cost', $this -> sc_special_cost, PDO::PARAM_INT);
        $stmt -> bindValue(':sc_cost_type', $this -> sc_cost_type, PDO::PARAM_STR);

        return $stmt -> execute();
    }


    public function getStudentCourseAttendancesById($conn, $sc_id)
    {
        $sql = "SELECT *
                FROM  attendance
                WHERE attendance.attendance_sc_id = :sc_id
                ORDER BY attendance_date DESC
                ";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':sc_id', $sc_id, PDO::PARAM_INT);
        $stmt ->execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }
}
