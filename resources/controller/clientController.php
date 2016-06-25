<?php

include '../include/header.php';
if($_GET['action']=='update'){
$newname=$_POST['name'];
$newsurname=$_POST['surname'];
$newcompany=$_POST['company'];
$newdate=$_POST['date'];

if($_POST['id']==''){
  $sql = "insert into clients (client_name, client_surname, client_date, client_firm) values(
  '".$newname."','".$newsurname."','".$newdate."','".$newcompany."')";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewClients.php?action=display');
  }
}else{
  $sql = "update clients set client_name='".$newname."',client_surname='".$newsurname."',client_firm='".$newcompany."',client_date='".$newdate."' where client_id='".$_POST['id']."'";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewClients.php?action=display');
  }
}
} elseif($_GET['action']=='delete'){
  echo $_GET['deleteid'];
  $sql = "delete from clients where client_id='".$_GET['deleteid']."'";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewClients.php?action=display');
  }
}


include '../include/footer.php';
?>
