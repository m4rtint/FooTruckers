<?php

$user = 'footrux_noms';
$pass = 'pL2-#PZgKI79';
$db = 'footrux_vendors';

$db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");

$ajax_var1 = $_POST['value'];
$ajax_var2 = $_POST['address'];
$ajax_var3 = $_POST['userName'];

//mysqli_query($db,"UPDATE vendors SET RatingNum = 9 WHERE address = '400 Burrard St Vancouver BC' ");
//mysqli_query($db,"INSERT INTO hithere_vendors (id,name) VALUES (12345,'hellothere')");

$result = mysqli_query($db,"SELECT * FROM  vendors WHERE  address = '{$ajax_var2}' ");
$row = mysqli_fetch_array($result);

//Increment Number of votes
$NumofVotes = $row[RatingNum]+1;

//Get new Total Number sum of votes 1*x+2*y+....
$TotSum = $row[RatingSum]+$ajax_var1;

//Get New Average of Votes dividing total sum by votes
$newAverage = $TotSum/$NumofVotes;

//Update everything
mysqli_query($db,"UPDATE vendors SET RatingAvg={$newAverage}, RatingSum={$TotSum},RatingNum={$NumofVotes} WHERE address='{$ajax_var2}'");
//===========================================
//Update user's Stuff
$queryAddress = mysqli_query($db,"SELECT * FROM {$ajax_var3}_vendors WHERE address='{$ajax_var2}' ");
$arrayAddress = mysqli_fetch_array($queryAddress);


if($arrayAddress != null)
mysqli_query($db,"UPDATE {$ajax_var3}_vendors SET rating= {$ajax_var1} WHERE address= '{$ajax_var2}' ");

else{
//Grab all the information from ONE ROW of the vendors table to insert into user table
$queryRow = mysqli_query($db,"SELECT * FROM vendors WHERE address='{$ajax_var2}' ");
$vendorRow = mysqli_fetch_array($queryRow);

//Insert new entry into vendor table.
mysqli_query($db,"INSERT INTO {$ajax_var3}_vendors (id, name, address, lat, lng, rating) VALUES ({$vendorRow['id']},'{$vendorRow['name']}','{$ajax_var2}',{$vendorRow['lat']},{$vendorRow['lng']},{$ajax_var1})");

}


?>