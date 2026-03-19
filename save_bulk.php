<?php
session_start();
include "db.php";

// Session validation - must be logged in existing user
if (!isset($_SESSION['existing_user_client_id'])) {
    die("Access denied. Please login first.");
}

$names = $_POST['name'];
$emails = $_POST['email'];
$mobiles = $_POST['mobile'];
$ref_code = $_POST['ref_code'] ?? '';
$relations = $_POST['relation'];

$referred_by = NULL;

// Validate ref_code matches session
if (!empty($ref_code) && $ref_code !== $_SESSION['existing_user_client_id']) {
    die("Invalid referral code. Access denied.");
}

if (!empty($ref_code)) {
    $check = $conn->prepare("SELECT client_id FROM existing_users WHERE client_id = ?");
    $check->bind_param("s", $ref_code);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        $referred_by = $ref_code;
    } else {
        die("Invalid Referral Code!");
    }
}

// Process bulk registrations
$success_count = 0;
for ($i = 0; $i < count($names); $i++) {
    $name = trim($names[$i]);
    $email = trim($emails[$i]);
    $mobile = trim($mobiles[$i]);
    $relation = trim($relations[$i]);

    // Skip empty/invalid rows
    if (empty($name) || empty($email) || empty($mobile) || !preg_match('/^\S+@\S+\.\S+$/', $email) || !preg_match('/^\d{10}$/', $mobile)) {
        continue;
    }

    // Duplicate check with prepared statement
    $check_dup = $conn->prepare("SELECT id FROM new_users WHERE email = ? OR mobile = ?");
    $check_dup->bind_param("ss", $email, $mobile);
    $check_dup->execute();
    if ($check_dup->get_result()->num_rows > 0) {
        continue;
    }

    // Insert new referral
    $insert = $conn->prepare("INSERT INTO new_users (name, email, mobile, referred_by, relation) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("sssss", $name, $email, $mobile, $referred_by, $relation);
    if ($insert->execute()) {
        $success_count++;
        // Increment referral count atomically
        if ($referred_by) {
            $update = $conn->prepare("UPDATE existing_users SET total_referrals = total_referrals + 1 WHERE client_id = ?");
            $update->bind_param("s", $referred_by);
            $update->execute();
        }
    }
}

if ($success_count > 0) {
    echo "Successfully registered $success_count new referrals!<br>";
    echo '<a href="bulk_register.php" style="color: #4299e1; text-decoration: none;">← Add More Referrals</a>';
} else {
    echo "No new valid referrals added. <a href=\"bulk_register.php\">Try again</a>";
}
?>

