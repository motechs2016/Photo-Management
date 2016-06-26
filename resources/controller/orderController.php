<?php

include '../include/header.php';
session_start();
if($_GET['action']=='add'){
$folder_name=$_POST['folder_name'];
$folder_photos=$_POST['folder_photos'];
$folder_due=$_POST['folder_due'];
$client_id=$_SESSION['user_id'];


  $sql = "insert into orders(client_id, order_folder, order_due, order_photos, order_submitted, order_status) values (
  '".$client_id."','".$folder_name."','".$folder_due."','".$folder_photos."', CURDATE(), 'Not started')";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/clientViewOrders.php');
  }


} elseif($_GET['action']=='delete'){

  $sql = "delete from orders where order_id='".$_POST['deleteid']."'";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/clientViewOrders.php');
  }
}


include '../include/footer.php';
?>
