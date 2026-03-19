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

// Recent new users (last 5)
$recentUsers = $conn->query("SELECT name, email FROM new_users ORDER BY email DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Referral System</title>
    <link rel="stylesheet" href="style_new.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container" style="max-width: 1400px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <p style="color: #666; margin: 0;">Welcome back, Admin! Here's what's happening.</p>
            </div>
            <div>
                <!-- <a href="bulk_register.php" class="btn" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                    <i class="fas fa-upload"></i> Bulk Register
                </a> -->
                <a href="admin_logout.php" class="btn secondary" style="margin-left: 10px;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <div class="stats" style="margin-bottom: 30px;">
            <div class="stat-box">
                <i class="fas fa-user-plus" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                <div>Total New Users</div>
                <div style="font-size: 32px; font-weight: 700; margin-top: 5px;"><?php echo $newUsers; ?></div>
            </div>
            <div class="stat-box" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);">
                <i class="fas fa-users" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                <div>Existing Users</div>
                <div style="font-size: 32px; font-weight: 700; margin-top: 5px;"><?php echo $existingUsers; ?></div>
            </div>
            <div class="stat-box" style="background: linear-gradient(135deg, #805ad5 0%, #6b46c1 100%);">
                <i class="fas fa-chart-line" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                <div>Total Referrals</div>
                <div style="font-size: 32px; font-weight: 700; margin-top: 5px;"><?php echo $newUsers ; ?></div>
            </div>
            <!-- + $existingUsers -->
        </div>

        <div class="button-row">
            <a href="view_new_users.php" class="btn">
                <i class="fas fa-user-check"></i> New Users
            </a>
            <a href="view_existing.php" class="btn">
                <i class="fas fa-user-friends"></i> Existing Users
            </a>
            <!-- <a href="bulk_register.php" class="btn" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <i class="fas fa-file-csv"></i> Bulk Upload
            </a> -->
        </div>

        <div style="margin-top: 40px;">
            <h3 style="margin-bottom: 20px; color: #2d3748;"><i class="fas fa-clock"></i> Recent Registrations</h3>
            <div class="card">
                <?php if(!empty($recentUsers)): ?>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <?php foreach($recentUsers as $user): ?>
                            <div style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #e2e8f0;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4299e1, #3182ce); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; margin-right: 15px; font-size: 18px;">
                                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; margin-bottom: 2px;"><?php echo htmlspecialchars($user['name']); ?></div>
                                    <div style="color: #666; font-size: 14px;"><?php echo htmlspecialchars($user['email']); ?></div>
                                </div>
                                <div style="text-align: right; color: #666; font-size: 14px;">
                                    Recent
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="text-align: center; color: #666; padding: 40px;">No recent registrations</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
