<?php
$id = $_GET['id'];
$username=$_GET['acc'];

// Delete entry from user's favorite table
$con=mysqli_connect("","footrux_noms","pL2-#PZgKI79", "footrux_vendors");
$sql="UPDATE ". $username. "_vendors SET fav = 0 WHERE id = ".$id;
$result = mysqli_query($con, $sql);

// Connection close
mysqli_close($con);

// Autoload page. Commented out
// header ("location: http://wheremynomsat.com/favourite");
?>
