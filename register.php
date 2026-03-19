<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">

<div class="center-container">

    <div class="form-card">

        <h2>Create Account</h2>

        <form method="POST" action="save_user.php">

            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Mobile</label>
                <input type="text" name="mobile" required>
            </div>

            <div class="input-group">
                <label>Referral Code (Optional)</label>
                <input type="text" name="ref_code">
            </div>
            <div class="input-group">
        <label>Relation </label>
    <select name="relation" required>
        <option value="">Select Relation</option>
        <option value="Friend">Friend</option>
        <option value="Family">Family</option>
        <option value="Colleague">Colleague</option>
        <option value="Other">Other</option>
    </select>
</div>

            <button type="submit" class="btn">Register</button>

        </form>

    </div>

</div>