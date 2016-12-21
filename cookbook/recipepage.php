<html>
<head>
<title>Cookbook Page</title>
<link rel="stylesheet" type="text/css" media="screen and (min-device-width: 1000px)" href="cookcss.css">
<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 360px)" href="360px.css">
</head>
<?php
//Include necessary external files
include 'header.php';
//Create Session for Delete
session_start();
if($_GET['item'] != NULL){
	$_SESSION['note'] = "";
	$_SESSION['ID'] = $_GET['item'];
}
/*Prepared*/
$GrabSteps = $pdo->prepare('SELECT Number, Description FROM Step JOIN Recipe ON RecID = ID AND RecID = ?');
$GrabRecipe = $pdo->prepare('SELECT Title, CalPerServ, NumServ, Note FROM Recipe WHERE ID = ?');
$GrabIngredients = $pdo->prepare('SELECT Name, Amount FROM Ingredient JOIN Recipe ON RecUsed = ID AND RecUsed = ? ORDER BY Priority');
/*Execute*/
$GrabRecipe->execute(array($_SESSION['ID']));
$GrabIngredients->execute(array($_SESSION['ID']));
$GrabSteps->execute(array($_SESSION['ID']));
/*Fetch data needed*/
$Recipe = $GrabRecipe->fetch(PDO::FETCH_NUM);
$Ingredients = $GrabIngredients->fetchAll(PDO::FETCH_NUM);
$Steps = $GrabSteps->fetchAll(PDO::FETCH_NUM);

$UpperTitle = ucwords($Recipe[0]);
echo '<div id="recbody">';
echo '<div id="siderevealdiv">';
echo '<button id="sidereveal" type="button" onClick="ChangeSide();"><img id="revealbuttonimg" src="baseimages/Revealimg.png"/></button>';
echo '</div>';
//Print Tables
echo '<div id="listtheingredients">';
echo '<table id="ingredientlist" style="margin-bottom: 10px;">';
echo '<th>Ingredient</th>';
echo '<th>Amount</th>';
foreach($Ingredients as $Ingredient){
	echo '<tr>';
        echo '<td id="ingredient" class="left">';
        echo $Ingredient[0];
        echo "</td>";
        echo '<td id="amount" class="right">';
        echo $Ingredient[1];
        echo '</td>';
	echo '</tr>';
}
echo '</table>';
echo '</div>';
echo '<div id="listthesteps">';
echo '<table id = "steplist" style="margin-bottom: 10px;">';
echo '<th></th>';
echo '<th>';
echo $UpperTitle;
echo ' Steps';
echo '</th>';
foreach($Steps as $Step){
	echo '<tr>';
        echo '<td id="step" class="left number">';
        echo $Step[0];
        echo "</td>";
       	echo '<td id="description" class="right">';
       	echo $Step[1];
       	echo '</td>';
	echo '</tr>';
}
echo '</table>';
echo '</div>';
//Side Area
echo '<div id="side" class="slideout">';
echo '<div stle="margin-top: 22px;">';
//Delete and Edit buttons
echo '<form id="delform" action="cookremove.php" method="post" onsubmit="return ConfirmDelete();">';
echo '<input type="submit" name="delete" id="deletebutton" value="Delete Recipe">';
echo '</form>';
echo '<form id="editform" action="cookedit.php" method="post">';
echo '<input type="submit" id="editbutton" name="edit" value="Edit Recipe">';
echo '</form>';
//Calories and Servings
if($Recipe[1] != 0 && $Recipe[2] != 0){
	echo '<table id="calinfo">';
	echo '<th>Cals/Serving</th>';
	echo '<th># Servings</th>';
	echo '<tr>';
	echo '<td id = "cals" class="left number">';
	echo $Recipe[1];
	echo '</td>';
	echo '<td id="servs" class="right number">';
	echo $Recipe[2];
	echo '</td>';
	echo '</tr>';
	echo '</table>';
}
//Image
if(file_exists("IMAGES")){
$name = "IMAGES/" . $_SESSION['ID'];
$check = glob($name . ".*");
$found = pathinfo($check[0]);
$ext = $found['extension'];
//If file exists, display it
if(file_exists($name . "." . $ext)){
	echo '<div id="imagediv">';
        echo '<img id="recimage" src="IMAGES/';
        echo $_SESSION['ID'];
        echo '.';
	echo $ext;
	echo '"/>';
        echo '</div>';
}
//If file does not exist, offer option to upload
if(!file_exists($name . "." . $ext)){
	echo '<form action="imgupload.php" id="fileupform" method="post" enctype="multipart/form-data">';
	echo '<div id="fileup">';
	echo '<input type="file" name="imageselect" id="imageselect">';
	echo '</div>';
	echo '<input type="submit" id="upimg" value="Upload Image"  name="subimage">';
	echo '</form>';
}
//If file exists, offer option to change it
if(file_exists($name . "." . $ext)){
        echo '<form action="imgupload.php" id="filechangeform"  method="post" enctype="multipart/form-data">';
        echo '<div id="fileup">';
        echo '<input type="file" name="imageselect" id="imageselect">';
        echo '</div>';
	echo '<div id="setup">';
	echo '<div id="tab">';
	echo '<div id="rw">';
	echo '<div id="col1">';
        echo '<input type="submit" value="Change Image" id="changeimg" name="subimage">';
        echo '</form>';
	echo '</div>';
	echo '<form action="imgremove.php" id="filedelform" method="post">';
	echo '<div id="col2">';
	echo '<input type="submit" value="Delete" id="subremove"/>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</form>';
}
}
//Note
echo '<form id="sideform" action="addnote.php" method="post">';
if($Recipe[3] == NULL){
	echo '<input type="button" name="addnote" id="addnote" value="Add Note" onclick="AddNote();">';
}
else{
	echo '<textarea name="note" id="notetext" maxlength="500">';
	echo $Recipe[3];
	$_SESSION['note'] = $Recipe[3];
	echo '</textarea>';
	echo '<input type="submit" id="savenote" name="save" value="Save Note">';
}
echo '</form>';
echo '</div>';
echo '</div>';
//Message if this was only result from search after redirect from searchres
if(isset($_GET['search'])){
        echo '<script>alert("One result found.");</script>';
}
?>
<script>
function ConfirmDelete(){
var check = confirm("Are you sure you want to delete this recipe?");
	if(check == false){
		return false;
	}
return true;
}
//Code to slide out side area for mobile
function ChangeSide(){
	var side = document.getElementById('side');
	var style = window.getComputedStyle(side);
	var vis = style.getPropertyValue('visibility');
	var banner = document.getElementById('banner');
	var button = document.getElementById('siderevealdiv');
	if(vis == "hidden"){
		side.style.visibility="visible";
		side.className = "slidein";
		banner.style.position="fixed";
		button.style.position="fixed";
		button.style.top="174px";
	}
	else{
        	side.className = "slideout";
		side.addEventListener("webkitTransitionEnd", HideSide);
		side.addEventListener("mozTransitionEnd", HideSide);
                side.addEventListener("oTransitionEnd", HideSide);
                side.addEventListener("transitionend", HideSide);
		banner.style.position="";
                button.style.position="";
                button.style.top="";
		document.body.scrollTop = document.documentElement.scrollTop = 0;
	}
}
//Hide side area for mobile
function HideSide(){
	var side = document.getElementById('side');
	side.style.visibility="hidden";
        side.removeEventListener("webkitTransitionEnd", HideSide);
        side.removeEventListener("mozTransitionEnd", HideSide);
        side.removeEventListener("oTransitionEnd", HideSide);
        side.removeEventListener("transitionend", HideSide);
}
//Add note
function AddNote(){
	document.getElementById('addnote').outerHTML="";
	var notefield = document.createElement("textarea");
	notefield.id="notetext";
	notefield.name="note";
	notefield.maxlength="500";
	document.getElementById('sideform').appendChild(notefield);
	var save = document.createElement("input");
	save.type = "submit";
	save.name="save";
	save.value="Save Note";
	save.id="savenote";
	document.getElementById('sideform').appendChild(save);
}
//If a search was made and was redirected to the only result, display that it was the only result.
function SingleResult(){
	alert("One result found.");
}
</script>
</html>
