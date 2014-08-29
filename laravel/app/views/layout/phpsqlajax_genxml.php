<?php

/* To create an XML file from phpMyAdmin, 
| so GoogleMap can asynchronously load the content
*/


// Start XML file, create parent node
header("Content-type: text/xml");
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


// Select all the rows in marker's table 
$markers = Vendor::all();


// Iterate through the rows, adding XML nodes for each
foreach($markers as $marker) { 
	
	// Add to XML Document Node
	$node = $dom->createElement("marker");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("name", $marker->name);
 	$newnode->setAttribute("address", $marker->address);

	//NEED TO FIX THIS
	$newnode->setAttribute("lat", $marker->lat);
	$newnode->setAttribute("lng", $marker->lng);
}

echo $dom->saveXML();





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