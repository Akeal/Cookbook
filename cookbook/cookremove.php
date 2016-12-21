<html>
<head>
<title>Remove Recipe</title>
</head>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
session_start();
include 'header.php';
//Delete image if exists
$name = "IMAGES/" . $_SESSION['ID'];
$check = glob($name . ".*");
$found = pathinfo($check[0]);
$ext = $found['extension'];
if(file_exists($name . "." . $ext)){
	unlink($name . "." . $ext);
}
//Delete recipe
$prepared = $pdo->prepare('DELETE FROM Ingredient WHERE RecUsed = ?');
$preparee = $pdo->prepare('DELETE FROM Step WHERE RecID = ?');
$preparef = $pdo->prepare('DELETE FROM Recipe WHERE ID = ?');
$prepared->execute(array($_SESSION['ID']));
$preparee->execute(array($_SESSION['ID']));
$preparef->execute(array($_SESSION['ID']));
session_unset();
session_destroy();
echo 'Recipe Deleted.';
header('Location: index.php');
}
?>
</html>
