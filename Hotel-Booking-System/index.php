<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['status'])) {
    $_SESSION['user_id'] = 15;
    $_SESSION['name'] = 'user123';
    $_SESSION['email'] = 'user111@gmail.com';
    $_SESSION['role'] = 'user';
    $_SESSION['status'] = 'login';
}

$isLoggedIn = isset($_SESSION['status']) && $_SESSION['status'] === 'login';
$userName = $isLoggedIn ? ($_SESSION['name'] ?? '') : '';
?>
    <!-- HEAD tetap sama -->
	
	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="colorlib">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>Travel</title>

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/jquery-ui.css">				
			<link rel="stylesheet" href="css/nice-select.css">							
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">				
			<link rel="stylesheet" href="css/main.css">
		</head>
		
		<body>	
			<header id="header">
				<div class="header-top">
					<div class="container">
			  		<div class="row align-items-center">
			  			<div class="col-lg-6 col-sm-6 col-6 header-top-left">
			  				<ul>
			  					<li><a href="#">Visit Us</a></li>
			  					<li><a href="#">Buy Tickets</a></li>
			  				</ul>			
			  			</div>
			  			<div class="col-lg-6 col-sm-6 col-6 header-top-right">
							<div class="header-social">
								<a href="#"><i class="fa fa-facebook"></i></a>
								<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-dribbble"></i></a>
								<a href="#"><i class="fa fa-behance"></i></a>
							</div>
			  			</div>
			  		</div>			  					
					</div>
				</div>
				<div class="container main-menu">
					<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.php"><img src="img/logo.png" alt="" title="" /></a>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <li><a href="../Hotel-Booking-System/index.php">Home</a></li>
				          <li><a href="hotels.php">Hotels</a></li>
				          <?php if ($isLoggedIn): ?>
                        	<li><a href="booking-history.php">History</a></li>	          					          		          
							<li class="menu-has-children">
								<a href="">
									<i class="fa fa-user-circle"></i> <?php echo htmlspecialchars($userName); ?>
								</a>
								<ul>
									<li><a href="../functions/logout.php">Log Out</a></li>
								</ul>
							</li>
						<?php else: ?>
							<li><a href="#" onclick="openLoginModal(); return false;">Login</a></li>
						<?php endif; ?>
				        </ul>
				      </nav><!-- #nav-menu-container -->					      		  
					</div>
				</div>
			</header><!-- #header -->
			
			<!-- start banner Area -->
			<section class="banner-area relative">
				<div class="overlay overlay-bg"></div>				
				<div class="container">
					<div class="row fullscreen align-items-center justify-content-between">
						<div class="col-lg-6 col-md-6 banner-left">
							<h6 class="text-white">YOUR JOURNEY STARTS HERE</h6>
							<h1 class="text-white">TRAVEL EASY</h1>
							<p class="text-white">
								Plan your trip with ease and comfort. Compare hotels, check availability, and book your perfect stay in minutes.
							</p>
							<a href="#" class="primary-btn text-uppercase">Get Started</a>
						</div>
						<div class="col-lg-4 col-md-6 banner-right">
							<ul class="nav nav-tabs" id="myTab" role="tablist">	
							</ul>
							<div class="tab-content" id="myTabContent">
							  <div class="tab-pane fade show active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
								<form class="form-wrap">
									<input type="text" class="form-control" id="destinationInput" name="destination" placeholder="Destination" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Destination'" data-toggle="modal" data-target="#destinationModal" readonly>									
									<input type="text" class="form-control date-picker" name="start" placeholder="Start " onfocus="this.placeholder = ''" onblur="this.placeholder = 'Start '">
									<input type="text" class="form-control date-picker" name="return" placeholder="Return " onfocus="this.placeholder = ''" onblur="this.placeholder = 'Return '">
									<input type="number" min="1" max="20" class="form-control" name="adults" placeholder="Adults " onfocus="this.placeholder = ''" onblur="this.placeholder = 'Adults '">
									<input type="number" min="1" max="20" class="form-control" name="child" placeholder="Child " onfocus="this.placeholder = ''" onblur="this.placeholder = 'Child '">						
									<a href="hotels.php" class="primary-btn text-uppercase">Search Hotels</a>									
								</form>							  	
							  </div>
							</div>
						</div>
						<div class="modal fade" id="destinationModal" tabindex="-1" role="dialog" aria-labelledby="destinationModalLabel" aria-hidden="true">
  							<div class="modal-dialog" role="document">
    							<div class="modal-content">
      								<div class="modal-header">
       								<h5 class="modal-title" id="destinationModalLabel">Mau pergi ke mana?</h5>
        							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          								<span aria-hidden="true">&times;</span>
        								</button>
      								</div>
      							<div class="modal-body">
									<h6>Popular Destination</h6>
									<div class="destination-list">
										<div class="destination-item" data-destination="Ubud, Indonesia">
											<strong>Jakarta</strong>
											<span>Indonesia</span>
										</div>
										<div class="destination-item" data-destination="Jakarta, Indonesia">
											<strong>Bali</strong>
											<span>Indonesia</span>
										</div>
										<div class="destination-item" data-destination="Kuta, Indonesia">
											<strong>Surabaya</strong>
											<span>Indonesia</span>
										</div>
										<div class="destination-item" data-destination="Singapore">
											<strong>Bandung</strong>
											<span>Indonesia</span>
										</div>
        							</div>
      							</div>
    							</div>
  							</div>
						</div>
					</div>
				</div>					
			</section>
			<!-- End banner Area -->

			<!-- start footer Area -->		
			<footer class="footer-area section-gap">
				<div class="container">

					<div class="row">
						<div class="col-lg-3  col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>About Agency</h6>
								<p>
									The world has become so fast paced that people don’t want to stand by reading a page of information, they would much rather look at a presentation and understand the message. It has come to a point 
								</p>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>Navigation Links</h6>
								<div class="row">
									<div class="col">
										<ul>
											<li><a href="#">Home</a></li>
											<li><a href="#">Feature</a></li>
											<li><a href="#">Services</a></li>
											<li><a href="#">Portfolio</a></li>
										</ul>
									</div>
									<div class="col">
										<ul>
											<li><a href="#">Team</a></li>
											<li><a href="#">Pricing</a></li>
											<li><a href="#">Blog</a></li>
											<li><a href="#">Contact</a></li>
										</ul>
									</div>										
								</div>							
							</div>
						</div>							
						<div class="col-lg-3  col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>Newsletter</h6>
								<p>
									For business professionals caught between high OEM price and mediocre print and graphic output.									
								</p>								
								<div id="mc_embed_signup">
									<form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscription relative">
										<div class="input-group d-flex flex-row">
											<input name="EMAIL" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
											<button class="btn bb-btn"><span class="lnr lnr-location"></span></button>		
										</div>									
										<div class="mt-10 info"></div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-lg-3  col-md-6 col-sm-6">
							<div class="single-footer-widget mail-chimp">
								<h6 class="mb-20">InstaFeed</h6>
								<ul class="instafeed d-flex flex-wrap">
									<li><img src="img/i1.jpg" alt=""></li>
									<li><img src="img/i2.jpg" alt=""></li>
									<li><img src="img/i3.jpg" alt=""></li>
									<li><img src="img/i4.jpg" alt=""></li>
									<li><img src="img/i5.jpg" alt=""></li>
									<li><img src="img/i6.jpg" alt=""></li>
									<li><img src="img/i7.jpg" alt=""></li>
									<li><img src="img/i8.jpg" alt=""></li>
								</ul>
							</div>
						</div>						
					</div>

					<div class="row footer-bottom d-flex justify-content-between align-items-center">
						<p class="col-lg-8 col-sm-12 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
						<div class="col-lg-4 col-sm-12 footer-social">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
			</footer>

			<!-- Login Modal Overlay -->
			<div id="loginModal" class="login-modal-overlay" style="display:none;">
				<div class="login-modal-card">
					<span class="modal-close" onclick="closeLoginModal()">&times;</span>
					
					<div class="login-header">
						<h3>Login</h3>
					</div>
					
					<?php if (isset($_GET['login']) && $_GET['login'] == 'failed'): ?>
					<div class="alert alert-danger">
						Invalid username or password!
					</div>
					<?php endif; ?>

					<form action="/HotelBookingArchive/functions/login.php" method="POST">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" name="name" id="username" placeholder="Enter Username" required>
						</div>
						
						<div class="form-group">
							   <label for="password_hash" class="form-label">Password</label>
            					<input type="password" class="form-control" name="password_hash" id="password_hash" placeholder="Enter password">
         				</div>

						<button type="submit" class="btn-login">LOGIN</button>
					</form>

					<div class="login-footer">
						<p>Don't have an account? <a href="../register.php">Register here</a></p>
					</div>
				</div>
			</div>

			<!-- End footer Area -->	

			<script src="js/vendor/jquery-2.2.4.min.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/vendor/bootstrap.min.js"></script>			
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>		
 			<script src="js/jquery-ui.js"></script>					
  			<script src="js/easing.min.js"></script>			
			<script src="js/hoverIntent.js"></script>
			<script src="js/superfish.min.js"></script>	
			<script src="js/jquery.ajaxchimp.min.js"></script>
			<script src="js/jquery.magnific-popup.min.js"></script>						
			<script src="js/jquery.nice-select.min.js"></script>					
			<script src="js/owl.carousel.min.js"></script>							
			<script src="js/mail-script.js"></script>	
			<script src="js/main.js"></script>	
		</body>
	</html>