<?php
include "./config.php";
$json = file_get_contents('php://input');
$data = json_decode($json);
$id = $data->id;
$event = $data->event;
if ($event == "inc") {
    $sql = "UPDATE election SET votes = votes + 1 WHERE id = $id";
} else {
    $sql = "UPDATE election SET votes = votes - 1 WHERE id = $id";
}
if ($con->query($sql) === TRUE) {
    echo "Votes Updated";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
$con->close();
