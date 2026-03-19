# Referral System Update: Existing User Login Flow

## Steps to Complete:

### 1. Create login.php (Combined entrypoint: New Reg + Existing Login)
- [ ] Create file with tabs/sections for new registration and existing user login (name + phone)
- Form1: Existing form to save_user.php
- Form2: Name + phone to verify_login.php

### 2. Create verify_login.php (Login handler)
- [ ] Verify exact name AND phone match in existing_users
- [ ] Set $_SESSION['existing_user_client_id']
- [ ] Redirect to bulk_register.php on success, error back to login.php

### 3. Update bulk_register.php
- [ ] Session check: if no $_SESSION['existing_user_client_id'], redirect to login.php
- [ ] Show current user info (name, client_id)
- [ ] Hidden ref_code = $_SESSION['existing_user_client_id']
- [ ] Add logout button/link

### 4. Update save_bulk.php
- [ ] Validate $_SESSION['existing_user_client_id'] == ref_code
- [ ] Increment referral count only if valid session

### 5. Update register.php
- [ ] Redirect or replace content to point to login.php as main entry

### 6. Testing
- [ ] Insert test existing_user via admin or direct SQL
- [ ] Test login → bulk → submit → check DB counts
- [ ] Test invalid login
- [ ] Complete task

**Current Progress: Starting Step 1**
