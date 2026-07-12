<?php
include("sidebar.php");
include("db_connect.php");

// Total Students
$student = mysqli_query($conn,"SELECT * FROM students");
$total_students = mysqli_num_rows($student);

// Total Queries
$query = mysqli_query($conn,"SELECT * FROM contact_us");
$total_queries = mysqli_num_rows($query);

// Read Queries
$read = mysqli_query($conn,"SELECT * FROM contact_us WHERE status='Read'");
$total_read = mysqli_num_rows($read);

// Unread Queries
$unread = mysqli_query($conn,"SELECT * FROM contact_us WHERE status='Unread'");
$total_unread = mysqli_num_rows($unread);

?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard</title>

<style>

.content{
    margin-left:270px;
    padding:20px;
}

h1{
    margin-bottom:30px;
}

.card-box{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.card{

    width:220px;
    padding:20px;
    color:white;
    border-radius:10px;
    text-align:center;
    font-size:20px;
    box-shadow:0 5px 10px rgba(0,0,0,.2);

}

.blue{
    background:#3498db;
}

.green{
    background:#27ae60;
}

.orange{
    background:#f39c12;
}

.red{
    background:#e74c3c;
}

.card h2{

    font-size:40px;
    margin-top:10px;

}

</style>

</head>

<body>

<div class="content">

<h1>Admin Dashboard</h1>

<div class="card-box">

<div class="card blue">

Total Students

<h2><?php echo $total_students; ?></h2>

</div>

<div class="card green">

Total Queries

<h2><?php echo $total_queries; ?></h2>

</div>

<div class="card orange">

Read Queries

<h2><?php echo $total_read; ?></h2>

</div>

<div class="card red">

Unread Queries

<h2><?php echo $total_unread; ?></h2>

</div>

</div>

</div>

</body>
</html>