<?php
header("Location: login.php");
exit();
?>

<body>
    <div class="center-container">
        <div class="form-card">
            <div style="text-align: center; margin-bottom: 30px;">
                <i class="fas fa-users" style="font-size: 48px; color: #4299e1; margin-bottom: 15px;"></i>
                <h2>Join Our Referral Program</h2>
                <p style="color: #666; margin-bottom: 0;">Refer Your People</p>
            </div>
            
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

                <!-- <div class="input-group">
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
                </div> -->

                <button type="submit" class="btn">
                    <i class="fas fa-paper-plane"></i> Register Now
                </button>
            </form>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: center;">
                <p style="color: #666; font-size: 14px;">
                    Already registered? <a href="bulk_register.php" style="color: #4299e1; font-weight: 500;">Bulk Registration</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const mobile = document.querySelector('input[name="mobile"]').value;
            if (!/^\d{10}$/.test(mobile.replace(/\D/g,''))) {
                e.preventDefault();
                alert('Please enter a valid 10-digit mobile number');
                return false;
            }
        });
    </script>
</body>
</html>
