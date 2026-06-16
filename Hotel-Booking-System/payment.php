<?php
session_start();
include __DIR__ . '/../database.php';

// Ambil booking_id dari URL
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

if ($booking_id === 0) {
    header("Location: hotels.php");
    exit();
}

// Ambil data booking dari database langsung (tidak dari session)
$sql = "SELECT b.booking_id, b.total_amount, b.status,
               h.hotel_name, h.hotel_id,
               r.room_type, r.price AS room_price,
               bd.check_in, bd.check_out, bd.price_per_night,
               DATEDIFF(bd.check_out, bd.check_in) AS nights
        FROM bookings b
        JOIN hotels h ON b.hotel_id = h.hotel_id
        JOIN booking_details bd ON b.booking_id = bd.booking_id
        JOIN rooms r ON bd.room_id = r.room_id
        WHERE b.booking_id = ? AND b.status = 'pending'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    // Booking tidak ditemukan atau sudah dibayar
    header("Location: hotels.php");
    exit();
}

$tax = 150000;
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
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="payment-container">
        <div class="payment-caard">
            <div class="payment-header">
                <h2><i class="fas fa-credit-card"></i> Pembayaran</h2>
                <p>Booking ID: #<?php echo $booking['booking_id']; ?></p>
            </div>

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
                    <span class="value"><?php echo date('d M Y', strtotime($booking['check_in'])); ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Check-out:</span>
                    <span class="value"><?php echo date('d M Y', strtotime($booking['check_out'])); ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Jumlah Malam:</span>
                    <span class="value"><?php echo $booking['nights']; ?> malam</span>
                </div>
                <hr>
                <div class="summary-row">
                    <span class="label">Harga Kamar:</span>
                    <span class="value">Rp <?php echo number_format($booking['room_price'] * $booking['nights'], 0, ',', '.'); ?></span>
                </div>
                <div class="summary-row">
                    <span class="label">Pajak & Biaya:</span>
                    <span class="value">Rp <?php echo number_format($tax, 0, ',', '.'); ?></span>
                </div>
                <div class="summary-row total">
                    <span class="label">Total Pembayaran:</span>
                    <span class="value">Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></span>
                </div>
            </div>

            <!-- action langsung ke functions/process-payment.php -->
            <form id="paymentForm" method="POST" action="../functions/process-payment.php">
                <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                <input type="hidden" name="amount" value="<?php echo $booking['total_amount']; ?>">

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