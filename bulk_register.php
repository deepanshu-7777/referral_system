<?php session_start(); 
if (!isset($_SESSION['existing_user_client_id'])) {
    header("Location: login.php?error=Please login as existing user first");
    exit();
}
include "db.php";

// Fetch current user info
$client_id = $_SESSION['existing_user_client_id'];
$user_query = $conn->prepare("SELECT name FROM existing_users WHERE client_id = ?");
$user_query->bind_param("s", $client_id);
$user_query->execute();
$current_user = $user_query->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Referral - <?php echo htmlspecialchars($current_user['name'] ?? 'User'); ?></title>
<link rel="stylesheet" href="style_new.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .user-info {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
        }
        .user-info h3 { margin: 0 0 5px 0; font-size: 24px; }
        .user-info p { margin: 0; opacity: 0.9; }
        .logout-btn { 
            background: rgba(255,255,255,0.2); 
            color: white; 
            border: 1px solid rgba(255,255,255,0.3); 
            padding: 8px 16px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-size: 14px; 
            transition: all 0.3s; 
            display: inline-block; 
            margin-top: 10px;
        }
        .logout-btn:hover { background: rgba(255,255,255,0.3); }
        .ref-code-display { font-weight: 600; color: #48bb78; }
        /* .upload-area { ... } existing styles */
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #48bb78, #38a169);
            width: 0%;
            transition: width 0.3s ease;
        }
        #csvFile { display: none; }
    </style>
    <style>
        .user-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }
        .user-row input, .user-row select { flex: 1 1 170px; min-width: 140px; }
        .remove-row {
            flex: 0 0 auto; background: transparent; border: 1px solid rgba(0,0,0,0.12);
            border-radius: 8px; width: 38px; height: 38px; font-size: 18px; cursor: pointer;
            color: #b30000; display: flex; align-items: center; justify-content: center;
        }
        .remove-row:hover { background: rgba(179, 0, 0, 0.12); }
        .button-row { display: flex; gap: 15px; justify-content: center; margin-top: 25px; flex-wrap: wrap; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-card">

<h2>Registration</h2>

<form method="POST" action="save_bulk.php">

    <!-- Hidden Referral Code - Auto-filled -->
    <input type="hidden" name="ref_code" value="<?php echo htmlspecialchars($client_id); ?>">
    
    <!-- Current User Info -->
    <div class="user-info">
        <h3><i class="fas fa-user-check"></i> Welcome, <?php echo htmlspecialchars($current_user['name'] ?? 'User'); ?>!</h3>
        <p>Your Referral ID: <span class="ref-code-display"><?php echo htmlspecialchars($client_id); ?></span></p>
        <a href="logout.php" class="logout-btn" onclick="return confirm('Logout and return to login?')">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <hr>

    <!-- Multiple Users -->
    <!-- CSV Upload Area -->
    <!-- <div class="upload-area" onclick="document.getElementById('csvFile').click()">
        <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #4299e1; margin-bottom: 15px;"></i>
        <h4>Upload CSV File</h4>
        <p>Drag & drop CSV or click to browse. Format: name,email,mobile,relation</p>
        <input type="file" id="csvFile" accept=".csv" onchange="previewCSV(this.files[0])">
        <div class="progress-bar" id="progressBar" style="display: none;">
            <div class="progress-fill" id="progressFill"></div>
        </div>
    </div>
    
    <div id="csvPreview" class="csv-preview" style="display: none;"></div> -->

    <!-- Manual Entry -->
    <!-- <h4 style="text-align: center; margin: 40px 0 20px 0; color: #666;">OR</h4> -->

    <div id="user-fields">
        <div class="user-row">
            <input type="text" name="name[]" placeholder="Name" required>
            <input type="email" name="email[]" placeholder="Email" required>
            <input type="tel" name="mobile[]" placeholder="Mobile" required>
            <select name="relation[]" required>
                <option value="">Relation</option>
                <option>Friend</option>
                <option>Family</option>
                <option>Colleague</option>
                <option>Other</option>
            </select>
            <button type="button" class="remove-row" title="Remove row">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="button-row">
        <button type="button" class="secondary" onclick="addRow()">+ Add More</button>
        <!-- <a href="login.php" class="secondary" style="padding: 12px 24px; display: inline-flex; align-items: center;">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a> -->
        <button type="submit" class="btn">Submit Referrals</button>
    </div>

</form>

</div>
</div>
<script>
function addRow(){
    const div = document.createElement("div");
    div.classList.add("user-row");

    div.innerHTML = `
        <input type="text" name="name[]" placeholder="Name" required>
        <input type="email" name="email[]" placeholder="Email" required>
        <input type="tel" name="mobile[]" placeholder="Mobile" required>
        <select name="relation[]" required>
            <option value="">Relation</option>
            <option>Friend</option>
            <option>Family</option>
            <option>Colleague</option>
            <option>Other</option>
        </select>
        <button type="button" class="remove-row" title="Remove row">
            <i class="fas fa-trash"></i>
        </button>
    `;

    document.getElementById("user-fields").appendChild(div);
}

// Remove row handler
document.getElementById("user-fields").addEventListener("click", function(event) {
    if (event.target.closest(".remove-row")) {
        const row = event.target.closest(".user-row");
        const rows = document.querySelectorAll(".user-row");
        if (rows.length > 1) {
            row.remove();
        } else {
            row.querySelectorAll("input, select").forEach(field => field.value = "");
        }
    }
});

// CSV Upload & Preview
function previewCSV(file) {
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const text = e.target.result;
        const data = parseCSV(text);
        displayPreview(data);
        // Auto-populate manual fields from CSV
        populateManualFields(data.slice(1)); // Skip header
    };
    reader.readAsText(file);
}

function parseCSV(text) {
    const lines = text.trim().split('\n');
    return lines.map(line => line.split(',').map(cell => cell.trim().replace(/"/g, '')));
}

function displayPreview(data) {
    const preview = document.getElementById('csvPreview');
    if (data.length === 0) {
        preview.style.display = 'none';
        return;
    }

    let html = '<table><thead><tr>';
    data[0].forEach(header => {
        html += `<th>${header}</th>`;
    });
    html += '</tr></thead><tbody>';

    data.slice(1, 6).forEach(row => { // Show first 5 rows
        html += '<tr>';
        row.forEach(cell => {
            html += `<td>${cell || ''}</td>`;
        });
        html += '</tr>';
    });

    html += '</tbody></table>';
    if (data.length > 6) {
        html += `<p style="text-align: center; color: #666; margin-top: 10px;">... and ${data.length - 6} more rows</p>`;
    }

    preview.innerHTML = html;
    preview.style.display = 'block';
}

function populateManualFields(csvData) {
    document.getElementById('user-fields').innerHTML = '';
    csvData.slice(0, 3).forEach(row => { // Populate first 3 rows
        addRowFromCSV(row);
    });
}

function addRowFromCSV(data) {
    const div = document.createElement("div");
    div.classList.add("user-row");

    const nameInput = `<input type="text" name="name[]" value="${data[0] || ''}" placeholder="Name" required>`;
    const emailInput = `<input type="email" name="email[]" value="${data[1] || ''}" placeholder="Email" required>`;
    const mobileInput = `<input type="tel" name="mobile[]" value="${data[2] || ''}" placeholder="Mobile" required>`;
    const relationSelect = `<select name="relation[]" required>
        <option value="">Relation</option>
        <option ${data[3] === 'Friend' ? 'selected' : ''}>Friend</option>
        <option ${data[3] === 'Family' ? 'selected' : ''}>Family</option>
        <option ${data[3] === 'Colleague' ? 'selected' : ''}>Colleague</option>
        <option ${data[3] === 'Other' ? 'selected' : ''}>Other</option>
    </select>`;

    div.innerHTML = nameInput + emailInput + mobileInput + relationSelect +
        '<button type="button" class="remove-row" title="Remove row"><i class="fas fa-trash"></i></button>';

    document.getElementById("user-fields").appendChild(div);
}

// Drag & Drop
const uploadArea = document.querySelector('.upload-area');
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('dragover');
});
uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('dragover');
});
uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('csvFile').files = files;
        previewCSV(files[0]);
    }
});
</script>
</body>
</html>