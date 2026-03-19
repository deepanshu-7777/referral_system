<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral System - Login / Register</title>
    <link rel="stylesheet" href="style_new.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .tab-buttons { display: flex; background: #f7fafc; border-radius: 12px 12px 0 0; margin-bottom: 0; overflow: hidden; }
        .tab-btn { flex: 1; padding: 16px 24px; background: none; border: none; font-weight: 500; cursor: pointer; transition: all 0.3s; color: #718096; border-bottom: 3px solid transparent; }
        .tab-btn.active { background: white; color: #4299e1; border-bottom-color: #4299e1; }
        .tab-content { display: none; background: white; padding: 30px; border-radius: 0 0 16px 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .tab-content.active { display: block; }
        @media (max-width: 768px) { .tab-buttons { flex-direction: column; } .tab-btn { border-radius: 0 !important; border-bottom: 2px solid #e2e8f0 !important; } }
    </style>
</head>
<body>
    <div class="center-container">
        <div class="form-card" style="max-width: 480px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <i class="fas fa-share-alt" style="font-size: 52px; color: #4299e1; margin-bottom: 15px;"></i>
                <h2>Referral Program</h2>
                <p style="color: #666; margin: 0;">Login to participate</p>
            </div>

            <!-- Tab Buttons -->
            <div class="tab-buttons">
                <button class="tab-btn active" onclick="switchTab('login')"><i class="fas fa-sign-in-alt"></i> Existing User</button>
                <!-- <button class="tab-btn" onclick="switchTab('register')"><i class="fas fa-user-plus"></i> New Registration</button> -->
            </div>

            <!-- Existing User Login Tab -->
            <div id="login-tab" class="tab-content active">
                <form method="POST" action="verify_login.php" id="loginForm">
                    <div class="input-group">
                        <label><i class="fas fa-user"></i> Full Name <span style="color: #e53e3e;">*</span></label>
                        <input type="text" name="name" required placeholder="Enter your full name">
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-phone"></i> Mobile Number <span style="color: #e53e3e;">*</span></label>
                        <input type="tel" name="mobile" required placeholder="10 digit mobile number">
                    </div>
                    <button type="submit" class="btn" style="width: 100%;">
                        <i class="fas fa-arrow-right"></i> Proceed to Referrals
                    </button>
                </form>
                <!-- <div style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
                    Don't have an account? <a href="#" onclick="switchTab('register')" style="color: #4299e1;">Register here</a>
                </div>
            </div> -->

            <!-- New Registration Tab -->
            <div id="register-tab" class="tab-content">
                <form method="POST" action="save_user.php" id="registerForm">
                    <div class="input-group">
                        <label><i class="fas fa-user"></i> Full Name <span style="color: #e53e3e;">*</span></label>
                        <input type="text" name="name" required placeholder="Enter your full name">
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-envelope"></i> Email Address <span style="color: #e53e3e;">*</span></label>
                        <input type="email" name="email" required placeholder="Enter your email">
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-phone"></i> Mobile Number <span style="color: #e53e3e;">*</span></label>
                        <input type="tel" name="mobile" required placeholder="10 digit mobile number">
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-share-alt"></i> Referral Code (Optional)</label>
                        <input type="text" name="ref_code" placeholder="Enter referral code if you have one">
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-link"></i> Relationship <span style="color: #e53e3e;">*</span></label>
                        <select name="relation" required>
                            <option value="">Select relationship</option>
                            <option value="Friend">Friend</option>
                            <option value="Family">Family</option>
                            <option value="Colleague">Colleague</option>
                            <option value="Other">Other</option>
                        </select>
                    </select>
                    </div>
                    <button type="submit" class="btn" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i> Register Now
                    </button>
                </form>
                <div style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
                    Already registered? <a href="#" onclick="switchTab('login')" style="color: #4299e1;">Login here</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Update content
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            document.getElementById(tab + '-tab').classList.add('active');
        }

        // Form validation for both
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('#loginForm, #registerForm');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const mobile = this.querySelector('input[name="mobile"]').value;
                    if (!/^\d{10}$/.test(mobile.replace(/\D/g,''))) {
                        e.preventDefault();
                        alert('Please enter a valid 10-digit mobile number');
                        return false;
                    }
                });
            });
        });
    </script>
</body>
</html>
