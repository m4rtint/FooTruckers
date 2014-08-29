<?php
$id = $_GET['id'];
$username=$_GET['acc'];

$con=mysqli_connect("","footrux_noms","pL2-#PZgKI79", "footrux_vendors");
$sql="SELECT * FROM vendors WHERE id=".$id."; ";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result))
{
	$name = $row['name'];
	$add = $row['address'];
	$lat = $row['lat'];
	$lng = $row['lng'];
}	   

// Check if the vendor is already listed in the user_vendors list.
$userResult = mysqli_query($con, "SELECT * FROM ". $username. "_vendors WHERE id =". $id);
if (mysqli_num_rows($userResult) == 1)
{
	$sql1="UPDATE ". $username. "_vendors SET fav = 1 WHERE id = ".$id;
	mysqli_query($con, $sql1);
}


else // If vendor not found in user_vendors table, Write into user's favorite table
{
	$sql2="INSERT INTO ". $username. "_vendors (id, name, address, lat, lng, fav) VALUES ('".$id."', '".$name."', '".$add."', ".$lat.", ".$lng.", 1);";
	mysqli_query($con, $sql2);
}



// Connection close
mysqli_close($con);
?>