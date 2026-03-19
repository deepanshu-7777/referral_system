<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$where = $search ? "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%'" : '';
$countQuery = "SELECT COUNT(*) as total FROM existing_users $where";
$total = $conn->query($countQuery)->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

$query = "SELECT * FROM existing_users $where ORDER BY client_id DESC LIMIT $limit OFFSET $offset";
$res = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Existing Users - Admin Panel</title>
    <link rel="stylesheet" href="style_new.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div>
                <h2><i class="fas fa-user-friends"></i> Existing Users (<?php echo $total; ?>)</h2>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <form method="GET" style="display: flex; gap: 5px;">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Search users..." style="padding: 8px 12px; border: 2px solid #e2e8f0; border-radius: 8px; width: 250px;">
                    <button type="submit" class="btn" style="padding: 8px 16px; font-size: 14px;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="admin_dashboard.php" class="btn secondary" style="padding: 8px 16px;">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>

        <div class="card">
            <?php if($res->num_rows > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card"></i> Client ID</th>
                                <th><i class="fas fa-user"></i> Name</th>
                                <th><i class="fas fa-envelope"></i> Email</th>
                                <th><i class="fas fa-phone"></i> Mobile</th>
                                <th><i class="fas fa-share-alt"></i> Referrals</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                                <th><i class="fas fa-ellipsis-v"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $res->fetch_assoc()): ?>
                                <tr>
                                    <td data-label="Client ID"><?php echo htmlspecialchars($row['client_id']); ?></td>
                                    <td data-label="Name"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td data-label="Email"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td data-label="Mobile"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                    <td data-label="Referrals"><?php echo htmlspecialchars($row['total_referrals']); ?></td>
                                    <td data-label="Status">Active</td>
                                    <td data-label="Actions">
                                        <button onclick="copyEmail('<?php echo htmlspecialchars($row['email']); ?>')" class="btn secondary" style="padding: 4px 8px; font-size: 12px; margin-right: 5px;">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($totalPages > 1): ?>
                    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 25px; flex-wrap: wrap;">
                        <?php for($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search='.urlencode($_GET['search']) : ''; ?>" 
                               class="btn <?php echo $i == $page ? '' : 'secondary'; ?>" 
                               style="padding: 8px 14px;">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: #666;">
                    <i class="fas fa-user-friends" style="font-size: 64px; margin-bottom: 20px; opacity: 0.5;"></i>
                    <h3>No Existing Users</h3>
                    <p style="margin-bottom: 25px;">Users will appear here after registration.</p>
                    <a href="register.php" class="btn">Start Registration</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function copyEmail(email) {
            navigator.clipboard.writeText(email).then(() => {
                const btn = event.target.closest('button');
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                btn.style.background = '#48bb78';
                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.style.background = '';
                }, 2000);
            });
        }
    </script>
</body>
</html>
