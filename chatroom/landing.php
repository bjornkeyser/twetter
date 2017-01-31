<?php
session_start();
parse_str($_SERVER['QUERY_STRING']);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Chat room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link rel="shortcut icon" type="image/png" href="favicon.png">
 
	</head>

  <body>
    <?php
include "../includes/header.php";
    ?>
      <div class='container text-center' style='margin-top:5vh;'>
        <div class='row'>
          <div class='col-xs-3'></div>
          <div class='col-xs-6'>
            <form action='gotochat.php' method='POST' style='margin-top:5vh;'>
              <h1 style='font-size: 400%'>Choose a username</h1>
              <div class="input-group">
                <input type="text" class="form-control" name="c_uname" placeholder="Username" size='100'>
              </div>
                <button class='btn btn-info' type='submit'>Go</button>
              </div>
              <div class="col-xs-4">
              </div>
            </form>
          </div>
          <div class='col-xs-3'></div>
        </div>
      </div>
		<?php include '../includes/footer.php'; ?>


