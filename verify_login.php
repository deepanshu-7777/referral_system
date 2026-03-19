<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    
    // Validate inputs
    if (empty($name) || empty($mobile) || !preg_match('/^\d{10}$/', $mobile)) {
        $_SESSION['error'] = "Please provide valid name and 10-digit mobile number.";
        header("Location: login.php");
        exit();
    }
    
    // Verify exact name AND mobile match in existing_users
    $stmt = $conn->prepare("SELECT client_id FROM existing_users WHERE name = ? AND mobile = ?");
    $stmt->bind_param("ss", $name, $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['existing_user_client_id'] = $user['client_id'];
        $_SESSION['existing_user_name'] = $name;
        unset($_SESSION['error']);
        header("Location: bulk_register.php");
        exit();
    } else {
        $_SESSION['error'] = "No matching existing user found. Please check your name and mobile number.";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>

