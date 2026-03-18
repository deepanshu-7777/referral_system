<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// total new users
$newUsers = $conn->query("SELECT COUNT(*) as total FROM new_users")->fetch_assoc()['total'];

// total existing users
$existingUsers = $conn->query("SELECT COUNT(*) as total FROM existing_users")->fetch_assoc()['total'];
?>

<link rel="stylesheet" href="style.css">

<div class="container">

    <h2>Admin Dashboard</h2>

    <div class="stats">
        <div class="stat-box">
            Total New Users <br><b><?php echo $newUsers; ?></b>
        </div>

        <div class="stat-box">
            Existing Users <br><b><?php echo $existingUsers; ?></b>
        </div>
    </div>

    <div class="card">
        <a href="view_existing.php" class="btn">View Existing Users</a>
        <a href="view_new_users.php" class="btn">View New Users</a>
        <a href="admin_logout.php" class="btn">Logout</a>
    </div>

</div>