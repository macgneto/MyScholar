<?php
if (isset($_POST['number']) ) {
    // require("lib.php");
    require '.../includes/init.php';
    $conn = require '.../includes/db.php';






    class CRUD
    {

        protected $db;

        function __construct()
        {
            $this->db = DATABASE();
        }

        function __destruct()
        {
            $this->db = null;
        }

        /*
         * Add new Record
         *
         * @param $first_name
         * @param $last_name
         * @param $email
         * @return $mixed
         * */
         public function Create($number)
        {
            $query = $this->db->prepare("INSERT INTO student_course (sc_test) VALUES (:number) WHERE student_course.sc_student_id = :student_id");
            $query->bindParam("number", $number, PDO::PARAM_STR);
            $query->bindParam("student_id", $student_id, PDO::PARAM_STR);
            // $query->bindParam("last_name", $last_name, PDO::PARAM_STR);
            // $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            return $this->db->lastInsertId();
        }





    $number = $_POST['number'];
    // $last_name = $_POST['last_name'];
    // $email = $_POST['email'];

    $object = new CRUD();

    $object->Create($number);
}
?>
