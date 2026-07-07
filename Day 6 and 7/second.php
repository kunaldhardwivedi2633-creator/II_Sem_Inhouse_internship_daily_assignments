<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        <?php echo "hello world" ?>

    </h1>
    <p>this is a pragraph</p>
    <h2><?php echo "kunal dhar" ?></h2>
    <?php
    $name="rahul";
    ?>
    <h3><?php echo $name; ?></h3> 
    <?php
    $student = ["rahul" , "anan" , "jatin"];
    echo  $student[0];
     echo "<br>";
    echo  $student[1];
    echo "<br>";
    echo  $student[2];
    echo "<br>";
    ?>
    <?php
date_default_timezone_set("Asia/Kolkata");

echo date("d-m-Y H:i:s");
?>
</body>
</html>