<?php
include "./config.php";

$text = $_POST["text"];
$img = $_FILES['bild']['name'];
$votes = 0;
$dir = "../images"
$tmpName = $_FILES['bild']['tmp_name'];
$finfo = new finfo(FILEINFO_MIME_TYPE);
$ext = array_search(
	$finfo->file($tmpName),
	array(
		'jpg' => 'image/jpg',
		'png' => 'image/png',
		'gif' => 'image/gif',
		"jpeg" => "image/jpeg",
		"svg" => "image/svg"
	),
	true
);
if ( !file_exists( $dir ) && !is_dir( $dir ) ) {
    mkdir( $dir );       
} 
$imagePath = sprintf('../images/%s.%s', sha1_file($tmpName), $ext);
move_uploaded_file($tmpName, $imagePath);
$sql = "INSERT INTO election (img,text,votes) VALUES('$imagePath','$text','$votes')";
if ($con->multi_query($sql) === TRUE) {
	echo "File Sucessfully uploaded";
} else {
	echo "Error: " . $sql . "<br>" . $con->error;
}
$con->close();
