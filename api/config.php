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

$db = mysql_select_db($dbname);

if(empty($db)){
    $dbcr = "CREATE DATABASE " + $dbname;
    $check = mysql_query($dbcr);
    if(!$check){
        echo "database creation error";
    }
    else{
        echo "database created";
    }
}
else{
    echo "database exists <br/>";
    $table = "SELECT * FROM election";
    $chacktable = mysql_query($table);
    if(!$chacktable){
        $createTable ="CREATE TABLE election(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            img varchar(255) NOT NULL,
            text varchar(255) NOT NULL,
            votes INT(10) NOT NULL,
            )";
            $ok = mysql_query($createTable)
            if(!$ok) {
                echo "table creation error";
            }
            else {
                echo "table created";
            }
    }
    else {
        echo "table exist";
    }
}
