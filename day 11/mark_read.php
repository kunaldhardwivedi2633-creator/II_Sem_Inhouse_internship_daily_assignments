<?php

include("db_connect.php");

// URL se ID lena
$id = $_GET['id'];

// Status Update Query
$sql = "UPDATE contact_us 
        SET status='Read' 
        WHERE id=$id";

// Query Execute
if(mysqli_query($conn, $sql))
{
    header("Location: admin_queries.php?msg=read");
    exit();
}
else
{
    echo "Error : " . mysqli_error($conn);
}

?>