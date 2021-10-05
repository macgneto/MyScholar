<?php

class Mail
{
    public $mail_subject;
    public $mail_recipient;
    public $mail_content;



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






use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';


$mail = new PHPMailer(true);



public function mailAttendance($mail_recipient, $mail_subject, $content) {
    try {

        $mail -> isSMTP();
        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail -> Username = 'myinvoice.eap@gmail.com';
        $mail -> Password = '10254662';
        $mail -> SMTPSecure = 'tls';
        $mail -> Port = 587;

        $mail -> setFrom('myinvoice.eap@gmail.com');
        $mail -> addAddress($mail_recipient);
        $mail -> Subject = $mail_subject;
        // $mail -> msgHTML(file_get_contents('index.php'), __DIR__);
        // $mail -> msgHTML(file_get_contents('index.php'), __DIR__);
        $mail -> Body = 'Hello alania. Pos sas fenetai to email mas?';

        $mail -> Send();

        echo "To minima estali";

    } catch (Exception $e) {

        echo 'Message not send: ', $mail -> ErrorInfo;
    }

}
