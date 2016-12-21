
<html>
<head>
<title>Cookbook Page</title>
<link rel="stylesheet" type="text/css" href="cookcss.css">
</head>
<?php
//Include necessary external files
include 'header.php';

//Create Session for Delete
session_start();

$savenote = $pdo->prepare('UPDATE Recipe SET Note = ? WHERE ID = ?');
$deletenote = $pdo->prepare('UPDATE Recipe SET Note = NULL WHERE ID = ?');

//If a note does not exist create one. Otherwise delete the old one and create a new one.
if($_POST['note'] == ""){
	$deletenote->execute(array($_SESSION['ID']));
}
else{
	$savenote->execute(array($_POST['note'],$_SESSION['ID']));
}

header('Location: recipepage.php');
?>
</body>
</html>
