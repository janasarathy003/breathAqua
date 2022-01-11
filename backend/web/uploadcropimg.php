<?php

/* Getting file name */
//$filename = $$_POST['imageData'];
/*
$img = $_POST['imageData'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = 'cropped_image.png';
$success = file_put_contents($file, $data);*/

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content);

$img = str_replace('data:image/png;base64,', '', $decoded->imageData);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = 'images/cropped_'.$decoded->fileName;
$saved_file = file_put_contents($file, $data);

if (($saved_file === false) || ($saved_file == -1)) {
    echo "Couldn't save weather to weather-$zip.txt";
}else{
	echo $file;
}


?>

