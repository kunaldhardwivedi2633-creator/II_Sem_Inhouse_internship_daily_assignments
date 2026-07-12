<?php

include("db_connect.php");

// URL se Query ID lena
$id = $_GET['id'];

// Delete hone se pehle Name lena
$get = "SELECT name FROM contact_us WHERE id=$id";
$result = mysqli_query($conn, $get);
$row = mysqli_fetch_assoc($result);

$name = $row['name'];

// Delete Query
$delete = "DELETE FROM contact_us WHERE id=$id";

if(mysqli_query($conn, $delete))
{
    header("Location: admin_queries.php?msg=deleted&name=".$name);
    exit();
}
else
{
    echo "Delete Failed : " . mysqli_error($conn);
}

?>