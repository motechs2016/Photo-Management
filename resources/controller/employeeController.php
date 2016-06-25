<?php

include '../include/header.php';
if($_GET['action']=='update'){
$newname=$_POST['name'];
$newsurname=$_POST['surname'];
$newstatus=$_POST['status'];
$newdate=$_POST['date'];

if($_POST['id']==''){
  $sql = "insert into workers (worker_name, worker_surname, worker_date, worker_status) values(
  '".$newname."','".$newsurname."','".$newdate."','".$newstatus."')";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewEmployees.php?action=display');
  }
}else{
  $sql = "update workers set worker_name='".$newname."',worker_surname='".$newsurname."',worker_status='".$newstatus."',worker_date='".$newdate."' where worker_id='".$_POST['id']."'";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewEmployees.php?action=display');
  }
}
} elseif($_GET['action']=='delete'){
  echo $_GET['deleteid'];
  $sql = "delete from workers where worker_id='".$_GET['deleteid']."'";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewEmployees.php?action=display');
  }
}


include '../include/footer.php';
?>
