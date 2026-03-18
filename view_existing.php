<?php
session_start();
include "db.php";

$res = $conn->query("SELECT * FROM existing_users");
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h2>Existing Users</h2>

<div class="card">
<table>
<tr>
<th>Client ID</th>
<th>Name</th>
<th>Email</th>
<th>Mobile</th>
<th>Referrals</th>
</tr>

<?php while($row = $res->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['client_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['mobile']; ?></td>
<td><?php echo $row['total_referrals']; ?></td>
</tr>
<?php } ?>

</table>
</div>
</div>