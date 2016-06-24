<?php
include '../include/header.php';



 $name=$_POST['uname'];
 $pass=$_POST['pass'];
 if($name!='' && $pass!='')
 {
   $query=mysqli_query($dbhandle,"select * from accounts where account_uname='".$name."' and account_pass='".$pass."'") or die(mysql_error());
   $res=mysqli_fetch_assoc($query);
   if($res)
   {

     if ($res['account_status']=='admin'){
       echo "THIS IS ADMIN";
     } elseif ($res['account_status']=='client') {
       echo "THIS IS CLIENT";
     }elseif ($res['account_status']=='head') {
       echo "THIS IS HEAD";
     }elseif ($res['account_status']=='worker') {
       echo "THIS IS WORKER";
     }


   }
   else
   {
    echo'You entered username or password is incorrect';
   }
 }
 else
 {
  echo'Enter both username and password';
 }


include '../include/footer.php';
 ?>
