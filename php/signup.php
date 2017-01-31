<?php
session_start();
include "connect.php";

$first = addslashes(mysqli_real_escape_string($connection, $_POST["first"]));
$last = addslashes(mysqli_real_escape_string($connection, $_POST["last"]));
$uname = addslashes(mysqli_real_escape_string($connection, $_POST["uname"]));
$pwd = addslashes(mysqli_real_escape_string($connection, $_POST["pwd"]));
$pwdconf = addslashes(mysqli_real_escape_string($connection, $_POST["pwdconf"]));
$email = addslashes(mysqli_real_escape_string($connection, $_POST["email"]));
//$row=mysqli_fetch_object($result);
$query_unamecheck = "SELECT * FROM users WHERE uname = '$uname'";
$result_unamecheck = mysqli_query($connection, $query_unamecheck);
if (mysqli_num_rows($result_unamecheck) !== 0) {
 echo "Username already exists"; 
}
$query_emailcheck = "SELECT * FROM users WHERE email = '$email'";
$result_emailcheck = mysqli_query($connection, $query_emailcheck);
if (mysqli_num_rows($result_emailcheck) !== 0) {
 echo "Email already taken"; 
}
else if ($pwd===$pwdconf){
  session_start();
  include 'connect.php';
  $hashed=md5($pwd);
  $query = "INSERT INTO users (last, first, pwd, uname, email, verified) VALUES ('$last', '$first', '$hashed', '$uname', '$email', 1)";
  $result = mysqli_query($connection, $query);
  $obj = mysqli_fetch_object($result);
  $query2 = "SELECT * FROM users WHERE uname = '$uname' AND pwd = '$hashed'";
  $result2 = mysqli_query($connection, $query2);
  $obj2 = mysqli_fetch_object($result2);
  $code = substr(md5(rand()), 0, 7);
  $query3 = "INSERT INTO verify (uid, code) VALUES ('$obj2->id', '$code')";
  $result3 = mysqli_query($connection, $query3);
  $_SESSION["id"]=$obj2->id;
  $_SESSION["first"]=$obj2->first;
  $query_status = "UPDATE users SET status = 1 WHERE id = ".$_SESSION['id'];
  $result_status = mysqli_query($connection, $query_status);
  header("Location: ../profile.php?uid=".$_SESSION["id"]);
  $headers  = "From: Bjorn < noreply@bjornisawesome.com >\n";
  $headers .= "Cc: Bjorn < noreply@bjornisawesome.com >\n"; 
  $headers .= "X-Sender: Bjorn < noreply@bjornisawesome.com >\n";
  $headers .= 'X-Mailer: PHP/' . phpversion();
  $headers .= "X-Priority: 1\n"; // Urgent message!
  $headers .= "Return-Path: noreply@bjornisawesome.com\n"; // Return path for errors
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
  $msg = "<html><body style='font-size:120%'>";
  $msg .= "Dear $first, <br><br>";
  $msg .= "Please verify your email:";
  $msg .= "<a href='http://chitchatonline.esy.es/profile.php?uid=".$_SESSION['id']."&ver=".$code."'>Click this link</a><br><br>";
  $msg .= "Yours sincerely, Bjorn</body></html>";
  mail($email,"Verify your email",$msg, $headers);
  }
else {
  echo "Passwords were not the same";
}
?>