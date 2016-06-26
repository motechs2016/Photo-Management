<?php

include '../include/header.php';
if($_GET['action']=='update'){
$newuname=$_POST['uname'];
$newpass=$_POST['pass'];
$newstatus=$_POST['status'];
$newperson=$_POST['person'];

if($_POST['id']==''){
  $sql = "insert into accounts (account_uname, account_pass, account_status, employee_id) values(
  '".$newuname."','".$newpass."','".$newstatus."','".$newperson."')";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewAccounts.php?action=display');
  }
}

} elseif($_GET['action']=='delete'){
  echo $_GET['deleteid'];
  $sql = "delete from accounts where account_id='".$_GET['deleteid']."'";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewAccounts.php?action=display');
  }
}elseif($_GET['action']=='edit'){
  $hashed=password_hash($_POST['newpass'], PASSWORD_DEFAULT);
  $sql = "update accounts set account_pass='".$hashed."' where account_id='".$_POST['id']."'";
  if (mysqli_query($dbhandle, $sql)) {
      header('Location: ../../web/adminViewAccounts.php?action=display');
  }
}


include '../include/footer.php';
?>
