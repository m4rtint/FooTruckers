<!DOCTYPE HTML>
<!--
	Dopetrope 2.5 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		
		<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
		<title>Where My Noms At</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900,300italic" rel="stylesheet" />
		<script src="http://wheremynomsat.com/js/jquery.min.js"></script>
		<script src="http://wheremynomsat.com/js/jquery.dropotron.min.js"></script>
		<script src="http://wheremynomsat.com/js/config.js"></script>
		<script src="http://wheremynomsat.com/js/skel.min.js"></script>
		<script src="http://wheremynomsat.com/js/skel-panels.min.js"></script>
		
			<link rel="stylesheet" href="http://wheremynomsat.com/css/skel-noscript.css" />
			<link rel="stylesheet" href="http://wheremynomsat.com/css/style.css" />
			<link rel="stylesheet" href="http://wheremynomsat.com/css/style-desktop.css" />
			
		<!--[if lte IE 8]><script src="http://wheremynomsat.com/js/html5shiv.js"></script><link rel="stylesheet" href="http://wheremynomsat.com/css/ie8.css" /><![endif]-->
		
		

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpDWib2HUkcAdUgBE3SGnCXHaQsw-aX8w&sensor=false"></script>
		<!--script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script-->
		<script type="text/javascript">
     	
	     	var map;
	     	var markersPost = [];
	     	var infoWindow;
	     	function load() {
	        	
	     		// Center map's focus to Vancouver, BC
	        	var mapOptions = new google.maps.LatLng(49.282667, -123.122144);
	        	map = new google.maps.Map(document.getElementById("map-canvas"), {
	        		center: mapOptions,
	        		zoom: 15
	      		});
	      		infoWindow = new google.maps.InfoWindow();
	      		

	      		/*
				| Passing in XML generating script, and callback function
				| that contains all the "marker" elements in the XML
	      		*/
	      		
	        	downloadUrl("http://wheremynomsat.com/vendor/vendormap", function(data) { // NEED TO CHANGE
			        
	        		parseXMLtoMap(data);

			      });
	        }

	        // Method to parse xml file and get places on the google map
	        function parseXMLtoMap(data) {

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

                    
                    // Getting the placemarkers from phpMyAdmin
			        var markers = xmlDoc.documentElement.getElementsByTagName("marker");
		        
			       
			        for (var i = 0; i < markers.length; i++) {

						var name = markers[i].getAttribute("name");
						var address = markers[i].getAttribute("address");

						var xmlLat = markers[i].getAttribute("lat");
						var xmlLong = markers[i].getAttribute("lng");
						

						var point = new google.maps.LatLng(
							parseFloat(xmlLat),
							parseFloat(xmlLong));


						createMarker(point, name, address);
			        }
	        }


	       	/*
	        | Clear and remove markers by setting their map property to null
	        */
	        function clearLocations() {
	        	infoWindow.close();
	        	
	        	for(var i = 0; i < markersPost.length; i++) {
	        		markersPost[i].setMap(null);
	        	}
	        	markersPost.length = 0;	
	        }


	        /*
	        | General search location method
	        */
	        function searchLocations() {
				var address = document.getElementById("addressInput").value;
				var geocoder = new google.maps.Geocoder();
				var searchMapOpt = document.getElementById('optionSelect').value;

				// Case where user enters input with vendor name
				if(searchMapOpt == "nomName") {
					searchLocationName(address, searchMapOpt);
				}
				// Cases where user enters input of address
				else {
					geocoder.geocode({address: address}, function(results, status) {
				   	if (status == google.maps.GeocoderStatus.OK) {
				    	searchLocationsNear(results[0].geometry.location);
				   	} else {
				    	alert(address + ' not found');
					}

					});
				}	
			}

			/*
			| Search method for vendor's name
			*/
			function searchLocationName(address, searchMapOpt) {
				clearLocations();
				var searchMapUrl;
				var searchTableUrl;
				
				// URL for searchMap.php
				searchMapUrl = 'http://wheremynomsat.com/searchMap.php?lat=' + 0 + '&lng=' + 0 + '&radius=' + address + '&opt=' + searchMapOpt;
				
				address = address.split(' ').join('_');
				// URL for searchTable.php
				searchTableUrl = 'http://wheremynomsat.com/vendor/searchVendorTable?lat=' + 0 + '&lng=' + 0 + '&radius=' + address + '&opt=' + searchMapOpt;
				
				downloadUrl(searchMapUrl, function(data) {

					parseXMLtoMap(data); // Parsing XML to display places in Google Map
					
			    });

			    $("#tableContent").load(searchTableUrl); // Re-load the table with search results
			}

			/*
			| Search method for vendor's address and nearby vendors (within 1km)
			*/
			function searchLocationsNear(center) {
				clearLocations();

				var searchMapOpt = document.getElementById('optionSelect').value;
				var radius;
				var searchMapUrl;
				var searchTableUrl;
				

				if(searchMapOpt == "exact") { //search for exact address
					radius = 0.05;
					// URL for map
					searchMapUrl = 'http://wheremynomsat.com/searchMap.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&opt=' + searchMapOpt;
					
					// URL for table
					searchTableUrl = 'http://wheremynomsat.com/vendor/searchVendorTable?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&opt=' + searchMapOpt;
				}
				else if(searchMapOpt == "nearby") { //search for nearby vendors
					radius = 1;
					
					// URL for map
					searchMapUrl = 'http://wheremynomsat.com/searchMap.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&opt=' + searchMapOpt;
					
					// URL for table
					searchTableUrl = 'http://wheremynomsat.com/vendor/searchVendorTable?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&opt=' + searchMapOpt;
				}

				downloadUrl(searchMapUrl, function(data) {

					parseXMLtoMap(data); // Reload google map with search results
					
			    });

				// Re-load table content with search results
			    $("#tableContent").load(searchTableUrl);
			}

	        /*
	        | Creating the place markers themselves and put them into markerPost array
	        */
	        function createMarker(point, name, address) {
			    var html = "<b>" + name + "</b> <br/>" + address;
			    var marker = new google.maps.Marker({
			        map: map,
			        position: point
			    });
			    google.maps.event.addListener(marker, 'click', function() {
			    	infoWindow.setContent(html);
			      	infoWindow.open(map, marker);
			    });
			    markersPost.push(marker);
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
		      //request.setRequestHeader("Content-type", "text/xml");
		      request.send(null);
		    }

		    function doNothing() {}

    	</script>
	</head>
	<body class="no-sidebar" onload="load()">

		<!-- Header Wrapper -->
			<div id="header-wrapper">
				<div class="container">
					<div class="row">
						<div class="12u">
						
							<!-- Header -->
								<section id="header">
									
									<!-- Logo -->
										<h1><img src="http://wheremynomsat.com/images/logo4.png"/></h1>
									
									<!-- Nav -->
										<nav id="nav">
											<ul>@if(Session::has('global'))
												{{ Session::get('global') }}
												@endif
												@include('layout.navigation')
											</ul>
										</nav>

								</section>

						</div>
					</div>
				</div>
			</div>
		
		<!-- Main Wrapper -->
		@if(Request::url()=='http://wheremynomsat.com/table'||
			Request::url()=='http://wheremynomsat.com/favourite')
			<div id="main-wrapper" style=" padding: 0em 0 0em 0">
		@else
			<div id="main-wrapper">
		@endif
				<div class="12u">	
					<!-- Portfolio -->
						<section>
							<div>
								<div class="row">
									<div class="12u skel-cell-important">
												
											<!-- Content -->
											
										@yield('content')
													
									</div>
								</div>
							</div>
						</section>
				</div>
			</div>
	</body>
</html>