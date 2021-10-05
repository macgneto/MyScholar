<?php


class General
{
    public static function getCount($conn, $column ='*', $table, $where='')
    {
        $sql = "SELECT $column
                FROM $table
                $where";

        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        return $stmt -> rowCount();
    }
}
