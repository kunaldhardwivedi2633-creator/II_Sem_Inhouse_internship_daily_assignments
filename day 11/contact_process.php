<?php

include("db_connect.php");

// Form Data
$name = $_POST['name'];
$class = $_POST['class'];
$email = $_POST['email'];
$city = $_POST['city'];
$mobile = $_POST['mobile'];
$college = $_POST['college'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Insert Query
$sql = "INSERT INTO contact_us
(name,class,email,city,`mobile no`,college,subject,message,status)
VALUES
('$name','$class','$email','$city','$mobile','$college','$subject','$message','Unread')";

// Execute Query
if(mysqli_query($conn,$sql))
{
    echo "<script>

    alert('Query Submitted Successfully!');

    window.location='contact.php';

    </script>";
}
else
{
    echo "Error : " . mysqli_error($conn);
}

?>