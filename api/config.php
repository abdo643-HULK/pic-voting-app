<?php

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "test"; /* Database name */

$con = new mysqli($host, $user, $password, $dbname);
// Check connection
if ($con->connect_error) {
    $error = $con->connect_error;
    die("Connection failed: " . $error);
}
