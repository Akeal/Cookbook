<?php
//Start session
session_start();

ini_set('display_errors',1);
error_reporting(E_ALL);
//Check if already an image, delete if there is.
$name = "IMAGES/" . $_SESSION['ID'];
$check = glob($name . ".*");
$found = pathinfo($check[0]);
$ext = $found['extension'];
$checklevel = 0;
if(file_exists($name . "." . $ext)){
	$prevname = $name . "." . $ext;
	$checklevel = 1;
}
//Create vars
$imgdir = "IMAGES/";
$filetype = pathinfo($_FILES['imageselect']['name'],PATHINFO_EXTENSION);
$imgname = $_SESSION['ID'] . "." . $filetype;
$fulldir = $imgdir . $imgname;
$upload = 1;
if(isset($_POST["subimage"])){
//Check if file is an image
	$isimg = getimagesize($_FILES["imageselect"]["tmp_name"]);
	if($isimg !== false){
		echo "File is an image.";
		$upload = 1;
	}
	else{
		echo "File is not an image.";
		$upload = 0;
	}
}
if($filetype != "jpg" && $filetype != "png" && $filetype != "jpeg" && filetype != "gif"){
	echo "Can only submit files type JPG, JPEG, PNG, and GIF.";
	$upload = 0;
}
if($upload == 0){
	echo "File not uploaded.";
}
else{
//Delete old image
	if($checklevel == 1 && $upload == 1){
		unlink($prevname);
	}
//Upload file
	if(move_uploaded_file($_FILES["imageselect"]["tmp_name"], $fulldir)){
		echo "File uploaded.";
	}
	else{
		echo "File failed to upload.";
	}
}
header('Location: recipepage.php');
?>
