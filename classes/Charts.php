<?php

class Charts
{
    public $chart_students_total;



    /**
     *  @param object $conn Connection to the database
     *  @param value 'Active' for active students
     *
     *  @return rowCount for counting all the rows that have 'Active' as value
     */
    public static function chartAllStudents($conn)
    {
        $sql = "SELECT *
                FROM student
                ";

        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        return $stmt -> rowCount();
    }






    /**
     *  @param object $conn Connection to the database
     *  @param value 'Active' for active students
     *
     *  @return rowCount for counting all the rows that have 'Active' as value
     */
    public static function chartAllStudentsRegistrations($conn)
    {
        $sql = "SELECT COUNT(*) as total , student_registered_at
                FROM student
                GROUP BY student_registered_at";

        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        return $stmt;
    }




    public static function getInfoAboutMoney($conn)
    {
        $sql = "SELECT *
                FROM attendance
                LEFT JOIN  student_course
                ON attendance.attendance_sc_id = student_course.sc_id
                LEFT JOIN course
                ON student_course.sc_course_id = course.course_id
                WHERE attendance.attendance_status = 'Present'";

        $results = $conn -> query($sql);
        // $row_count = this->results->rowCount();
        return $results -> fetchAll(PDO::FETCH_ASSOC);

        // $stmt = $conn -> prepare($sql);
        // $stmt -> execute();
        // return $stmt;
    }




    /**
     *  @param object $conn Connection to the database
     *  @param value 'Active' for active students
     *
     *  @return rowCount for counting all the rows that have 'Active' as value
     */
    public static function sumTotalPayments($conn)
    {
        $sql = "SELECT sum(payment_amount) as sum
                FROM payment
            ";
        $stmt = $conn -> prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $sum = $row['sum'];
        return $sum;
    }
}
