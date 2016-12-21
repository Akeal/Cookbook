<html>
<head><link rel="shortcut icon" href="baseimages/favicon.ico" type="image/x-icon"/></head>
<form action="searchres.php" method="get" onsubmit="SearchClear();">
<header id="banner">

<div id="headertop">
<a href="index.php" id="cookbooklink" class="headlink">Cookbook</a>
<a href="index.php"><img src="baseimages/Cookbookimg.png" id="cookbookimage"></a>

<a href="listgen.php" id="listlink" class="headlink">Shopping List</a>
<a href="listgen.php"><img src="baseimages/listimage.png" id="listimg"></a>

<a href="cookinsert.php" id="addlink" class="headlink">Add Recipe</a>
<a href="cookinsert.php"><img src="baseimages/insertrecipeimg.png" id="insertimage"></a>
</div>

<div id="searchdiv">
<input type="text" name="search" id="searchbox" value="Search" onfocus="SearchClear(); SetSearchImgA();" onblur="MakeSearch();SetSearchImgB();"'>
<input type="image" src="baseimages/search1.png" name="subsearch" id="subsearch">
</div>

</header>
</form>
<?php
$user = 'INSERTYOURS';
$pass = 'INSERTYOURS';
$dsn = 'INSERTYOURS';
$pdo = new PDO($dsn, $user, $pass);
?>
<script>
//Clear search when clicked if default value
function SearchClear(){
	var search = document.getElementById('searchbox');
	if(search.value == search.defaultValue){
		search.value = '';
	}
}

function MakeSearch(){
	var search = document.getElementById('searchbox');
	if(search.value == ''){
		search.value = search.defaultValue;
	}
}
//Highlight imaege blue on click
function SetSearchImgA(){
	var img = document.getElementById('subsearch');
	img.src="baseimages/search2.png";
}
//Set image back to normal on loss of focus
function SetSearchImgB(){
        var img = document.getElementById('subsearch');
        img.src="baseimages/search1.png";
}
</script>
</body>
</html>
