<?php
include "./config.php";
$sort = "SELECT * FROM election ORDER BY votes DESC;";
//Will nicht funktionieren
$result = $con->query($sort);
if ($result === TRUE) {
    echo "sorted";
} else {
    echo "Error: " . $sort . "<br>" . $con->error;
}
