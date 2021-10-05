<?php



class Payment
{
    public $payment_id;
    public $payment_amount;
    public $payment_date_time;
    public $payment_sc_id;



    public static function getPaymentInfoById($conn, $sc_id)
    {
        $sql = "SELECT SUM(payment_amount)
                    FROM payment
                    WHERE payment.payment_sc_id = :sc_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':sc_id', $sc_id, PDO::PARAM_INT);

        if ($stmt ->execute()) {
            return $stmt -> fetch();
        }
    }

    public static function getPaymentHistoryById($conn, $sc_id)
    {
        $sql = "SELECT *
                FROM payment
                WHERE payment.payment_sc_id = :sc_id
                ORDER BY payment_date_time DESC";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':sc_id', $sc_id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt -> fetchALL(PDO::FETCH_ASSOC);
    }


    public function createPayment($conn)
    {
        {
        $sql = "INSERT INTO payment (payment_sc_id, payment_amount, payment_date_time)
                VALUES (:payment_sc_id, :payment_amount, :payment_date_time)";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':payment_sc_id', $this -> payment_sc_id, PDO::PARAM_INT);
        $stmt -> bindValue(':payment_amount', $this -> payment_amount, PDO::PARAM_INT);
        $stmt -> bindValue(':payment_date_time', $this -> payment_date_time, PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return true;
        }

    }
    }


    public function editStudentCoursePayment($conn, $payment_id, $payment_amount)
    {
        $sql = "UPDATE payment
                SET payment_amount = :payment_amount
                WHERE payment.payment_id = :payment_id";

        $stmt = $conn -> prepare($sql);

        $stmt -> bindValue(':payment_id', $payment_id, PDO::PARAM_INT);
        $stmt -> bindValue(':payment_amount', $payment_amount, PDO::PARAM_INT);


        if ($stmt -> execute()) {
            return true;
        }
    }
}
