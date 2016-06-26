<?php

include '../include/header.php';
session_start();
$sender=$_SESSION["user_id"] ;
$receiver=$_POST['sendid'];
$message=$_POST['message'];

$sql="select * from workers where worker_status='Head'";
if (mysqli_query($dbhandle, $sql)){
  $insert="insert into messages(message_sender, message_receiver, message_text, message_date) values (
  '".$sender."','".$receiver."','".$message."', NOW())";

  if (mysqli_query($dbhandle, $insert)){
    if($res6=mysqli_fetch_array($sql)==$sender){
      header('Location: ../../web/headViewMessages.php?sendid='.$receiver);}elseif(intval($sender)>1000){
        header('Location: ../../web/clientViewDash.php');
      }
  }
}




include '../include/footer.php';
?>
