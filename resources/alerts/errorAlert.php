<?php
include '../include/header.php';
?>
<link rel="stylesheet" href="../css/sweetalert.css">

<script src="../js/sweetalert.min.js"></script>


<script>

    function errorFunction(){
swal({   title: "Wrong number of photos",   text: "Exceeded by <?=$_GET['exceed']?>",   type:"warning", timer: 2000,   showConfirmButton: false });
    }
</script>

<script> errorFunction(); </script>

<?php
header( "refresh:2;url=../../web/workerViewDash.php" );




include '../include/footer.php';
?>
