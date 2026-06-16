<?php
session_start();
include __DIR__ . '/../database.php';

// Kalau tidak ada booking_info di session, redirect ke hotels
if (!isset($_SESSION['booking_info'])) {
    header("Location: hotels.php");
    exit();
}

$booking = $_SESSION['booking_info'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - <?php echo htmlspecialchars($booking['hotel_name']); ?></title>
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/payment.css">
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="payment-container">
        <div class="payment-caard">
            <!-- Header -->
            <div class="payment-header">
                <h2><i class="fas fa-credit-card"></i> Pembayaran</h2>
                <p>Booking ID: #<?php echo $booking['booking_id']; ?></p>
            </div>

            <!-- Booking Summary -->
            <div class="booking-summary">
                <h3>Detail Pemesanan</h3>
                <div class="summary-row">
                    <span class="label">Hotel:</span>
                    <span class="value"><?php echo htmlspecialchars($booking['hotel_name']); ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Tipe Kamar:</span>
                    <span class="value"><?php echo htmlspecialchars($booking['room_type']); ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Check-in:</span>
                    <span class="value"><?php echo date('d M Y', strtotime($booking['checkin'])); ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Check-out:</span>
                    <span class="value"><?php echo date('d M Y', strtotime($booking['checkout'])); ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Jumlah Malam:</span>
                    <span class="value"><?php echo $booking['nights']; ?> malam</span>
                </div>
                <div class="summary-row">
                    <span class="label">Tamu:</span>
                    <span class="value"><?php echo $booking['adults']; ?> dewasa, <?php echo $booking['children']; ?> anak</span>
                </div>
                <hr>
                <div class="summary-row">
                    <span class="label">Harga Kamar:</span>
                    <span class="value">Rp <?php echo number_format($booking['room_price'] * $booking['nights'], 0, ',', '.'); ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Pajak & Biaya:</span>
                    <span class="value">Rp <?php echo number_format($booking['tax'], 0, ',', '.'); ?></span>
                </div>
                <div class="summary-row total">
                    <span class="label">Total Pembayaran:</span>
                    <span class="value">Rp <?php echo number_format($booking['total'], 0, ',', '.'); ?></span>
                </div>
            </div>

            <!-- Payment Form — action mengarah ke functions/process-payment.php -->
            <form id="paymentForm" method="POST" action="../functions/process-payment.php">
                <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                <input type="hidden" name="amount" value="<?php echo $booking['total']; ?>">

                <h3 class="payment-method-title">Metode Pembayaran</h3>
                
                <div class="payment-methods">
                    <label class="payment-method-card">
                        <input type="radio" name="payment_method" value="credit_card" checked required>
                        <div class="method-content">
                            <i class="fas fa-credit-card"></i>
                            <span>Kartu Kredit / Debit</span>
                        </div>
                    </label>
                    <label class="payment-method-card">
                        <input type="radio" name="payment_method" value="bank_transfer" required>
                        <div class="method-content">
                            <i class="fas fa-university"></i>
                            <span>Transfer Bank</span>
                        </div>
                    </label>
                    <label class="payment-method-card">
                        <input type="radio" name="payment_method" value="e_wallet" required>
                        <div class="method-content">
                            <i class="fas fa-wallet"></i>
                            <span>E-Wallet (OVO, GoPay, Dana)</span>
                        </div>
                    </label>
                </div>

                <div class="payment-actions">
                    <a href="detail-hotel.php?hotel_id=<?php echo $booking['hotel_id']; ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-pay">
                        <i class="fas fa-check"></i> Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
</body>
</html>