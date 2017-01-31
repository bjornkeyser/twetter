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
      <div class='container' style='margin-top:5vh;'>
        <h1 class='text-center'>Chat room</h1>
        <div class='row'>
          <div class='col-xs-3'></div>
          <div class='col-xs-6'>
            <div class='well' id='chatview'>
            </div>
            <form action='' method='POST'>
              <textarea name="msg" class='form-control' rows='2' size='100' id='msg' maxlength='200' required></textarea>
              <button type='' class='btn btn-info' id='sendmsg'>Send message</button>
            </form>
          </div>
          <div class="col-xs-4">
          </div>
          </form>
        </div>
        <div class='col-xs-3'></div>
      </div>
      </div>
      <?php include '../includes/footer.php'; ?>
<script>
  $(document).ready(function() {
    $("#sendmsg").click(function(e) { //click the send message button
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: 'sendmsg.php',
        data: $('form').serialize(),
      });
      $("#msg").val("");
    });
    
      $.ajax({ //get messages for first time (with scroll)
        url: 'getmsgs.php',
        type: 'post',
        success: function(data) {
          $("#chatview").html(data);
          $("#chatview").scrollTop($('#chatview')[0].scrollHeight);
        }
      });
    var oldscrollHeight = $("#chatview")[0].scrollHeight;
    setInterval(function(){ //every x secs get messages and if there is a new message, scroll to bottom
      getMsgs(); 
    }, 2000);
     function getMsgs() {
      $.ajax({
        url: 'getmsgs.php',
        type: 'post',
        success: function(data) {
          $("#chatview").html(data);
          var newscrollHeight = $("#chatview")[0].scrollHeight;
          if(newscrollHeight > oldscrollHeight){
              $("#chatview").scrollTop($("#chatview")[0].scrollHeight); 
          }
        }
      });
    }
  });
</script>