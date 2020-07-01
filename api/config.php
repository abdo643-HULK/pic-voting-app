<?php

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "voting"; /* Database name */

$con = new mysqli($host, $user, $password);
// Check connection
if ($con->connect_error) {
    $error = $con->connect_error;
    die("Connection failed: " . $error);
}

$db = mysqli_select_db($con, $dbname);

if (empty($db)) {
    $dbcr = "CREATE DATABASE voting";
    $check = mysqli_query($con, $dbcr);
    if (!$check) {
        echo "database creation error <br/>";
    } else {
        echo "database created";
        $table = "SELECT * FROM election";
        $chacktable = mysqli_query($con, $table);
        if (!$chacktable) {
            $createTable = "CREATE TABLE election(
                id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                img varchar(255) NOT NULL,
                text varchar(255) NOT NULL,
                votes INT(10) NOT NULL,
                )";
            $ok = mysqli_query($con, $createTable);
            if (!$ok) {
                echo "table creation error ";
            } else {
                echo "table created ";
            }
        } else {
            echo "table exist ";
        }
    }
} else {
    echo "database exists <br/>";
    $table = "SELECT * FROM election";
    $chacktable = mysqli_query($con, $table);
    if (!$chacktable) {
        $createTable = "CREATE TABLE election (
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            img varchar(255) NOT NULL,
            text varchar(255) NOT NULL,
            votes INT(10) NOT NULL
            )";
        $ok = mysqli_query($con, $createTable);
        if (!$ok) {
            echo "table creation error";
        } else {
            echo "table created";
        }
    } else {
        echo "table exist";
    }
}
