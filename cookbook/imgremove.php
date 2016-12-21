<html>
<?php
session_start();

$name = "IMAGES/" . $_SESSION['ID'];
$check = glob($name . ".*");
$found = pathinfo($check[0]);
$ext = $found['extension'];
//Remove image
unlink($name . "." . $ext);

header('Location: recipepage.php');
?>
</html>
