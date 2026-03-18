<?php
include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$ref_code = $_POST['ref_code'];

// 1. required fields check (referral optional)
if(empty($name) || empty($email) || empty($mobile)){
    die("Name, Email and Mobile are required!");
}

// 2. duplicate check
$checkUser = $conn->query("SELECT * FROM new_users 
WHERE email='$email' OR mobile='$mobile'");

if($checkUser->num_rows > 0){
    die("User already exists!");
}

// 3. referral logic
$referred_by = NULL;

if(!empty($ref_code)){

    $check = $conn->query("SELECT * FROM existing_users WHERE client_id='$ref_code'");

    if($check->num_rows > 0){
        $referred_by = $ref_code;

        // increase referral count
        $conn->query("UPDATE existing_users 
        SET total_referrals = total_referrals + 1 
        WHERE client_id='$ref_code'");
        
    } else {
        die("Invalid Referral Code!");
    }
}

// 4. insert new user
$conn->query("INSERT INTO new_users (name,email,mobile,referred_by)
VALUES ('$name','$email','$mobile','$referred_by')");

echo "Registration Successful!";
?>