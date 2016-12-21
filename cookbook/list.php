<html>
<head>
<link rel="stylesheet" type="text/css" media="screen and (min-device-width: 1000px)" href="cookcss.css">
<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 360px)" href="360px.css">
<title>Shopping List</title>
</head>
<body>
<?php
include 'header.php';
//Prepared
$GetRecipes = $pdo->prepare("SELECT Title FROM Recipe WHERE ID = ? ORDER BY Title");
$GetIngredients = $pdo->prepare("SELECT Name, Amount FROM Ingredient WHERE RecUsed = ?");
//For each previously checked box
echo '<div id="listbuffer"></div>';
echo '<div id="listbody">';
$num = 0;
$num2 = 0;
foreach($_GET['make'] as $ID){
	//Get Recipe Title
	$GetRecipes->execute(array($ID));
	$Recipes = $GetRecipes->fetch(PDO::FETCH_NUM);
	$UpperTitle = ucwords($Recipes[0]);
	//Get Recipe Ingredients
	$GetIngredients->execute(array($ID));
	$Ingredients = $GetIngredients->fetchAll(PDO::FETCH_NUM);
	echo '<h2 class="listheader" style="text-align: center;" id="head';
	echo $num2;
	echo '">';
	echo $UpperTitle;
	echo '</h2>';
        echo '<table class="reclist" id="tab';
	echo $num2;
	echo '">';
	echo '<th>Ingredient</th>';
	echo '<th>Amount</th>';
	echo '<th class="right">Have</th>';
	$num2++;
	//For each recipe ingredient
	foreach($Ingredients as $Ingredient){
		$ing = strtolower($Ingredient[0]);
		if($ing != "water"){
			echo '<tr id="row';
			echo $num;
			echo '">';
			echo '<td class="left">';
			echo $Ingredient[0];
			echo '</td>';
                	echo '<td>';
			echo $Ingredient[1];
                	echo '</td>';
                	echo '<td class ="right">';
		        echo '<input type="checkbox" name="have[]" id="checkb';
			echo $num;
			echo '">';
		        echo '<label for="checkb';
		        echo $num;
		        echo '"><span></span></label>';
			$num++;
              		echo '</td>';
			echo '</tr>';
		}
	}
	echo '</table>';
}
echo '<div id="listend">';
echo '<input type="button" id="clearlist" value="Clear Checked" onClick="RemoveRows();">';
echo '<a href="index.php" id="donelist">Done Shopping</a>';
echo '</div>';
echo '</div>';
?>
<script>
function RemoveRows(){
        var length = <?php echo json_encode($num); ?>;
	var tablenums = <?php echo json_encode($num2); ?>;
	for(i=0; i<length; i++){
		var rowID = "row" + i;
		var haveID = "checkb" + i;
		//Check if ID exists and is checked
		if(document.getElementById(rowID) && document.getElementById(haveID).checked){
			document.getElementById(rowID).parentNode.removeChild(document.getElementById(rowID));
		}
	}
	for(x=0; x<tablenums; x++){
		var tabID = "tab" + x;
		var headID = "head" + x;
		//If no more rows in table, remove header and table
		if(document.getElementById(tabID) && document.getElementById(tabID).rows.length == 1){
			document.getElementById(tabID).parentNode.removeChild(document.getElementById(tabID));
			document.getElementById(headID).parentNode.removeChild(document.getElementById(headID));
		}
	}
	//Return to index if no more remaining ingredients listed
	if(document.getElementById("listbody").children.length == 1){
		window.location="index.php";
	}
	document.body.scrollTop = document.documentElement.scrollTop = 0;
}
</script>
</body>
</html>
