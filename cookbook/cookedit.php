<html>
<head>
<title>Add to Cookbook</title>
<link rel="stylesheet" type="text/css" media="screen and (min-device-width: 1000px)" href="cookcss.css">
<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 360px)" href="360px.css">
</head>
<body>
<?php
session_start();
include 'header.php';

/*Prepared*/
$GrabSteps = $pdo->prepare('SELECT Description FROM Step JOIN Recipe ON RecID = ID AND RecID = ?');
$GrabRecipe = $pdo->prepare('SELECT Title, Hours, Minutes, Type, Genre, CalPerServ, NumServ FROM Recipe WHERE ID = ?');
$GrabIngredients = $pdo->prepare('SELECT Name, Amount FROM Ingredient JOIN Recipe ON RecUsed = ID AND RecUsed = ? ORDER BY Priority');
/*Execute*/
$GrabRecipe->execute(array($_SESSION['ID']));
$GrabIngredients->execute(array($_SESSION['ID']));
$GrabSteps->execute(array($_SESSION['ID']));
/*Fetch data needed*/
$Recipe = $GrabRecipe->fetch(PDO::FETCH_NUM);
$Ingredients = $GrabIngredients->fetchAll(PDO::FETCH_NUM);
$Steps = $GrabSteps->fetchAll(PDO::FETCH_NUM);

$itstep = 1;
$itingredient = 1;
echo '<form action="cookedit2.php" name="headform" method="post" onsubmit="return Validate();">';
//Table for Hours, Minutes, Cals/Serv, # of servings
echo '<div id="recinfoinput">';
echo '<table id="recinputtable">';
//Table headers
echo '<th>Title</th>';
echo '<th>Type<br>(Optional)</th>';
echo '<th>Genre<br>(Optional)</th>';
echo '<tr>';
//Recipe Title
echo '<td id="inputtitle" class="left">';
echo '<input type="text" name="title" id="recinputtitle" required maxlength="50" value="';
echo $Recipe[0];
echo '">';
echo '</td>';
//Recipe Type
echo '<td id="typecolumn">';
echo '<input type="text" name="type" maxlength="20" id="typeinput" value="';
echo $Recipe[3];
echo '">';
echo '</td>';
//Recipe Genre
echo '<td id="genrecolumn" class="right">';
echo '<input type="text" name="genre" maxlength="20" id="genreinput"  value="';
echo $Recipe[4];
echo '">';
echo '</td>';
echo '</tr>';
echo '</table>';
//Table for Hours, Minutes, Cals/Serv, # of servings
echo '<table id="recinputtable2">';
//Table headers
echo '<th id="hourhead">Est. #<br>Hours</th>';
echo '<th id="minutehead">Est. #<br>Minutes</th>';
echo '<th id="calhead">Calories/Serving<br>(Optional)</th>';
echo '<th id="servhead"># Servings<br>(Optional)</th>';
echo '</tr>';
//Recipe Hours
echo '<td class="left">';
echo '<input type="text" id="hournum" name="hournum" required onfocus="Clear(this);" onblur="Zero(this);" value="';
echo $Recipe[1];
echo '">';
echo '</td>';
//Recipe Minutes
echo '<td>';
echo '<input type="text" id="minutenum" name="minutenum" required  onfocus="Clear(this);" onblur="Zero(this);" value="';
echo $Recipe[2];
echo '">';
echo '</td>';
//Recipe Calories per Serving
echo '<td>';
echo '<input type="text" id="calperserv" name="calperserv" required onfocus="Clear(this);" onblur="Zero(this);" value="';
echo $Recipe[5];
echo '">';
echo '</td>';
//Recipe Servings
echo '<td id="inputserv" class="right">';
echo '<input type="text" id="numserv" name="numserv" required onfocus="Clear(this);" onblur="Zero(this);" value="';
echo $Recipe[6];
echo '">';
echo '</td>';
echo '</tr>';
echo '</table>';

echo '<div id="ingredientinputdiv">';
echo '<table id="ingredients">';
echo '<th>Ingredient</th>';
echo '<th>Amount</th>';
//Populate existing ingredients
foreach($Ingredients as $Ingredient){
        echo '<tr>';
        echo '<td id="ingredientinput" class="left">';
        echo '<input type="text" maxlength="40" name="ingredientbox[]" id="ingredientbox" required value="';
        echo $Ingredient[0];
        echo '">';
        echo '</td>';
        echo '<td id="amountinput" class="right">';
        echo '<input type="text" maxlength="30" name="amountbox[]" id="amountbox" required value="';
        echo $Ingredient[1];
        echo '">';
        echo '</td>';
        echo '</tr>';
        $itingredient++;
}
echo '</table>';
echo '<input type="button" id="addingredient" value="Add Ingredient" onclick="AddIngredient();">';
echo '<input type="button" id="deleteingredient" value="Delete Ingredient" onclick="DeleteIngredient();">';
echo '</div>';


echo '<div id="stepsinputdiv">';
echo '<table id="steps">';
echo '<th>Step</th>';
echo '<th>Instruction</th>';
//Populate existing steps
foreach($Steps as $Step){
	echo '<tr>';
	echo '<td id = "stepnumber" class="left number">';
	echo $itstep;
	echo '</td>';
	echo '<td id = "whattodo" class="right">';
	echo '<textarea id="inputwhattodo" name="inputwhattodo[]" maxlength="500" required>';
	echo $Step[0];
	echo '</textarea>';
	echo '</td>';
	echo '</tr>';
	$itstep++;
}
echo '</table>';
echo '<input type="button" id="addstep" value="Add Step" onclick="AddStep();">';
echo '<input type="button" id="deletestep" value="Delete Step" onclick="DeleteStep();">';
echo '<input type="submit" name="finalsubmit" value="Save Recipe" id="finalsubmit">';
echo '</div>';
echo '</form>';

?>

<script>
var stepnum = <?php echo $itstep ?>;
var ingredientnum = <?php echo $itingredient ?>;
//Add step when button clicked
function AddStep(){
	var table = document.getElementById("steps");
	var row = table.insertRow(stepnum);
	var number = row.insertCell(0);
	var whattodo = row.insertCell(1);
	number.className='left';
	whattodo.className='right';
	number.innerHTML = '<p style = "margin-left: 25px;">' + stepnum + '</p>';
	whattodo.innerHTML = '<textarea id="inputwhattodo" name="inputwhattodo[]" maxlength="500" required style="border: solid black; width: 25em; height: 4em;  margin-right: 10px; margin-left: 5px; margin-top: 5px; margin-bottom: 5px; resize: none;">';
	stepnum++;
	scrollBy(0,86);
}
//Add ingredient when button clicked
function AddIngredient(){
	var table = document.getElementById("ingredients");
	var row = table.insertRow(ingredientnum);
	var ingredient = row.insertCell(0);
	var amount = row.insertCell(1);
	ingredient.className='left';
	amount.className='right';
	ingredient.innerHTML = '<input type="text" maxlength="80" name="ingredientbox[]" id="ingredientbox" required style="margin-left: 10px; margin-right: 5px; margin-top: 2px; margin-bottom: 2px; border: solid black;">';
	amount.innerHTML = '<input type="text" maxlength="30" name="amountbox[]" id="amountbox" required style="margin-left: 5px; margin-right: 10px; margin-top: 2px; margin-bottom: 2px; border: solid black; width: 10em;">';
	ingredientnum++;
	scrollBy(0,47);
}
//Delete step if there is more than one when button clicked
function DeleteStep(){
	if(stepnum > 2){
		document.getElementById("steps").deleteRow(stepnum-1);
		stepnum--;
	}
}
//Delete ingredient if there is more than one when button clicked
function DeleteIngredient(){
	if(ingredientnum > 2){
		document.getElementById("ingredients").deleteRow(ingredientnum-1);
		ingredientnum--;
	}
}
//Clear default value for user to enter their own
function Clear(field){
	if(field.value == field.defaultValue){
                field.value = '';
        }
}
//If user leaves field empty, set back to default value
function Zero(field){
        if(field.value == ''){
                field.value = field.defaultValue;
        }
}
//Check that all fields have proper values
function Validate(){
	var hourhead = document.querySelector("#hourhead");
	var minhead = document.querySelector("#minutehead");
	var calhead = document.querySelector("#calhead");
	var servhead = document.querySelector("#servhead");
	hourhead.style.color="black";
	minhead.style.color="black";
	calhead.style.color="black";
	servhead.style.color="black";

	var boolean = true;
	var error = "Must use postive integer for: ";

	var hour = Number(document.forms["headform"]["hournum"].value);
	var minute = Number(document.forms["headform"]["minutenum"].value);
	var cals = Number(document.forms["headform"]["calperserv"].value);
	var servs = Number(document.forms["headform"]["numserv"].value);
	if(!Number.isInteger(hour) || hour < 0){
		hourhead.style.color="red";
		boolean = false;
		error = error +  "Hours";
	}
	if(!Number.isInteger(minute) || minute < 0){
		minhead.style.color="red";
		if(boolean == false){
		error = error + ", Minutes";
		}
		else{
		error = error + "Minutes";
		}
		boolean = false;
	}
	if(!Number.isInteger(cals) || cals < 0){
		calhead.style.color="red";
		if(boolean == false){
		error = error + ", Calories/Serving";
		}
		else{
		error = error + "Calories/Serving";
		}
		boolean = false;
	}
	if(!Number.isInteger(servs) || servs < 0){
		servhead.style.color="red";
		if(boolean == false){
		error = error + ", Servings";
		}
		else{
		error = error + "Servings";
		}
		boolean = false;
	}
	if(boolean == false){
		error = error + ".";
		alert(error);
		return false;
	}
	if(servs == 0 && cals != 0){
	var check = confirm("Cannot have 0 servings if there is an amount for Calories/Serving. \nSubmit with number of servings as 1?");
		if(check == false){
			return false;
		}
	document.getElementById('numserv').value = 1;
	}
}
</script>

</body>
</html>
