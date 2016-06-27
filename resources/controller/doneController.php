<?php

include '../include/header.php';

session_start();
$order_id=$_POST['folder'] ;
$photos=intval($_POST['photos']);

$sql="select * from assigns join orders on assigns.order_id=orders.order_id where assigns.order_id='".$order_id."'";
$query=mysqli_query($dbhandle,$sql) or die(mysql_error());
while($res = mysqli_fetch_array($query))
{
  $tot=intval($res['order_photos']);
  $sub=intval($res['assign_done']);

  if($photos>($tot-$sub)){

    header('Location: ../alerts/errorAlert.php?exceed='.($photos-($tot-$sub)));
    echo"TOO MANU PHOTOS exceed by ".($photos-($tot-$sub));
  }else{

    $sqlupdate="update assigns set assign_done='".($sub+$photos)."' where assigns.order_id='".$order_id."'";
    $queryupdate=mysqli_query($dbhandle,$sqlupdate);

    if(($sub+$photos)==$tot){
      $sqldone="update orders set order_status='Done' where orders.order_id='".$order_id."'";
      $sqlcomplete="update assigns set assign_completed=NOW() where assigns.order_id='".$order_id."'";
      $querydone=mysqli_query($dbhandle,$sqldone);
      $querycomplete=mysqli_query($dbhandle,$sqlcomplete);

    }
    header('Location: ../../web/workerViewDash.php');
  }
}

include '../include/footer.php';
?>
