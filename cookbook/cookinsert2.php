<html>
<head>
<title>Submitted</title>
<link rel="stylesheet" type="text/css" href="cookcss.css">
</head>
<body>
<?php
include 'header.php';

$preparea = $pdo->prepare('INSERT INTO Recipe (Title, Hours, Minutes, Type, Genre, CalPerServ, NumServ) VALUES (?, ?, ?, ?, ?, ?, ?)');
$prepareb = $pdo->prepare('INSERT INTO Step (RecID, Description, Number) VALUES (?, ?, ?)');
$preparec = $pdo->prepare('INSERT INTO Ingredient (RecUsed, Name, Amount, Priority) VALUES (?, ?, ?, ?)');

$itstep = 1;
$lowertitle = strtolower($_POST['title']);
$lowertype = strtolower($_POST['type']);
$lowergenre = strtolower($_POST['genre']);
$preparea->execute(array($lowertitle, $_POST['hournum'], $_POST['minutenum'], $lowertype, $lowergenre, $_POST['calperserv'], $_POST['numserv']));
$ID = $pdo->lastInsertId();
//Insert each step
foreach($_POST['inputwhattodo'] as $var1){
$prepareb->execute(array($ID , $var1, $itstep));
$itstep = $itstep+1;
}
$priority = 1;
//Insert each ingredient
foreach(array_combine($_POST['ingredientbox'],$_POST['amountbox']) as $var2=>$var3){
$preparec->execute(array($ID, $var2, $var3, $priority));
$priority++;
}


header('Location: index.php');
?>
</body>
</html>

