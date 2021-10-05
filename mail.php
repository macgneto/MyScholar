<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';




$mail = new PHPMailer(true);


$subject = 'test other fucker';

try {

  $mail -> isSMTP();
  $mail -> Host = 'smtp.gmail.com';
  $mail -> SMTPAuth = true;
  $mail -> Username = 'myinvoice.eap@gmail.com';
  $mail -> Password = '10254662';
  $mail -> SMTPSecure = 'tls';
  $mail -> Port = 587;

  $mail -> setFrom('myinvoice.eap@gmail.com');
  $mail -> addAddress('macgneto@gmail.com');
  $mail -> Subject = $subject;
  $mail -> msgHTML(file_get_contents('index.php'), __DIR__);
  // $mail -> Body = 'Hello alania. Pos sas fenetai to email mas?';

  $mail -> Send();

  echo "To minima estali";



} catch (Exception $e) {

  echo 'Message not send: ', $mail -> ErrorInfo;
}
