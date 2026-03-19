<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Referral System</title>
    <link rel="stylesheet" href="style_new.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="center-container">
        <div class="form-card" style="max-width: 420px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <i class="fas fa-shield-alt" style="font-size: 52px; color: #667eea; margin-bottom: 15px;"></i>
                <h2>Admin Panel</h2>
                <p style="color: #666; margin: 0;">Sign in to manage referrals</p>
            </div>
            
            <form method="POST" action="admin_login_process.php">
                <div class="input-group">
                    <label><i class="fas fa-user-shield"></i> Username</label>
                    <input type="text" name="username" required placeholder="Enter admin username" autocomplete="username">
                </div>

                <div class="input-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" required placeholder="Enter password" autocomplete="current-password">
                </div>

                <button type="submit" class="btn" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i> Login Securely
                </button>
            </form>

            <div style="margin-top: 25px; text-align: center;">
                <p style="color: #666; font-size: 14px; margin: 0;">
                    <a href="register.php" style="color: #4299e1; text-decoration: none;">← Back to Registration</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
