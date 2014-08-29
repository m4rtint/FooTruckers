<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
		<title>Where My Noms At</title>
		
		<style type="text/css">
			html { height: 100% }
      		body { 
      			height: 100%; 
      			margin-left: 10px; 
      			padding: 0}
      			
		</style>

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpDWib2HUkcAdUgBE3SGnCXHaQsw-aX8w&sensor=false"></script>
		<!--script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script-->
		<script type="text/javascript">
     	
	     	var map;
	     	function load() {
	        	
	     		// Center map's focus to Vancouver, BC
	        	var mapOptions = new google.maps.LatLng(49.282667, -123.122144);
	        	map = new google.maps.Map(document.getElementById("map-canvas"), {
	        		center: mapOptions,
	        		zoom: 15
	      		});
	      		var infoWindow = new google.maps.InfoWindow();
	      		

	      		/*
				| Passing in XML generating script, and callback function
				| that contains all the "marker" elements in the XML
	      		*/
	      		console.log("entering download URL");
	        	downloadUrl("http://wheremynomsat.com/vendor/vendormap", function(data) { // NEED TO CHANGE
			        
	        		console.log("entered download URL");
			        var xml = data.responseText;


                    // remove whitespaces from start and end (.trim() doesnt work)
                    xml = xml.replace(/^\s+|\s+$/g,'');                 

                    // manually parse to XML DOM object 
                    var parser = new DOMParser();                   
                    var xmlDoc;                 
                       try {
                            xmlDoc = parser.parseFromString(xml, "text/xml");
                        } catch (e) {
                            alert ("XML parsing error.");
                            return false;
                        };

                    /*
                    | Getting the placemarkers from phpMyAdmin
                    */
			        var markers = xmlDoc.documentElement.getElementsByTagName("marker");
		        
			       
			        for (var i = 0; i < markers.length; i++) {

						var name = markers[i].getAttribute("name");
						var address = markers[i].getAttribute("address");

						var xmlLat = markers[i].getAttribute("lat");
						var xmlLong = markers[i].getAttribute("lng");
						

						var point = new google.maps.LatLng(
							parseFloat(xmlLat),
							parseFloat(xmlLong));

						var html = "<b>" + name + "</b> <br/>" + address;

						var marker = new google.maps.Marker({
			            	map: map,
			            	position: point,
			            });

			          	bindInfoWindow(marker, map, infoWindow, html);
			        }
			      });
	        }

	      	/*
	      	| Function to provide text and/or images on the popup window
	      	*/
	      	function bindInfoWindow(marker, map, infoWindow, html) {
      			google.maps.event.addListener(marker, 'click', function() {
        		infoWindow.setContent(html);
        		infoWindow.open(map, marker);
      			});
    		}
	      	
	   
	      	/*
	      	| Function to load the XML file using XMLHttpRequest object
	      	| @param url: specifies path to php generating XML script
	      	| @param callback: function that's called when XML is returned to JavaScript
	      	*/
		    function downloadUrl(url, callback) {
		      var request = window.ActiveXObject ?
		          new ActiveXObject('Microsoft.XMLHTTP') :
		          new XMLHttpRequest;

		      request.onreadystatechange = function() {
		        if (request.readyState == 4) {

		          request.onreadystatechange = doNothing;
		          callback(request, request.status);
		        }
		      };

		      request.open('GET', url, true);
		      request.setRequestHeader("Content-type", "text/xml");
		      request.send(null);
		    }

		    function doNothing() {}

    	</script>
	</head>
	
	
<div id="container" style="width:100%; height:100%">


	<div id="header" style="background-color:#eeeeee">
	<body onload="load()">
	
	<a href="{{ URL::route('home') }}" align="right"><font size = 100; color = black><u><img src="/images/logoo.png"></u></font></a><br><br>
	
		@if(Session::has('global'))
			<p>{{ Session::get('global') }}</p>
		@endif
		@include('layout.navigation')
	<form name='search' align="right" action='#' method='#'> Search Noms: <input type='text' name='vSearch'><input type='submit' value='Search'></form>
	</div>	
	
	<div id="map-canvas" style="background-color:#777777; width:50%; height:100%; float:left;">
	</div>


	<div id="content" style="background-color:#ffffff; width:50%; height:100%; float:right; overflow-y: auto;">
		@yield('content')
	</div>


	<div id="footer" style="background-color:#eeeeee; float:bottom;">
	wheremynomsat.com 2014
	</div>


</div>		
</body>
</html>