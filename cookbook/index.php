<html>
<head>
<link rel="stylesheet" type="text/css" media="screen and (min-device-width: 1000px)" href="cookcss.css">
<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 360px)" href="360px.css">
<title>Nick's Cookbook</title>
</head>
<body>
<?php
//Include header and connect to database
include 'header.php';
session_unset();
session_destroy();
//Get recipe details
$GrabRecipes = "SELECT Title, Hours, Minutes, ID FROM Recipe ORDER BY Title";
$GrabbedRecipes = $pdo->query($GrabRecipes);
$Recipes = $GrabbedRecipes->fetchAll(PDO::FETCH_NUM);

//Print all recipes
echo '<div id="bookbody">';
echo '<table id="recipelist">';
echo '<th> Select Recipe </th>';
echo '<th> Hours </th>';
echo '<th> Minutes </th>';
foreach($Recipes as $Recipe){
$UpperTitle = ucwords($Recipe[0]);
echo '<tr id="recipelistrow">';
echo '<form action="recipepage.php" method="get">';
echo '<td id="recipe" class="left">';
echo "<input type=\"submit\" name='sub' id=\"recipebutton\" value=\"$UpperTitle\">";
echo "<input type='hidden' name='item' value='$Recipe[3]'>";
echo '</td>';
if($Recipe[1] == 0 && $Recipe[2] == 0){
        echo '<td class="number">';
        echo '?';
        echo '</td>';
        echo '<td id="minutes" class="right number">';
        echo '?';
        echo '</td>';
}
else{
	echo '<td class="number">';
	echo $Recipe[1];
	echo '</td>';
	echo '<td id="minutes" class="right number">';
	echo $Recipe[2];
	echo '</td>';
}
echo '</tr>';
echo '</form>';
}
echo '</table>';
echo '</div>';
?>
</body>
</html>
