<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
		<title>Where My Noms At</title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900,300italic" rel="stylesheet" />
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/config.js"></script>
		<script src="js/skel.min.js"></script>
		
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		
		<style type="text/css">
			html { height: 100% }
      		body { 
      			height: 100%; 
      			margin-left: 10px; 
      			padding: 0}
      			
		</style>
	</head>
	
	


<body class="homepage">

		<!-- Header Wrapper -->
			<div id="header-wrapper">
				<div class="container">
					<div class="row">
						<div class="12u">
						
							<!-- Header -->
								<section id="header">
									
									<!-- Logo -->
										<h1><img src="images/logoo.png" alt="" /></h1>
									
									<!-- Nav -->
										<nav id="nav">
											<ul>
												
												@if(Session::has('global'))
												{{ Session::get('global') }}
												@endif
												@include('layout.navigation')
											</ul>
										</nav>

								</section>

						</div>
					</div>
					<div class="row">
						<div class="12u">

							<!-- Banner -->
								<section id="banner">
									<a href="http://www.facebook.com/DreametryDoodle">
										<span class="image image-full"><img src="images/pic01.jpg" alt="" /></span>
										<header>
											<h2>The Place To Satisfy Your Hunger</h2>
											<span class="byline">Street food at your fingertips</span>
										</header>
									</a>
								</section>

						</div>
					</div>
					<div class="row">
						<div class="12u">
								
							<!-- Intro -->
								<section id="intro">
								
									<div>
										<div class="row">
											<div class="4u">
												<section class="first">
													<span class="pennant"><span class="fa fa-cog"></span></span>
													<header>
														<h2>Browse</h2>
													</header>
													<p>Find your favourite Food Truck stands on a beautiful map</p>
												</section>
											</div>
											<div class="4u">
												<section class="middle">
													<span class="pennant pennant-alt2"><span class="fa fa-star"></span></span>
													<header>
														<h2>Favourite</h2>
													</header>
													<p>Create an account and save all the locations of your favourite food truck vendors.</p>
												</section>
											</div>
											<div class="4u">
												<section class="last">
													<span class="pennant pennant-alt"><span class="fa fa-flash"></span></span>
													<header>
														<h2>Share</h2>
													</header>
													<p>Share your favourite places on social media.</p>
												</section>
											</div>
										</div>
									</div>

									
								
								</section>

				
			</div>
</div>		
</body>
</html>