<?php
include("sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Student</title>

<style>

.content{
    margin-left:270px;
    padding:30px;
}

.form-box{
    width:500px;
    margin:auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0px 5px 15px rgba(0,0,0,.2);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

label{
    font-weight:bold;
}

input{

    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;

}

button{

    width:100%;
    padding:12px;
    background:#3498db;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:17px;

}

button:hover{

    background:#2980b9;

}

</style>

</head>

<body>

<div class="content">

<div class="form-box">

<h2>Add Student</h2>

<form action="process.php" method="POST">

<label>Name</label>
<input type="text" name="name" required>

<label>Email</label>
<input type="email" name="email" required>

<label>College</label>
<input type="text" name="college" required>

<label>Branch</label>
<input type="text" name="branch" required>

<button type="submit">Add Student</button>

</form>

</div>

</div>

</body>
</html>