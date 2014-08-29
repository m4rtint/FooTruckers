<?php

$kmzurl = $_REQUEST['url'];
$data = file_get_contents($kmzurl); // url of the KMZ file
file_put_contents("/tmp/kmz_temp",$data);
ob_start();
passthru('unzip -p /tmp/kmz_temp');
$xml_data = ob_get_clean();
header("Content-type: text/xml");
$xml = new SimpleXMLElement($xml_data);
//All placemark values are in here
$value = $xml->Document->Folder->Placemark;

//Create first multi array here (Att = Attributes)
$Att = array();

//Create array for each attribute
$Names = array();
$Address = array();
$Lat = array();
$Long = array();

//=============Parsing into multi dimensional array here==================

function parseName(){
//Filled with placemark
global $value;

//multi dimensional array
global $Att;

 //Each attribute;
global $Names;
global $Address;
global $Lat;
global $Long;
 
//Index for each place.
$x=0;
  
  foreach($value as $place)
  {
	//Extracting only the address, not the redundant data.
	$VanBClen = strpos($place->description,"Vancouver BC")+12;
	$propAddress =substr($place->description,0,$VanBClen);
	
	//Splitting the Lat Long from one String into two vars.
	$inputString = $place->Point->coordinates;
	$str_explode = explode(",",$inputString);
	$Latitutde = $str_explode[0];
	$Longitude = $str_explode[1];
	
	//Extract all the Proper places w/out hotdog stands.
    if(!(strcmp($place->name,null) == 0 || strcmp($place->name,"Hot Dogs") == 0))
    {
	
	//Extract names into $Name array
	$Name[$x] = $place->name;
	
	//Extract Address into $Address array
	$Address[$x] = $propAddress;
	
	//Extract Latitude into $Lat array
	$Lat[$x] = $Latitutde;
	
	//Extract Longitude into $Long array
	$Long[$x] = $Longitude;
	
    $x++;
    }
	
  }
  //Put each attribute array into the multidimensional array.
  	$Att[0] = $Name;
	$Att[1] = $Address;
	$Att[2] = $Lat;
	$Att[3] = $Long;
  
}

parseName();

//Demo print the multi array
function printall()
{
global $Att;
for($y=0; $y < count($Att[0]); $y++)
{
echo "Name :",$Att[0][$y], "<br />";
echo "Address :",$Att[1][$y], "<br />";
echo "Lat :", $Att[2][$y], "<br />";
echo "Long :", $Att[3][$y], "<br />";
echo "<br />";
}
}

function SendtoSQL()
{
$user = 'footrux_noms';
$pass = 'pL2-#PZgKI79';
$db = 'footrux_vendors';
global $Att;

$db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");

for($y=0; $y < count($Att[0]); $y++)
{

mysqli_query($db,"INSERT INTO `vendors` (`name`, `address`, `lat`, `lng`) 
VALUES ('{$Att[0][$y]}', '{$Att[1][$y]}', '{$Att[2][$y]}', '{$Att[3][$y]}')");

}
}

SendtoSQL();
mysqli_close($con);
?>

