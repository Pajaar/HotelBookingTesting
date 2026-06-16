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

include __DIR__ . '/../database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$isLoggedIn = true;
$userName = $_SESSION['name'];

// Get booking history user
$sql = "SELECT b.booking_id, b.booking_date, b.status, b.total_amount,
               h.hotel_name, r.room_type, 
               bd.check_in, bd.check_out, bd.price_per_night
        FROM bookings b
        JOIN booking_details bd ON b.booking_id = bd.booking_id
        JOIN hotels h ON b.hotel_id = h.hotel_id
        JOIN rooms r ON bd.room_id = r.room_id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History - Travelista</title>
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/detail.css">
</head>

<body>
    <header id="header" class="header-static">
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="hotels.php">Hotels</a></li>
                        
                        <?php if ($isLoggedIn): ?>
                            <li class="menu-active"><a href="booking-history.php">History</a></li>
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
                </nav>
            </div>
        </div>
    </header>
    
    <div class="history-container">
        <div class="container">
            <h2 class="history-title">Booking History</h2>
            
            <?php if (empty($bookings)): ?>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> Belum ada riwayat booking.
                </div>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                    <div class="history-card">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4><?php echo htmlspecialchars($booking['hotel_name']); ?></h4>
                                <p><strong>Room:</strong> <?php echo htmlspecialchars($booking['room_type']); ?></p>
                                <p><strong>Check-in:</strong> <?php echo date('d M Y', strtotime($booking['check_in'])); ?></p>
                                <p><strong>Check-out:</strong> <?php echo date('d M Y', strtotime($booking['check_out'])); ?></p>
                                <p><strong>Booking Date:</strong> <?php echo date('d M Y H:i', strtotime($booking['booking_date'])); ?></p>
                            </div>
                            <div class="col-md-4 text-right">
                                <span class="status-badge status-<?php echo $booking['status']; ?>">
                                    <?php echo strtoupper($booking['status']); ?>
                                </span>
                                <div class="total-price">Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></div>
                                <div class="booking-id-text">Booking ID: #<?php echo $booking['booking_id']; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
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
