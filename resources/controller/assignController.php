<?php

include '../include/header.php';
session_start();

$order=$_POST['order_id'];
$worker=$_POST['worker_id'];

$progress="UPDATE orders SET order_status='In progress' WHERE order_id='".$order."'";
mysqli_query($dbhandle, $progress);

$assign="insert into assigns(order_id, worker_id) values ('".$order."','" .$worker."')";
$update=mysqli_query($dbhandle, $assign);
  if($update){


  header('Location: ../../web/headViewOrders.php');

}



include '../include/footer.php';
?>
