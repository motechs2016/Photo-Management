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

      if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

      $expensions= array("jpeg","jpg","png");

      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }

      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }

      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"../images/image".$newname.$newsurname.".png");
         echo "Success";
      }else{
         print_r($errors);
      }
   }


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
