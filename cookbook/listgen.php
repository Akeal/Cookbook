<hmtl>
<head>
<link rel="stylesheet" type="text/css" media="screen and (min-device-width: 1000px)" href="cookcss.css">
<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 360px)" href="360px.css">
<title>Select Recipes</title>
</head>
<body>
<?php
include 'header.php';
//Get Recipes
$Prepare = "SELECT Title, ID FROM Recipe ORDER BY Title";
$Execute = $pdo->query($Prepare);
$List = $Execute->fetchAll(PDO::FETCH_NUM);

//Header
echo '<div id="genheaderdiv">';
echo '<h1 class="listheader">Select Recipes to Make</h1>';
echo '</div>';

//Display all recipes with check boxes
echo '<div id="listdiv">';
echo '<form action="list.php" method="get" onSubmit="return Verify();">';
echo '<table id="listgenrecipes" class="reclist">';
echo '<th>Recipe</th>';
echo '<th>Make</th>';
$num = 0;
foreach($List as $Recipe){
	$UpperTitle = ucwords($Recipe[0]);
	echo '<tr>';
	echo '<td class="left">';
	echo $UpperTitle;
	echo '</td>';
	echo '<td class="right">';
	echo '<input type="checkbox" name="make[]" id="check';
	echo $num;
	echo '" value="';
	echo $Recipe[1];
	echo '">';
	echo '<label for="check';
	echo $num;
	echo '"><span></span></label>';
	echo '</td>';
	echo '</tr>';
	$num++;
}
echo '</table>';
echo '<input type="submit" id="sublist" value="Make List">';
echo '</form>';
echo '</div>';
?>
<script>
//Check to make sure at least one recipe is selected
function Verify(){
	var boxes = document.querySelectorAll('input[type="checkbox"]');
	var checked = Array.prototype.slice.call(boxes).some(x => x.checked);
	if(!checked){
		alert("Please select at least one recipe.");
		return false;
	}
}
</script>
</body>
</html>
