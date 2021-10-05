<?php



class TeacherCourses
{
    public $student_id;
    public $course_id;
    public $teacher_id;
    public $teacher_firstname;
    public $teacher_lastname;
    public $teacher_email;
    public $teacher_mobile;
    public $class_id;


    public static function getAllTeacherCourses($conn)
    {
        $sql = "SELECT *
                FROM course
                ORDER BY course_title;";

        $results = $conn -> query($sql);

        return $results -> fetchAll(PDO::FETCH_ASSOC);
    }



    public static function getAllTeacherCourseClasses($conn)
    {
        $sql = "SELECT *
                FROM teacher_course
                ORDER BY tc_id;";

        $results = $conn -> query($sql);

        return $results -> fetchAll(PDO::FETCH_ASSOC);
    }



    public static function getTeacherWithCourse($conn, $student_id, $course_id)
    {
        $sql = "SELECT *
                FROM teacher
                LEFT JOIN teacher_course
                ON teacher.teacher_id = teacher_course.tc_teacher_id
                LEFT JOIN student_course
                ON student_course.sc_course_id = teacher_course.tc_course_id
                WHERE student_course.sc_student_id = :student_id
                AND student_course.sc_course_id = :course_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt -> bindValue(':course_id', $course_id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'TeacherCourses');

        $stmt -> execute();

        return $stmt -> fetch();
    }



    public static function getTeacherCourseInfobyId($conn, $tc_id)
    {
        $sql = "SELECT *
                FROM teacher_course, teacher, course, class
                where teacher_course.tc_teacher_id = teacher.teacher_id
                AND teacher_course.tc_course_id = course.course_id
                AND teacher_course.tc_id = :tc_id";


        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':tc_id', $tc_id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'TeacherCourses');

        $stmt -> execute();

        return $stmt -> fetch();
    }


    public static function getTeacherClasses($conn, $tc_id)
    {
        $sql = "SELECT *
                FROM teacher_course, teacher, course, class
                where teacher_course.tc_teacher_id = teacher.teacher_id
                AND teacher_course.tc_course_id = course.course_id
                AND class.class_course_id = teacher_course.tc_course_id
                AND class.class_teacher_id = teacher_course.tc_teacher_id
                AND teacher_course.tc_id = :tc_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':tc_id', $tc_id, PDO::PARAM_INT);

        $stmt -> setFetchMode(PDO::FETCH_ASSOC);

        $stmt -> execute();

        return $stmt -> fetchAll();
    }


    // Used in Classroom section to authenticate if a teacher is teaching in specific classroom.
    // It uses teacher id and classroom.teacher id to compare if they match and allow access
    public static function getTeacherClassesByTeacherId($conn, $teacher_id)
    {
        $sql = "SELECT *
                FROM teacher_course, teacher, course, class
                where teacher_course.tc_teacher_id = teacher.teacher_id
                AND teacher_course.tc_course_id = course.course_id
                AND class.class_course_id = teacher_course.tc_course_id
                AND class.class_teacher_id = teacher_course.tc_teacher_id
                AND teacher_course.tc_teacher_id = :teacher_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
        // $stmt -> bindValue(':course_id', $course_id, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute();

        return $stmt -> fetchAll();
    }




    public static function getTeacherClasses1($conn)
    {
        $sql = "SELECT class.*
                FROM class
                JOIN teacher_course
                ON class.course_id = teacher_course.tc_course_id
                WHERE teacher_course.tc_teacher_id = :teacher_id";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':teacher_id', $this ->teachert_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public static function getTeacherClassAttendances($conn, $teacher_id, $teacher_class_id)
    {
        $sql = "SELECT *, MAX(attendance.attendance_duration) as max_attendance_duration
                FROM teacher, teacher_course, class, attendance
                WHERE attendance.attendance_class_id = class.class_id
                AND class.class_teacher_id = teacher_course.tc_teacher_id
                AND teacher_course.tc_teacher_id = teacher.teacher_id
                AND teacher.teacher_id = :teacher_id
                AND class.class_id = :teacher_class_id
                GROUP BY attendance.attendance_date";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt -> bindValue(':teacher_class_id', $teacher_class_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public static function getCountTeacherClassAttendances($conn, $teacher_id, $teacher_class_id)
    {
        $sql = "SELECT COUNT(*), MAX(attendance.attendance_duration)
                FROM teacher, teacher_course, class, attendance
                WHERE attendance.attendance_class_id = class.class_id
                AND class.class_teacher_id = teacher_course.tc_teacher_id
                AND teacher_course.tc_teacher_id = teacher.teacher_id
                AND teacher.teacher_id = :teacher_id
                AND class.class_id = :teacher_class_id
                GROUP BY attendance.attendance_date";

        $stmt = $conn -> prepare($sql);
        $stmt -> bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt -> bindValue(':teacher_class_id', $teacher_class_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> rowCount();
    }
}
