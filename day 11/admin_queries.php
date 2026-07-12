<?php

include("db_connect.php");
include("sidebar.php");

$sql = "SELECT * FROM contact_us ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Queries</title>

<style>

.content{
    margin-left:260px;
    padding:20px;
}

h2{
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#3498db;
    color:white;
    padding:12px;
}

td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}

tr:nth-child(even){
    background:#f2f2f2;
}

.read{
    background:green;
    color:white;
    padding:5px 10px;
    border-radius:5px;
}

.unread{
    background:red;
    color:white;
    padding:5px 10px;
    border-radius:5px;
}

.mark{
    background:#28a745;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:5px;
}

.delete{
    background:#dc3545;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:5px;
}

</style>

</head>

<body>

<div class="content">

<h2>Contact Queries</h2>
<?php

// Read Message
if(isset($_GET['msg']) && $_GET['msg']=="read")
{
    echo "<div style='
    background:#d4edda;
    color:#155724;
    padding:15px;
    margin-bottom:15px;
    border-radius:5px;
    text-align:center;
    '>
    ✅ Query Marked as Read Successfully.
    </div>";
}

// Delete Message
if(isset($_GET['msg']) && $_GET['msg']=="deleted")
{
    echo "<div style='
    background:#f8d7da;
    color:#721c24;
    padding:15px;
    margin-bottom:15px;
    border-radius:5px;
    text-align:center;
    '>
    🗑 Query of <b>".$_GET['name']."</b> Deleted Successfully.
    </div>";
}

?>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Class</th>
<th>Email</th>
<th>City</th>
<th>Mobile</th>
<th>College</th>
<th>Subject</th>
<th>Message</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>

</tr>

<?php

while($row = mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['class']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['city']; ?></td>

<td><?php echo $row['mobile no']; ?></td>

<td><?php echo $row['college']; ?></td>

<td><?php echo $row['subject']; ?></td>

<td><?php echo $row['message']; ?></td>

<td>

<?php

if($row['status']=="Unread")
{
    echo "<span class='unread'>Unread</span>";
}
else
{
    echo "<span class='read'>Read</span>";
}

?>

</td>

<td><?php echo $row['created_at']; ?></td>

<td>

<a class="mark"
href="mark_read.php?id=<?php echo $row['id']; ?>">

Mark Read

</a>

<br><br>

<a class="delete"
href="delete_query.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this query?');">

Delete

</a>

</td>

</tr>

<?php

}

?>

</table>

</div>

</body>
</html>