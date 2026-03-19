<?php
include "db.php";

$names = $_POST['name'];
$emails = $_POST['email'];
$mobiles = $_POST['mobile'];
$ref_code = $_POST['ref_code'];
$relations = $_POST['relation'];

$referred_by = NULL;

// check referral
if(!empty($ref_code)){
    $check = $conn->query("SELECT * FROM existing_users WHERE client_id='$ref_code'");

    if($check->num_rows > 0){
        $referred_by = $ref_code;
    } else {
        die("Invalid Referral Code!");
    }
}

// loop for multiple users
for($i = 0; $i < count($names); $i++){

    $name = $names[$i];
    $email = $emails[$i];
    $mobile = $mobiles[$i];
    $relation = $relations[$i];

    // skip empty rows
    if(empty($name) || empty($email) || empty($mobile)) continue;

    // duplicate check
    $checkUser = $conn->query("SELECT * FROM new_users 
    WHERE email='$email' OR mobile='$mobile'");

    if($checkUser->num_rows > 0){
        continue; // skip duplicate
    }

    // insert
    $conn->query("INSERT INTO new_users (name,email,mobile,referred_by,relation)
    VALUES ('$name','$email','$mobile','$referred_by','$relation')");
    
    // increase referral count
    if($referred_by){
        $conn->query("UPDATE existing_users 
        SET total_referrals = total_referrals + 1 
        WHERE client_id='$referred_by'");
    }
}

echo "Bulk Registration Completed!";
?>