<?php
session_start();
include '../php/connect.php';
$query = "SELECT * FROM chatroom JOIN users ON chatroom.uid = users.id ORDER BY date LIMIT 50";
$result = mysqli_query($connection, $query);
while ($obj = mysqli_fetch_object($result)){ ?>
<div class="media" style='font-size: 100%;'>
  <div class="media-left">
    <img src="../uploads/<?= $obj->img ?>" class="media-object" style="width:50px">
  </div>
  <div class="media-body">
    <a href='http://chitchatonline.esy.es/profile.php?uid=<?=$obj->id?>'><h5 class="media-heading"><?php echo $obj->first." ".$obj->last ?></h5></a>
    <a href='http://chitchatonline.esy.es/profile.php?uid=<?=$obj->id?>'><h6>@<?= $obj->uname ?></h6></a>
    
    <p><?= $obj->msg ?></p>
  </div>
</div>
<?php }
?>