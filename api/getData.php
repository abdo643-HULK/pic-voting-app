<?php
include "./config.php";

header("Content-Type: application/json; charset=UTF-8");
$cards = [];
$sql = "SELECT * FROM election";

if ($result = mysqli_query($con, $sql)) {
    $cr = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $cards[$cr]['id'] = $row['id'];
        $cards[$cr]['img'] = $row['img'];
        $cards[$cr]['text'] = $row['text'];
        $cards[$cr]['votes'] = $row['votes'];
        $cr++;
    }
    echo json_encode($cards, true);
} else {
    http_response_code(404);
}
