<?php
session_start();
include __DIR__ . '/../database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../Hotel-Booking-System/hotels.php");
    exit();
}

$hotel_id = intval($_POST['hotel_id']);
$room_id = intval($_POST['room_id']);
$full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$country_code = mysqli_real_escape_string($conn, $_POST['country_code']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$adult_count = intval($_POST['adult_count']);
$child_count = intval($_POST['child_count']);
$checkin_date = mysqli_real_escape_string($conn, $_POST['checkin_date']);
$checkout_date = mysqli_real_escape_string($conn, $_POST['checkout_date']);
$nights = intval($_POST['nights']);

// Hardcode user_id 15 untuk live preview (sudah login otomatis)
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 15;

// Get hotel data
$sql_hotel = "SELECT hotel_name FROM hotels WHERE hotel_id = ?";
$stmt_hotel = $conn->prepare($sql_hotel);
$stmt_hotel->bind_param("i", $hotel_id);
$stmt_hotel->execute();
$result_hotel = $stmt_hotel->get_result();
$hotel = $result_hotel->fetch_assoc();

if (!$hotel) {
    die("Error: Hotel tidak ditemukan.");
}

// Get room data
$sql_room = "SELECT room_type, price FROM rooms WHERE room_id = ?";
$stmt_room = $conn->prepare($sql_room);
$stmt_room->bind_param("i", $room_id);
$stmt_room->execute();
$result_room = $stmt_room->get_result();
$room = $result_room->fetch_assoc();

if (!$room) {
    die("Error: Room tidak ditemukan.");
}

$room_price = $room['price'];
$tax = 150000;
$total_amount = ($room_price * $nights) + $tax;

// Insert ke tabel bookings
$sql_booking = "INSERT INTO bookings (user_id, hotel_id, booking_date, status, total_amount) 
                VALUES (?, ?, NOW(), 'pending', ?)";
$stmt_booking = $conn->prepare($sql_booking);
$stmt_booking->bind_param("iid", $user_id, $hotel_id, $total_amount);

if ($stmt_booking->execute()) {
    $booking_id = $conn->insert_id;

    // Insert ke tabel booking_details
    $sql_details = "INSERT INTO booking_details (booking_id, room_id, price_per_night, check_in, check_out, special_request) 
                    VALUES (?, ?, ?, ?, ?, '')";
    $stmt_details = $conn->prepare($sql_details);
    $stmt_details->bind_param("iidss", $booking_id, $room_id, $room_price, $checkin_date, $checkout_date);
    $stmt_details->execute();

    // Kurangi availability kamar
    $sql_update_availability = "UPDATE rooms SET availability = availability - 1 WHERE room_id = ?";
    $stmt_update = $conn->prepare($sql_update_availability);
    $stmt_update->bind_param("i", $room_id);
    $stmt_update->execute();

    // Simpan booking info ke session untuk halaman payment
    $_SESSION['booking_info'] = [
        'booking_id'  => $booking_id,
        'hotel_id'    => $hotel_id,
        'hotel_name'  => $hotel['hotel_name'],
        'room_type'   => $room['room_type'],
        'full_name'   => $full_name,
        'email'       => $email,
        'phone'       => $country_code . $phone,
        'adults'      => $adult_count,
        'children'    => $child_count,
        'checkin'     => $checkin_date,
        'checkout'    => $checkout_date,
        'nights'      => $nights,
        'room_price'  => $room_price,
        'tax'         => $tax,
        'total'       => $total_amount
    ];

    // Redirect ke halaman payment
    header("Location: ../Hotel-Booking-System/payment.php");
    exit();

} else {
    echo "Error saat menyimpan booking: " . $conn->error;
}

$conn->close();
?>