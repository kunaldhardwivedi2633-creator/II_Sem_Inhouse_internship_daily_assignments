<?php
$name = "Kunal Dwivedi";
$college = "SKIT Jaipur";
$branch = "CSE";
?>
<h1>Hello, </=$name /></h1>
<p><?=  $college ?> | <?= $branch ?> | <p><?= $name ?></p>
<?php
date_default_timezone_set("Asia/Kolkata");

echo date("d-m-Y H:i:s");
?>