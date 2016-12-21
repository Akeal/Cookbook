<html>
<head>
<title>Add to Cookbook</title>
<link rel="stylesheet" type="text/css" href="cookcss.css">
</head>
<body>
<?php
session_start();
include 'header.php';

//Get previous image name if it exists
$name = "IMAGES/" . $_SESSION['ID'];
$check = glob($name . ".*");
$found = pathinfo($check[0]);
$ext = $found['extension'];
if(file_exists($name . "." . $ext)){
        $prevname = $name . "." . $ext;
}

$preparea = $pdo->prepare('INSERT INTO Recipe (Title, Hours, Minutes, Type, Genre, CalPerServ, NumServ, Note) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
$prepareb = $pdo->prepare('INSERT INTO Step (RecID, Description, Number) VALUES (?, ?, ?)');
$preparec = $pdo->prepare('INSERT INTO Ingredient (RecUsed, Name, Amount, Priority) VALUES (?, ?, ?, ?)');
$prepared = $pdo->prepare('DELETE FROM Ingredient WHERE RecUsed = ?');
$preparee = $pdo->prepare('DELETE FROM Step WHERE RecID = ?');
$preparef = $pdo->prepare('DELETE FROM Recipe WHERE ID = ?');

$prepared->execute(array($_SESSION['ID']));
$preparee->execute(array($_SESSION['ID']));
$preparef->execute(array($_SESSION['ID']));

$itstep = 1;
$lowertitle = strtolower($_POST['title']);
$lowertype = strtolower($_POST['type']);
$lowergenre = strtolower($_POST['genre']);
$preparea->execute(array($lowertitle, $_POST['hournum'], $_POST['minutenum'], $lowertype, $lowergenre, $_POST['calperserv'], $_POST['numserv'], $_SESSION['note']));
//Get last ID
$_SESSION['ID'] = $pdo->lastInsertId();

//Store each step
foreach($_POST['inputwhattodo'] as $var1){
$prepareb->execute(array($_SESSION['ID'], $var1, $itstep));
$itstep = $itstep+1;
}
$priority = 1;
//Store each ingredient
foreach(array_combine($_POST['ingredientbox'],$_POST['amountbox']) as $var2=>$var3){
$preparec->execute(array($_SESSION['ID'], $var2, $var3, $priority));
$priority++;
}

//Deal with recipe image
if(file_exists($prevname)){
        $newname = "IMAGES/" . $_SESSION['ID'] . "." . $ext;
        rename($prevname, $newname);
}

header('Location: recipepage.php');
?>
</body>
</html>
