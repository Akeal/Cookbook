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
//Get searched recipe details
$lower = strtolower($_GET['search']);
$GrabbedRecipes= $pdo->prepare('SELECT Title, Hours, Minutes, ID FROM Recipe WHERE Title LIKE "%" ? "%" ORDER BY Title');
$GrabbedRecipes->execute(array($lower));
//One search result, redirect to the only result recipe page
if($GrabbedRecipes->rowCount() == 1){
	$Recipe = $GrabbedRecipes->fetch(PDO::FETCH_NUM);
	$UpTitle = ucwords($Recipe[0]);
	$newtitle = str_replace(" ", "+", $UpTitle[0]);
	header("Location: recipepage.php?sub=$UpTitle&item=$Recipe[3]&search=1");
}
$Recipes = $GrabbedRecipes->fetchAll(PDO::FETCH_NUM);
//Multiple search results
if($GrabbedRecipes->rowCount() !=0){
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
        		echo '<td id="hours" class="number"">';
        		echo '?';
        		echo '</td>';
        		echo '<td id="minutes" class="right number" style="text-align: center;">';
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
}
//No search results
if($GrabbedRecipes->rowCount() == 0){
	echo '<div id="noresultdiv">';
	echo '<h1 id="noresult">No results for "';
	echo $_GET['search'];
	echo '". </h1>';
	echo '</div>';
}

?>
</body>
</html>

