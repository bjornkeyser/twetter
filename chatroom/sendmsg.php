<?php
session_start();
include "../php/connect.php";
$date = date("Y-m-d H:i:s");
$query_insertmsg = "INSERT INTO chatroom (uid, msg, date) VALUES (".$_SESSION['id'].", '".addslashes(mysqli_real_escape_string($connection, $_POST["msg"]))."', '$date')";
if ($result_insertmsg = mysqli_query($connection, $query_insertmsg)){
  echo "succes";
}
else {
  echo "faal";
}
?>