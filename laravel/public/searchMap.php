<?php

/* To create an XML file from phpMyAdmin, 
| so GoogleMap can asynchronously load the content
*/

function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 


// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];
$option = $_GET["opt"];


// Opens a connection to mySQL server
$con=mysqli_connect("","root","root","auth");

// Start XML file, create parent node
// header("Content-type: text/xml");
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


// Search the rows in the vendors table
if($option== "nearby") {
$query = sprintf("SELECT address, name, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lng ) ) * cos( radians( lat ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lng ) ) ) ) AS distance FROM vendors HAVING distance < '%s' ORDER BY distance LIMIT 0 , 7",
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($center_lng),
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($radius));
$result = mysqli_query($con, $query);  
}
else if($option == "exact") {
$query2 = sprintf("SELECT address, name, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lng ) ) * cos( radians( lat ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lng ) ) ) ) AS distance FROM vendors HAVING distance < '%s' ORDER BY distance LIMIT 0 , 1",
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($center_lng),
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($radius));
$result = mysqli_query($con, $query2);  
}
else if($option == "nomName") { // A bit buggy
$query3 = "SELECT address, name, lat, lng FROM vendors WHERE name LIKE '%$radius%'";
$result = mysqli_query($con, $query3);
}



if (!$result) {
  die("Invalid query: " . mysql_error());
}


// Iterate through the rows, adding XML nodes for each
echo '<markers>';
// Iterate through the rows, adding XML nodes for each
while ($row = mysqli_fetch_array($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'name="' . parseToXML($row['name']) . '" ';
  echo 'address="' . parseToXML($row['address']) . '" ';
  echo 'lat="' . $row['lat'] . '" '; // Switched from original <---------------WHEN GO LIVE
  echo 'lng="' . $row['lng'] . '" ';
  echo 'distance="' . $row['distance'] . '" ';
  echo '/>';
  
}

echo '</markers>';





/*function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 


// Select all the rows in the markers table
$markers = Vendor::all();
header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
foreach($markers as $marker) {
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'name="' . parseToXML($marker->name) . '" ';
  echo 'address="' . parseToXML($marker->address) . '" ';
  echo 'lat="' . $marker->lat . '" ';
  echo 'lng="' . $marker->lng . '" ';
  
  echo '/>';
}

// End XML file
echo '</markers>';
*/
?>