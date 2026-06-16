<?php
session_start();
// DEBUG - hapus setelah ketemu masalahnya
echo "<pre>"; print_r($_POST); echo "</pre>"; exit();
include __DIR__ . '/../database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../Hotel-Booking-System/hotels.php");
    exit();
}

$hotel_id     = intval($_POST['hotel_id']);
$room_id      = intval($_POST['room_id']);
$full_name    = mysqli_real_escape_string($conn, $_POST['full_name']);
$email        = mysqli_real_escape_string($conn, $_POST['email']);
$country_code = mysqli_real_escape_string($conn, $_POST['country_code']);
$phone        = mysqli_real_escape_string($conn, $_POST['phone']);
$adult_count  = intval($_POST['adult_count']);
$child_count  = intval($_POST['child_count']);
$checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
$checkout_date= mysqli_real_escape_string($conn, $_POST['checkout_date']);
$nights       = intval($_POST['nights']);

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 15;

// Get hotel
$stmt_hotel = $conn->prepare("SELECT hotel_name FROM hotels WHERE hotel_id = ?");
$stmt_hotel->bind_param("i", $hotel_id);
$stmt_hotel->execute();
$hotel = $stmt_hotel->get_result()->fetch_assoc();
if (!$hotel) die("Error: Hotel tidak ditemukan.");

// Get room
$stmt_room = $conn->prepare("SELECT room_type, price FROM rooms WHERE room_id = ?");
$stmt_room->bind_param("i", $room_id);
$stmt_room->execute();
$room = $stmt_room->get_result()->fetch_assoc();
if (!$room) die("Error: Room tidak ditemukan.");

$room_price   = $room['price'];
$tax          = 150000;
$total_amount = ($room_price * $nights) + $tax;

// Insert booking
$stmt_booking = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, booking_date, status, total_amount) VALUES (?, ?, NOW(), 'pending', ?)");
$stmt_booking->bind_param("iid", $user_id, $hotel_id, $total_amount);

if ($stmt_booking->execute()) {
    $booking_id = $conn->insert_id;

    // Insert booking_details
    $stmt_details = $conn->prepare("INSERT INTO booking_details (booking_id, room_id, price_per_night, check_in, check_out, special_request) VALUES (?, ?, ?, ?, ?, '')");
    $stmt_details->bind_param("iidss", $booking_id, $room_id, $room_price, $checkin_date, $checkout_date);
    $stmt_details->execute();

    // Kurangi availability
    $stmt_avail = $conn->prepare("UPDATE rooms SET availability = availability - 1 WHERE room_id = ?");
    $stmt_avail->bind_param("i", $room_id);
    $stmt_avail->execute();

    $conn->close();

    // Redirect langsung ke payment dengan booking_id di URL — tidak pakai session
    header("Location: ../Hotel-Booking-System/payment.php?booking_id=" . $booking_id);
    exit();

} else {
    echo "Error saat menyimpan booking: " . $conn->error;
}