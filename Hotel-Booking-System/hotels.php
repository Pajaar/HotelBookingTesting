<?php include __DIR__ . '/../functions/get_hotel.php';
$isLoggedIn = isset($_SESSION['status']) && $_SESSION['status'] === 'login';
$userName = $isLoggedIn ? $_SESSION['name'] : '';?>

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
			<section class="about-banner relative">
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Hotels				
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="hotels.php"> Hotels</a></p>
						</div>	
					</div>
				</div>
			</section>
			<!-- End banner Area -->	

			<!-- Start Filter Area -->
<div class="row mb-4">
    <div class="col-lg-3 filter-sidebar-wrapper">
        <!-- Filter Sidebar -->
        <div class="filter-sidebar">
            <h5>Filter</h5>
            <form id="filterForm" method="GET" action="hotels.php">
            <div class="filter-group">
                <h6>Star Rating</h6>
                <div class="form-check">
                    <input class="form-check-input star-filter" type="checkbox" name="stars[]" id="star5" value="5" <?php echo in_array('5', $starFilter) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="star5">⭐⭐⭐⭐⭐ 5</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input star-filter" type="checkbox" name="stars[]" id="star4" value="4" <?php echo in_array('4', $starFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="star4">⭐⭐⭐⭐ 4</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input star-filter" type="checkbox" name="stars[]" id="star3" value="3" <?php echo in_array('3', $starFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="star3">⭐⭐⭐ 3</label>
                </div>
				<div class="form-check">
                    <input class="form-check-input star-filter" type="checkbox" name="stars[]" id="star2" value="2" <?php echo in_array('2', $starFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="star2">⭐⭐ 2</label>
                </div>
				<div class="form-check">
                    <input class="form-check-input star-filter" type="checkbox" name="stars[]" id="star1" value="1" <?php echo in_array('1', $starFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="star1">⭐ 1</label>
                </div>
            </div>

			<div>
				<h6>Price</h6>
                <div class="form-check">
                    <input class="form-check-input price-filter" type="radio" name="price_sort" id="highest" value="highest" <?php echo $priceSort == 'highest' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="highest">Highest Price</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input price-filter" type="radio" name="price_sort" id="lowest" value="lowest" <?php echo $priceSort == 'lowest' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="lowest">Lowest Price</label>
                </div>
			</div>

            <div class="filter-group">
                <h6>Facilility</h6>
                <div class="form-check">
                    <input class="form-check-input facility-filter" type="checkbox" name="facilities[]" id="swimming_pool" value="swimming_pool" <?php echo in_array('swimming_pool', $facilityFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="swimming_pool">Swimming Pool</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input facility-filter" type="checkbox" name="facilities[]" id="gymnasium" value="gymnasium" <?php echo in_array('gymnasium', $facilityFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="gymnasium">Gymnasium</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input facility-filter" type="checkbox" name="facilities[]" id="wifi" value="wifi" <?php echo in_array('wifi', $facilityFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="wifi">Wi-fi</label>
                </div>
				<div class="form-check">
                    <input class="form-check-input facility-filter" type="checkbox" name="facilities[]" id="room_service" value="room_service" <?php echo in_array('room_service', $facilityFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="room_service">Room Service</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input facility-filter" type="checkbox" name="facilities[]" id="air_condition" value="air_condition" <?php echo in_array('air_condition', $facilityFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="air_condition">Air Condition</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input facility-filter" type="checkbox" name="facilities[]" id="breakfast" value="breakfast" <?php echo in_array('breakfast', $facilityFilter) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="breakfast">breakfast</label>
                </div>
            </div>
            <input type="hidden" name="city" id="cityInput" value="<?php echo htmlspecialchars($cityFilter); ?>">
                    
            <button type="submit" class="btn btn-warning btn-block mt-3" style="background: #f8b600; color: #222; font-weight: 600; padding: 10px; border: none; border-radius: 5px; width: 100%;">Apply Filter</button>
            </form>
        </div>
    </div>
    <!-- End Filter Sidebar -->

    <!-- Start Hotel List Area -->
    <div class="col-lg-9 hotel-list-wrapper">
        <section class="destinations-area section-gap">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="menu-content pb-40 col-lg-8">
                        <div class="city-filter-tabs">
							<a href="<?php echo buildFilterUrl('all', $starFilter, $facilityFilter, $priceSort); ?>" 
							class="city-tab <?php echo $cityFilter == 'all' ? 'active' : ''; ?>">ALL</a>
							
							<a href="<?php echo buildFilterUrl('Jakarta', $starFilter, $facilityFilter, $priceSort); ?>" 
							class="city-tab <?php echo $cityFilter == 'Jakarta' ? 'active' : ''; ?>">JAKARTA</a>
							
							<a href="<?php echo buildFilterUrl('Bali', $starFilter, $facilityFilter, $priceSort); ?>" 
							class="city-tab <?php echo $cityFilter == 'Bali' ? 'active' : ''; ?>">BALI</a>
							
							<a href="<?php echo buildFilterUrl('Surabaya', $starFilter, $facilityFilter, $priceSort); ?>" 
							class="city-tab <?php echo $cityFilter == 'Surabaya' ? 'active' : ''; ?>">SURABAYA</a>
							
							<a href="<?php echo buildFilterUrl('Bandung', $starFilter, $facilityFilter, $priceSort); ?>" 
							class="city-tab <?php echo $cityFilter == 'Bandung' ? 'active' : ''; ?>">BANDUNG</a>
						</div>
                    </div>
                </div>
                
                <div class="row" id="hotel-list">
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Generate star rating
                                $stars = '';
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $row['star_rating']) {
                                        $stars .= '<span class="fa fa-star checked"></span>';
                                    } else {
                                        $stars .= '<span class="fa fa-star"></span>';
                                    }
                                }

								$imageName = getHotelImage($row['hotel_id'], $hotelImages);
                        ?>
                    <!-- Hotel 1 dengan data attributes -->
                    <div class="col-lg-4 hotel-item" 
                        data-city="<?php echo htmlspecialchars($row['city']); ?>"
                        data-stars="<?php echo $row['star_rating']; ?>">
					<a class="hotel-card-link" href="detail-hotel.php?hotel_id=<?php echo (int)$row['hotel_id']; ?>">
                        <!--data-facilities='["swimming pool", "wi-fi", "air condition", "breakfast"]'> -->
                        <div class="single-destinations">
                            <div class="thumb">
                                <img src="./img/hotels/<?php echo $imageName; ?>" alt="<?php echo htmlspecialchars($row['hotel_name']); ?>">
                            </div>
                            <div class="details">
                                <h4 class="d-flex justify-content-between">
                                    <span><?php echo htmlspecialchars($row['hotel_name']); ?></span>                              
                                    <div class="star">
                                        <?php echo $stars; ?>
                                    </div>
                                </h4>
                                <p><?php echo htmlspecialchars($row['city']); ?></p>
                                <ul class="package-list">
                                    <li class="d-flex justify-content-between align-items-center">
                                        <span>Swimming pool</span>
                                        <span><?php echo $row['swimming_pool'] ? 'Yes' : 'No'; ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        <span>Gymnasium</span>
                                        <span><?php echo $row['gymnasium'] ? 'Yes' : 'No'; ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        <span>Wi-fi</span>
                                        <span><?php echo $row['wifi'] ? 'Yes' : 'No'; ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        <span>Room Service</span>
                                        <span><?php echo $row['room_service'] ? 'Yes' : 'No'; ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        <span>Air Condition</span>
                                        <span><?php echo $row['air_condition'] ? 'Yes' : 'No'; ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        <span>Breakfast</span>
                                        <span><?php echo $row['breakfast'] ? 'Yes' : 'No'; ?></span>
                                    </li>                                                
                                    <li class="d-flex justify-content-between align-items-center">
                                        <span>Price per night</span>
                                        <a href="detail-hotel.php?hotel_id=<?php echo $row['hotel_id']; ?>" class="price-btn">Book Now</a>
                                    </li>                                                   
                                </ul>
                            </div>
                        </div>
						</a>
                    </div>
                <?php
                    } 
                } else {
                    echo '<div class="col-lg-12 text-center"><div class="alert alert-info" style="margin: 50px auto; padding: 20px;">No hotels found with the selected filters.</div></div>';
                } // Tutup if
                ?>
                </div>
            </div>
        </section>
    </div>
    <!-- End Hotel List Area -->
</div>
<!-- End Filter Area -->

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