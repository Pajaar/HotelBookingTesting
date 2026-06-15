<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../database.php';

/*
|--------------------------------------------------------------------------
| DEMO MODE
||--------------------------------------------------------------------------
| Website langsung dianggap login untuk preview portfolio.
| Ubah $demoMode jadi false kalau mau balik ke login normal.
*/
$demoMode = true;

// Akun demo dari tabel users
$demoUserId = 15;
$demoName   = 'user123';
$demoEmail  = 'user111@gmail.com';
$demoRole   = 'user';

if ($demoMode) {
    $q = "SELECT * FROM users WHERE user_id = $demoUserId LIMIT 1";
    $r = mysqli_query($conn, $q);
    $u = $r ? mysqli_fetch_assoc($r) : null;

    $_SESSION = array();
    $_SESSION['user_id'] = $u ? $u['user_id'] : $demoUserId;
    $_SESSION['name']    = $u ? $u['name'] : $demoName;
    $_SESSION['email']   = $u ? $u['email'] : $demoEmail;
    $_SESSION['role']    = $u ? $u['role'] : $demoRole;
    $_SESSION['status']  = 'login';

    if ($_SESSION['role'] === 'admin') {
        header("Location: ../admin/index.php");
        exit();
    }

    header("Location: ../Hotel-Booking-System/index.php?login=success");
    exit();
}

$_SESSION = array();
session_unset();
session_destroy();
session_start();

$username = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$password = $_POST['password_hash'] ?? '';

$query = "SELECT * FROM users WHERE name collate utf8mb4_bin = '$username' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    if (password_verify($password, $data['passwordhash'])) {
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['name']    = $data['name'];
        $_SESSION['email']   = $data['email'];
        $_SESSION['role']    = $data['role'];
        $_SESSION['status']  = 'login';

        if ($data['role'] == 'admin') {
            header("Location: ../admin/index.php");
            exit();
        }

        header("Location: ../Hotel-Booking-System/index.php?login=success");
        exit();
    }
}

$_SESSION['error'] = "Invalid username or password!";
header("Location: ../Hotel-Booking-System/index.php?login=failed");
exit();
?>