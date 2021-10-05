<?php

class Database
{
    public function getConn()
    {
        $db_host = "localhost:3307";
        $db_name = "my_scholar_db";
        $db_user = "root";
        $db_pass = "Mysql1983!";

        $sdn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

        try {
            $db = new PDO($sdn, $db_user, $db_pass);

            $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;
        } catch (PDOException $e) {
            echo $e -> getMessage();
            exit;
        }
    }
}
