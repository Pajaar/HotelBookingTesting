<?php
session_start();
include __DIR__ . '/../database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../Hotel-Booking-System/hotels.php");
    exit();
}

// Get form data dari modal payment
$booking_id = intval($_POST['booking_id']);
$amount = floatval($_POST['amount']);
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

// Insert payment record ke tabel payments
$sql_payment = "INSERT INTO payments (booking_id, amount, payment_date, payment_method, status)
                VALUES (?, ?, NOW(), ?, 'paid')";
$stmt_payment = $conn->prepare($sql_payment);
$stmt_payment->bind_param("ids", $booking_id, $amount, $payment_method);

if ($stmt_payment->execute()) {
    // Update booking status dari 'pending' ke 'confirmed'
    $sql_update = "UPDATE bookings SET status = 'confirmed' WHERE booking_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $booking_id);
    $stmt_update->execute();
    
    // Clear session booking_info
    unset($_SESSION['booking_info']);
    
    // Redirect ke success page
    header("Location: ../Hotel-Booking-System/payment-success.php?booking_id=" . $booking_id);
    exit();
} else {
    echo "Error payment: " . $conn->error;
}

$conn->close();
?>
