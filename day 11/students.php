<?php
include("db_connect.php");
include("sidebar.php");

// Search
if(isset($_GET['search']))
{
    $search = $_GET['search'];

    $sql = "SELECT * FROM students
            WHERE name LIKE '%$search%'
            OR email LIKE '%$search%'
            OR college LIKE '%$search%'
            OR branch LIKE '%$search%'";
}
else
{
    $sql = "SELECT * FROM students ORDER BY id DESC";
}

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>
<head>

<title>Students</title>

<style>

.content{

margin-left:260px;
padding:20px;

}

.search-box{

margin-bottom:20px;

}

.search-box input{

padding:10px;
width:300px;

}

.search-box button{

padding:10px;
background:#3498db;
color:white;
border:none;
cursor:pointer;

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
text-align:center;
border:1px solid #ddd;

}

tr:nth-child(even){

background:#f2f2f2;

}

.edit{

background:green;
color:white;
padding:8px 12px;
text-decoration:none;
border-radius:5px;

}

.delete{

background:red;
color:white;
padding:8px 12px;
text-decoration:none;
border-radius:5px;

}

</style>

</head>

<body>

<div class="content">

<h2>All Students</h2>
<?php

if(isset($_GET['msg']) && $_GET['msg']=="deleted")
{
    echo "<div style='
    background:#f8d7da;
    color:#721c24;
    padding:15px;
    margin-bottom:20px;
    border-radius:5px;
    text-align:center;
    '>

    ✅ Student <b>".$_GET['name']."</b> Deleted Successfully.

    </div>";
}

?>

<form method="GET" class="search-box">

<input
type="text"
name="search"
placeholder="Search Student">

<button type="submit">

Search

</button>

</form>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>College</th>
<th>Branch</th>
<th>Action</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['college']; ?></td>

<td><?php echo $row['branch']; ?></td>

<td>

<a
class="edit"
href="edit.php?id=<?php echo $row['id']; ?>">

Edit

</a>

<a
class="delete"
href="delete.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this student?');">

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