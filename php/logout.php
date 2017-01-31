<?php
include 'connect.php';
session_start();
$query_status = "UPDATE users SET status = 0 WHERE id = ".$_SESSION['id'];
$result_status = mysqli_query($connection, $query_status);
session_destroy();
header("Location:../index.php");
?>