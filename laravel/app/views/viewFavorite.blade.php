@extends('layout.temp')
@section('content')



<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="js/star-rating.js" type="text/javascript"></script>



<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],
	p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);
		js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
</script>



<script>
 function addFav(id,userid)
 {
 var link = "http://wheremynomsat.com/addFavorite.php?id=" + id + "&acc=" + userid;
 window.open(link,"favRef");
 
 var inputToChange = document.getElementsByName("favBut" + id);
 inputToChange[0].src ="/images/heart_like.png";
 inputToChange[0].onclick = function(){delFav(id,userid);};
 }
 
 function delFav(id,userid)
 {
 var link = "http://wheremynomsat.com/delFavorite.php?id=" + id + "&acc=" + userid;
 window.open(link,"favRef");
 
 var inputToChange = document.getElementsByName("favBut" + id);
 inputToChange[0].src ="/images/heart_dis.png";
 inputToChange[0].onclick = function(){addFav(id,userid);};
 }
 </script>
 
	
	
<div id="map-canvas" style="background-color:#777777;float:left; width:70%; height:760px; position:relative; "></div>

<div id="content" style="background-color:#ffffff;width:30%; height:760px ;float:right;background-color: #fff;background-color: rgba(255,255,255,0);overflow-y:scroll" class="image image-full">
<br>

<div id="searchBar" align="right">
<b> Search Noms:</b> <input type='text' id='addressInput'><input type='button' onclick="searchLocations()" value='Search'>
	
	<select id = "optionSelect">
		<option value="nomName" selected>By Nom's name</option>
		<option value="exact" selected>By Nom's address</option>
		<option value="nearby" selected>For nearby Noms</option>
	</select>
</div>

<br>


<div id="tableContent">
<?php
$username=Auth::user()->username;
$con=mysqli_connect("","footrux_noms","pL2-#PZgKI79","footrux_vendors");
$result = mysqli_query($con,"SELECT * FROM ". $username."_vendors WHERE fav = 1");



echo "<hr style=' border: 0;
  width: 95%;               
  background-color:#000000;
  height: 1px;
  opacity:0.08;'>";
while($row = mysqli_fetch_array($result))
	{
 	echo "<h1 style='font-size:150%; text-indent:40px'> <input name=favBut".$row['id']. " type=image align=bottom width=16 height=16 src=\"/images/heart_like.png\" onclick=delFav('". $row['id']. "','". $username."')>  {$row['name']} </h1>";
	echo "<h4 style ='text-indent:40px'> {$row['address']}</h4>";
	//$RoundedAverage = round($row['RatingAvg'],2);
	//echo "<h5 style ='text-indent:40px'> Average Rating: {$RoundedAverage}</h5>";
	
	//Rating Button===================
	if(Auth::check())
	{
	//Grab that one row with the certain address into an array.
	$checkaddress = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM {$username}_vendors WHERE address='{$row['address']}' "));
	//Check if the user has already rated && it's not part of the favourites
	if($checkaddress != null && intval($checkaddress['fav'])==0 && intval($checkaddress['rating']) == 0)
	echo "<form style='text-indent:40px'>
		<input id='{$row['id']}' type='number' class='rating' min='1' max='5' step='1' data-size='xs' data-show-clear='false'>
		</form>";
	if(($checkaddress == null|| intval($checkaddress['fav'])==1) && intval($checkaddress['rating']) == 0)
		{
		echo "<form style='text-indent:40px'>
		<input id='{$row['id']}' type='number' class='rating' min='1' max='5' step='1' data-size='xs' data-show-clear='false'>
		</form>";
		}
		else
		{
		if(intval($checkaddress['rating']) > 0)
		echo "<form style='text-indent:40px'>
		<input id='{$row['id']}' type='number' value='{$checkaddress['rating']}' class='rating' min='1' max='5' step='1' data-size='xs' data-disabled='true' data-show-clear='false'>
		</form>";
		}
		
	
	}
	//For Guest users
	else
	{
	echo "<form style='text-indent:40px'>
	<input id='{$row['id']}' type='number' class='rating' min='1' max='5' step='1' data-size='xs' data-show-clear='false' data-disabled='true'>
	</form>";
	}
	//Twitter button================
	echo "<p style ='text-indent:40px'>";
	echo "<a href='https://twitter.com/intent/tweet?button_hashtag=WhereMyNomsAt&text=Go%20check%20out%20";
	echo $row['name'];
	echo "%20-%20";
	echo $row['address'];
	echo ".' target='_blank' class='twitter-hashtag-button' data-url='http://www.wheremynomsat.com'>
	#WhereMyNomsAt - {$row['name']}
	</a>";
	echo "</p>";
	//====================
	echo "<hr style=' border: 0;
  			width: 95%;               
  			background-color:#000000;
 			 height: 1px;
 			 opacity: 0.08'>";
 	if(Auth::check()){		 
 	echo "<script>

	$('#{$row['id']}').on('rating.change', function(event,value,caption){
		$('#{$row['id']}').rating('refresh', {disabled: true, showClear: false});
		var rateValue = $('#{$row['id']}').val();
		var addressValue = '{$row['address']}';
		var user = '$username';
		
	$.ajax({
		type:'POST',
		url:'rating.php',
		data: 'value='+rateValue+'\u0026address='+addressValue+'\u0026userName='+user,
		success: function(){}
		});
		
	});
	</script>";
	}
	}
mysqli_close($con);


// Temp iframe for favorite refresh..
echo "<iframe name=\"favRef\" width=0, depth=0></iframe>";
?>
</div>
</div>
@stop