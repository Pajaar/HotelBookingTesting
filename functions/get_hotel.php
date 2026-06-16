<?php
session_start();
include __DIR__ . '/../database.php';

$hotelImages = [
    1 => 'd1.jpg',
    2 => 'd2.jpg',
    3 => 'd3.jpg',
    4 => 'd4.jpg',
    5 => 'd5.jpg',  
    6 => 'd6.jpg',
    7 => 'd7.jpg',
    8 => 'd8.jpg',
    9 => 'd9.jpg',
    10 => 'd10.jpg',
    11 => 'd11.jpg',
    12 => 'd12.jpg',
    13 => 'd13.jpg',
];

function getHotelImage($hotel_id, $hotelImages) {
    if (isset($hotelImages[$hotel_id])) {
        return $hotelImages[$hotel_id];
    }
    
    // Fallback: gunakan modulo untuk cycling d1-d6
    $imageIndex = (($hotel_id - 1) % 13) + 1;
    return 'd' . $imageIndex . '.jpg';
}


$cityFilter = isset($_GET['city']) ? $_GET['city'] : 'all';
$starFilter = isset($_GET['stars']) ? $_GET['stars'] : [];
$facilityFilter = isset($_GET['facilities']) ? $_GET['facilities'] : [];
$priceSort = isset($_GET['price_sort']) ? $_GET['price_sort'] : '';

$sql = "SELECT h.*, hf.* 
        FROM hotels h 
        LEFT JOIN hotel_facilities hf ON h.hotel_id = hf.hotel_id 
        WHERE 1=1";

//Filter by city
if ($cityFilter != 'all') {
    $sql .= " AND h.city = '" . $conn->real_escape_string($cityFilter) . "'";
}

//Filter by star rating
if (!empty($starFilter) && is_array($starFilter)) {
    $starList = implode(',', array_map('intval', $starFilter));
    $sql .= " AND h.star_rating IN ($starList)";
}

//Filter by facility
if (!empty($facilityFilter) && is_array($facilityFilter)) {
    foreach ($facilityFilter as $facility) {
        $facility = $conn->real_escape_string($facility);
        $sql .= " AND hf.$facility = 1";
    }
}

$sql .= " ORDER BY h.created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

function buildFilterUrl($city, $starFilter, $facilityFilter, $priceSort) {
    $url = "hotels.php?city=" . urlencode($city);
    
    if (!empty($starFilter)) {
        foreach ($starFilter as $star) {
            $url .= "&stars[]=" . urlencode($star);
        }
    }
    
    if (!empty($facilityFilter)) {
        foreach ($facilityFilter as $facility) {
            $url .= "&facilities[]=" . urlencode($facility);
        }
    }
    
    if (!empty($priceSort)) {
        $url .= "&price_sort=" . urlencode($priceSort);
    }
    
    return $url;
}

?>