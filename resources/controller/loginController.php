<?php
include '../include/header.php';
?>

<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/login.css">
<link rel="stylesheet" href="../css/sweetalert.css">

<script src="../js/sweetalert.min.js"></script>


<script>

    function errorFunction(){
swal({   title: "Wrong username or password",   text: "Try again",   timer: 2000,   showConfirmButton: false });
    }
</script>


<?php

 $name=$_POST['uname'];
 $pass=$_POST['pass'];
 if($name!='' && $pass!='')
 {
   $query=mysqli_query($dbhandle,"select * from accounts where account_uname='".$name."'") or die(mysql_error());
   $res=mysqli_fetch_array($query);
   if($res)
   {
     if(password_verify($pass,$res['account_pass'])){
     session_start();
     $_SESSION["user_id"] = $res['employee_id'];
     if ($res['account_status']=='admin'){
       header('Location: ../../web/adminViewEmployees.php?action=display');

     } elseif ($res['account_status']=='client') {
       header('Location: ../../web/clientViewDash.php');
     }elseif ($res['account_status']=='head') {
       header('Location: ../../web/headViewDash.php');
     }elseif ($res['account_status']=='worker') {
       header('Location: ../../web/workerViewDash.php');
     }
}   else
   {
?>

<script> errorFunction(); </script>

<?php
header( "refresh:2;url=../../index.php" );
    }

   }

 }



include '../include/footer.php';
?>
