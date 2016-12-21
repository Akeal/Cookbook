<html>
<head>
<title>Add to Cookbook</title>
<link rel="stylesheet" type="text/css" media="screen and (min-device-width: 1000px)" href="cookcss.css">
<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 360px)" href="360px.css">
</head>
<body>
<?php
include 'header.php';
//Initialize steps and ingredients
$itstep = 1;
$itingredient = 1;
//Form for data to be submitted
echo '<form action="cookinsert2.php" name="headform" method="post" onsubmit="return Validate();">';
echo '<div id="recinfoinput">';
//Table for Title, Type, Genre
echo '<table id="recinputtable">';
//Table headers
echo '<th>Title</th>';
echo '<th>Type<br>(Optional)</th>';
echo '<th>Genre<br>(Optional)</th>';
echo '<tr>';
//Recipe Title
echo '<td id="inputtitle" class="left">';
echo '<input type="text" name="title" id="recinputtitle" required maxlength="50">';
echo '</td>';
//Recipe Type
echo '<td id="typecolumn">';
echo '<input type="text" name="type" id="typeinput" maxlength="20">';
echo '</td>';
//Recipe Genre
echo '<td id="genrecolumn" class="right">';
echo '<input type="text" name="genre" id="genreinput">';
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
echo '<tr>';
//Recipe Hours
echo '<td class="left">';
echo '<input type="text" id="hournum" name="hournum" value =0 required onfocus="Clear(this);" onblur="Zero(this);">';
echo '</td>';
//Recipe Minutes
echo '<td>';
echo '<input type="text" id="minutenum" name="minutenum" value=0 required  onfocus="Clear(this);" onblur="Zero(this);">';
echo '</td>';
//Recipe Cals/Serving
echo '<td>';
echo '<input type="text" id="calperserv" name="calperserv" value= 0 required onfocus="Clear(this);" onblur="Zero(this);">';
echo '</td>';
//Recipe # of Servings
echo '<td id="inputserv" class="right">';
echo '<input type="text" id="numserv" name="numserv" value= 0 required onfocus="Clear(this);" onblur="Zero(this);">';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</div>';
echo '<div id="ingredientinputdiv">';
echo '<table id="ingredients">';
echo '<th>Ingredient</th>';
echo '<th>Amount</th>';
        echo '<tr>';
        echo '<td id="ingredientinput" class="left">';
        echo '<input type="text" maxlength="80" name="ingredientbox[]" id="ingredientbox">';
        echo '</td>';
        echo '<td id="amountinput" class="right">';
        echo '<input type="text" maxlength="30" name="amountbox[]" id="amountbox">';
        echo '</td>';
        echo '</tr>';
echo '</table>';
echo '<input type="button" id="addingredient" value="Add Ingredient" onclick="AddIngredient();">';
echo '<input type="button" id="deleteingredient" value="Delete Ingredient" onclick="DeleteIngredient();">';
echo '</div>';

echo '<div id="stepsinputdiv">';
echo '<table id="steps">';
echo '<th>Step</th>';
echo '<th>Instruction</th>';
	echo '<tr>';
	echo '<td id = "stepnumber" class="left number">';
	echo $itstep;
	echo '</td>';
	echo '<td id = "whattodo" class="right">';
	echo '<textarea id="inputwhattodo" name="inputwhattodo[]" maxlength="500" required></textarea>';
	echo '</td>';
	echo '</tr>';
echo '</table>';
echo '<input type="button" id="addstep" value="Add Step" onclick="AddStep();">';
echo '<input type="button" id="deletestep" value="Delete Step" onclick="DeleteStep();">';
echo '<input type="submit" name="finalsubmit" value="Submit Recipe" id="finalsubmit">';
echo '</div>';
echo '</form>';

?>

<script>
var stepnum = 2;
var ingredientnum = 2;

//Add new step when button clicked
function AddStep(){
	var table = document.getElementById("steps");
	var row = table.insertRow(stepnum);
	var number = row.insertCell(0);
	var whattodo = row.insertCell(1);
	number.className='left';
	whattodo.className='right';
	number.innerHTML = '<p class="left number">' + stepnum + '</p>'
	whattodo.innerHTML = '<textarea id="inputwhattodo" name="inputwhattodo[]" maxlength="500" required>';
	stepnum = stepnum + 1;
	scrollBy(0,86);
	document.getElementById(stepnum).focus();
}
//Add new ingredient when button clicked
function AddIngredient(){
	var table = document.getElementById("ingredients");
	var row = table.insertRow(ingredientnum);
	var ingredient = row.insertCell(0);
	var amount = row.insertCell(1);
	ingredient.className='left';
	amount.className='right';
	ingredient.innerHTML = '<input type="text" maxlength="80" name="ingredientbox[]" id="ingredientbox" required>';
	amount.innerHTML = '<input type="text" maxlength="30" name="amountbox[]" id="amountbox" required>';
	ingredientnum = ingredientnum + 1;
	scrollBy(0,47);
}
//Delete step if more than 1
function DeleteStep(){
	if(stepnum > 2){
		document.getElementById("steps").deleteRow(stepnum-1);
		stepnum = stepnum - 1;
	}
}
//Delete ingredient if more than 1
function DeleteIngredient(){
	if(ingredientnum > 2){
		document.getElementById("ingredients").deleteRow(ingredientnum-1);
		ingredientnum = ingredientnum - 1;
	}
}
//Clear default value for user when clicked
function Clear(field){
	if(field.value == field.defaultValue){
                field.value = '';
        }
}
//If field left blank, reset to default
function Zero(field){
        if(field.value == ''){
                field.value = field.defaultValue;
        }
}
//Make sure all values are valid
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
	var error = "Must use positive integer for: ";

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
