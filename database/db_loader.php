<?php require_once("db_config.php"); ?>

<?php
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysqli_error());

$db = mysqli_select_db($con, DB_DATABASE) or die(mysqli_error()) or die(mysqli_error());

$con->set_charset("utf8");

?>