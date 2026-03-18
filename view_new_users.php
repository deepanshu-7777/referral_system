<?php
session_start();
include "db.php";

$res = $conn->query("SELECT * FROM new_users");
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h2>New Users</h2>

<div class="card">
<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>Mobile</th>
<th>Referred By</th>
</tr>

<?php while($row = $res->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['mobile']; ?></td>
<td><?php echo $row['referred_by']; ?></td>
</tr>
<?php } ?>

</table>
</div>
</div>