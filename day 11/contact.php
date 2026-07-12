<?php
include("sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us</title>

<style>

.content{
    margin-left:260px;
    padding:20px;
}

.form-box{
    width:500px;
    margin:auto;
    background:white;
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

input,
textarea{

    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

textarea{
    resize:none;
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

<h2>Contact Us</h2>

<form action="contact_process.php" method="POST">

<label>Name</label>
<input type="text" name="name" required>

<label>Class</label>
<input type="text" name="class" required>

<label>Email</label>
<input type="email" name="email" required>

<label>City</label>
<input type="text" name="city" required>

<label>Mobile Number</label>
<input type="text" name="mobile" required>

<label>College</label>
<input type="text" name="college" required>

<label>Subject</label>
<input type="text" name="subject" required>

<label>Message</label>
<textarea name="message" rows="5" required></textarea>

<button type="submit">
Submit Query
</button>

</form>

</div>

</div>

</body>
</html>