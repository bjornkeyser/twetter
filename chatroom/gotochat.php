<?php
session_start();
$colors = ["red","green","blue","yellow","brown"];
$_SESSION['c_uname'] = $_POST['c_uname'];
$_SESSION['color'] = array_rand($colors, 1);
header ("Location: chatroom.php");
?>