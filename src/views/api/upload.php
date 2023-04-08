<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
$target_dir = "/Users/ruiqichen/Desktop/CRM-System/src/views/api/uploads/";;
$target_file = $target_dir .'/' .  basename($_FILES["file"]["name"]);
$uploadOk = 1;

// if (!is_dir($target_dir)) {
//     mkdir($target_dir, 0755, true);
// }
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>
