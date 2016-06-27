<?php

include '../include/header.php';
session_start();
$sender=$_SESSION["user_id"] ;
$receiver=$_POST['sendid'];
$message=$_POST['message'];


  $insert="insert into messages(message_sender, message_receiver, message_text, message_date) values (
  '".$sender."','".$receiver."','".$message."', NOW())";

  mysqli_query($dbhandle, $insert);


$whereto=$_GET['sender'];

if($whereto=='worker'){
  header('Location: ../../web/workerViewDash.php');
}elseif ($whereto=='client') {
  header('Location: ../../web/clientViewDash.php');
}elseif ($whereto=='head') {
  header('Location: ../../web/headViewMessages.php?receiver='.$receiver);
}
//}




include '../include/footer.php';
?>
