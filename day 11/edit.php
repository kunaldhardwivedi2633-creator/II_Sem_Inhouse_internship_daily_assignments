<?php

include("db_connect.php");
include("sidebar.php");

// ID lena
$id = $_GET['id'];

// Student Data Fetch
$sql = "SELECT * FROM students WHERE id=$id";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

// Update
if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $college = $_POST['college'];
    $branch = $_POST['branch'];

    $update = "UPDATE students
               SET
               name='$name',
               email='$email',
               college='$college',
               branch='$branch'
               WHERE id=$id";

    if(mysqli_query($conn,$update))
    {
        echo "<script>
        alert('Student Updated Successfully!');
        window.location='students.php';
        </script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Student</title>

<style>

.content{
margin-left:260px;
padding:30px;
}

.form-box{

width:450px;
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 0 10px gray;

}

input{

width:100%;
padding:10px;
margin:10px 0;

}

button{

width:100%;
padding:10px;
background:#3498db;
color:white;
border:none;
cursor:pointer;

}

.back{

display:inline-block;
margin-top:20px;
text-decoration:none;
background:red;
color:white;
padding:10px 15px;

}

</style>

</head>

<body>

<div class="content">

<div class="form-box">

<h2>Edit Student</h2>

<form method="POST">

<input
type="text"
name="name"
value="<?php echo $row['name']; ?>">

<input
type="email"
name="email"
value="<?php echo $row['email']; ?>">

<input
type="text"
name="college"
value="<?php echo $row['college']; ?>">

<input
type="text"
name="branch"
value="<?php echo $row['branch']; ?>">

<button
type="submit"
name="update">

Update Student

</button>

</form>

<a class="back" href="students.php">

⬅ Back

</a>

</div>

</div>

</body>
</html>