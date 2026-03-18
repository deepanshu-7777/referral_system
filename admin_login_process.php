<?php
session_start();
include "db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$res = $conn->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");

if($res->num_rows > 0){
    $_SESSION['admin'] = true;
    header("Location: admin_dashboard.php");
} else {
    echo "Invalid Login!";
}
?>