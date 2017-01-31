<?php
session_start();
include 'connect.php';
$link = $_POST['link'];
$query_dislikes = "SELECT dislikes FROM cheets WHERE cid =".$_POST['cid'];
$result_dislikes = mysqli_query($connection, $query_dislikes);
$obj_dislikes=mysqli_fetch_object($result_dislikes);
$newdislikes = $obj_dislikes->dislikes + 1;
$query_dislike_2 = "INSERT INTO dislikes (uid, cid) VALUES (".$_SESSION['id'].", ".$_POST['cid'].")";
$result_dislike_2 = mysqli_query($connection, $query_dislike_2);
$query_dislike = "UPDATE cheets SET dislikes = ".$newdislikes." WHERE cid = ".$_POST['cid'];
$result_dislike = mysqli_query($connection, $query_dislike);
header("Location: ".$link);
?>