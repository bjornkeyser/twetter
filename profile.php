<?php
session_start();
include 'php/connect.php';
include 'php/cheet.php';
parse_str($_SERVER['QUERY_STRING']);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (!isset($_SESSION['id'])){
  header("Location: ../index.php");
}
$query_verifycode = "SELECT * FROM verify WHERE uid = ".$_SESSION['id'];
$result_verifycode = mysqli_query($connection, $query_verifycode);
$obj_verifycode = mysqli_fetch_object($result_verifycode);
$query = "SELECT * FROM users WHERE id = '$uid'";
$result = mysqli_query($connection, $query, MYSQLI_ASSOC);
if (!$obj = mysqli_fetch_object($result))
	{
	header("Location :404.php");
	}

?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title><?php echo $obj->first." ".$obj->last ?></title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
		<link rel="stylesheet" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link href="bootstrap-tour.min.css" rel="stylesheet">
		<script src="bootstrap.min.js"></script>
		<link rel="shortcut icon" type="image/png" href="favicon.png">
		
			</head>

	<body>
		<script>
			function checkInput(input) {
				var val = input.value.length;

				$("#remaining").text(parseInt($("#cheet").attr("maxlength")) - val + " characters remaining");
			}
		</script>
		<!--Navigation-->
		<?php
include "includes/header.php";

?>
			<!--Container-->
			<div class='container text-center' style='margin-top:5vh;'>	
				<h1>
<?php
	if ($uid === $_SESSION['id']){
		echo "Hi there, ";
	} ?>
				<?=$obj->first?> <?=$obj->last?></h1>
				<h3>
<?php
	if ($ver === $obj_verifycode->code && isset($ver)){
		include 'php/connect.php';
		$query_verify = "UPDATE users SET verified = 2 WHERE id = ".$_SESSION['id'];
		$result_verify = mysqli_query($connection, $query_verify);
		?> <span class='alert alert-success'>Your e-mail is now verified</span>
<?php	} 	
	include 'php/connect.php';
	$obj_updated = mysqli_fetch_object(mysqli_query($connection, "SELECT * FROM users WHERE id = '$uid'"));
	if ($obj_updated->verified === '1' && $obj->id===$_SESSION['id']){ ?>
		<span class='alert alert-danger'>Your e-mail has not yet been verified</span><br>
	<?php }	?>
				</h3>
				<p style='color:grey'>@<?=$obj->uname?></p>
				<div class='row'>
					<div class='col-md-3'>
						<h4>Profile</h4>
						<div class='well' id='profileWell'>
							<?php if ($_SESSION['id']===$uid){ ?>
							<form action='php/changeprofile.php' method='POST'>
								<h5 id='fullName'><?=$obj->first?> <?=$obj->last?></h5>
								<p><button class='btn btn-info' id='changeProfile'>Change profile</button></p>
								<?php  }
						if ($_SESSION['id']!==$uid && checkFollowing($uid, $connection)!==true){ ?>
								<form id='followform' action='php/follow.php' method='POST'>
									<input type='hidden' value='<?= $uid ?>' name='id'>
									<input type='hidden' value='<?= $actual_link ?>' name='link'>
									<button class='btn btn-info' name='follow' type='submit' id='followbtn'>Follow</button>
								</form>
								<?php  } 
									else if ($_SESSION['id']!==$uid && checkFollowing($uid, $connection)!==false) { ?>
										<form action='php/unfollow.php' method='POST'>
											<input type='hidden' value='<?php echo $uid ?>' name='id'>
											<input type='hidden' value='<?= $actual_link ?>' name='link'>
											<button class='btn btn-default' type='submit'>Unfollow</button>
										</form>
						<?php	}?>
								<br>
								<a href='' data-toggle='modal' data-target='#imgModal' id='modal'><img src='uploads/<?=$obj->img?>' id='profilePic' height='100' width='100' alt='Avatar'></a>
								<div id='imgModal' class='modal fade' role='dialog'>
									<span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
									<img class="modal-content" id="img01" src='uploads/<?=$obj->img?>'>
								</div>
								<p id='email'>
									<?=$obj->email?>
								</p>
								<p id='uname'>@<?=$obj->uname?></p>
								<p id='bio'>Bio:
									<?=$obj->bio?>
								</p>
							</form>
							<a href='php/followers.php?uid=<?= $uid ?>'>
								<p id='followers'>Followers:
									<?php echo $obj_followers->followers; ?>
							</a>
							</p>
							<a href='php/following.php?uid=<?= $uid ?>'>
								<p id='following'>Following:
									<?php echo $obj_following->following; ?>
							</a>
							</p>
						</div>
						<div class='well tt'>
							<ul class="list-group">
								<h4>Trending Topic</h4>
								<?= trendingTopic($connection)?>
							</ul>
						</div>
					</div>
					<div class='col-md-6' style='background-color:white'>
						<div class='panel panel-default text-left'>
							<div class='panel-body'>
								<div class='form-group'>
									<form action='<?=postCheet($connection, $obj_users)?>' method='POST'>
										<?php if ($_SESSION['id']===$uid){?>
										<textarea id='cheet' maxlength='200' oninput='checkInput(this)' class='form-control' rows='3' name='cheet' placeholder='How are you?' required></textarea>
										<?php }else{?>
										<textarea id='cheet' maxlength='200' oninput='checkInput(this)' class='form-control' rows='3' name='cheet' required>@<?=$obj->uname?></textarea>
										<?php }
if ($posted == 1){?>
										<div class='alert alert-success alert-dismissable fade in'>
											<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>
											<strong>Success!</strong> You posted chit.
										</div>
										<?php } ?>
										<button class='btn btn-info' type='submit' name='cheetsubmit'>Post chit</button>
										<span id='remaining'>200 characters remaining</span>
									</form>
								</div>
							</div>
						</div>
						<?=getCheets($connection, $obj_users, $result_cheets, $actual_link)?>
					</div>
				<!--</div>-->
				<div class='col-md-3'>
					<div class='list-group'>
						<h4>Popular users</h4>
						<?=popularUsers($connection, $actual_link)?>
					</div>
				</div>
				<!--Footer-->
				<?php
include "includes/footer.php";

?>
		
		<script>
			$(function() {
				$("#changeProfile").on("click", function() {
					$(this).replaceWith("<button class='btn btn-info' type='submit'>Save</button><a href='profile.php?uid=<?= $_SESSION['id'] ?>'>Cancel</a>");
					$("#modal").contents().unwrap();
					$("#profilePic").replaceWith("<img src='uploads/<?=$obj->img?>' id='profilePic' class='img-circle' height='65' width='65' alt='Avatar'><br><form action='php/upload.php' method='POST' enctype='multipart/form-data'>Select image to upload:<input type='file' name='fileToUpload' id='fileToUpload'><input class='btn btn-info' type='submit' value='Upload Image' name='submit'></form'");
					$("#fullName").replaceWith("");
					$("#email").replaceWith("<input placeholder='First name' value='<?= $obj->first ?>' name='first'></input><br><input placeholder='Last name' value='<?= $obj->last ?>' name='last'></input><br><input placeholder='Email' value='<?= $obj->email ?>' name='email'></input>");
					$("#uname").replaceWith("<input placeholder='Username' value='<?= $obj->uname ?>' name='uname'></input>");
					$("#bio").replaceWith("<input placeholder='Bio' value='<?= $obj->bio ?>' name='bio'></input>");
				});
			});
		</script>
	</body>

	</html>