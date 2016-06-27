<?php include '../resources/include/header.php'; ?>
<title>Clients</title>
<link rel="stylesheet" href="../resources/css/bootstrap.min.css">
<link rel="stylesheet" href="../resources/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="../resources/css/datepicker.css">
<link rel="stylesheet" href="../resources/css/sb-admin.css">
<link rel="stylesheet" href="../resources/font-awesome/css/font-awesome.min.css">

<script src="../resources/js/jquery.js"></script>
<script src="../resources/js/plugins/dataTables/jquery.dataTables.min.js"></script>
<script src="../resources/js/plugins/dataTables/dataTables.bootstrap.min.js"></script>
<script src="../resources/js/plugins/datePicker/bootstrap-datepicker.js"></script>
<script src="../resources/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
  $('#example').DataTable({
    "order": [[ 2, "desc" ]]
  });

  $('#datepicker').datepicker({
    onRender: function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  },
  format: 'yyyy-mm-dd'
  });
});
</script>


<div id="wrapper">

  <nav class="navbar navbar-inverse navbar-fixed-top " role="navigation">
    <div class="navbar-header" style="margin-left: 45%">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <ul class="nav navbar-right top-nav">
      <li>
        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
      </li>
    </ul>

    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav side-nav ">
<?php
$query=mysqli_query($dbhandle,"select * from workers where worker_id='".$_SESSION["user_id"]."'") or die(mysql_error());
$res=mysqli_fetch_assoc($query);
if($res)
{
 ?>
        <li style="text-align: center; float:none;">
          <img src="../resources/images/<?php echo $res['worker_name'].$res['worker_surname'].".png";?>" alt="image" class="img-circle" style="width: 150px; height: 150px; margin: 20px 0 0 0; ">
        </li>
        <li style="text-align: center; float:none; color:#fff; margin: 20px 0 20px 0; " ><b><?php echo strtoupper($res['worker_name']) ." "; echo strtoupper($res['worker_surname']) ;?></b></li>

        <?php } ;?>

        <li>
          <a href="adminViewEmployees.php?action=display"><i class="fa fa-fw  fa-group"></i> Employees</a>
        </li>

        <li  class="active">
          <a href="adminViewClients.php?action=display"><i class="fa fa-fw  fa-money"></i> Clients </a>
        </li>

        <li>
          <a href="adminViewAccounts.php?action=display"><i class="fa fa-fw  fa-sign-in"></i> Accounts </a>
        </li>
      </ul>
    </div>
  </nav>

  <div id="page-wrapper">
    <div class="container-fluid" style="height: 900px">
      <div class="row">
        <div class="col-lg-4">
          <h1 class="page-header">
            Add or edit client
          </h1>
        </div>
        <div class="col-lg-8">
          <h1 class="page-header">
            Clients overview
          </h1>
        </div>
      </div>
<?php

$editname='';$editsurname='';$editdate='';$editid='';$editcompany='';

if ($_GET['action']=='edit'){
  $sql=mysqli_query($dbhandle,"select * from clients where client_id='".$_GET["editid"]."'") or die(mysql_error());
  $res3=mysqli_fetch_assoc($sql);
  if($res3)
  {
    $editname=$res3['client_name'];
    $editsurname=$res3['client_surname'];
    $editdate=$res3['client_date'];
    $editcompany=$res3['client_firm'];
    $editid=$res3['client_id'];


  }
}
 ?>
      <div class="row">
        <div class="col-lg-4">
          <form method="POST" action='../resources/controller/clientController.php?action=update'>
            <input type="hidden" name="id" value="<?= $editid; ?>"/> <br />

            <div class="form-group">
              <label>Name</label>
              <input  type="text" class="form-control" name="name" value="<?= $editname; ?>">
            </div>

            <div class="form-group">
              <label>Surname</label>
              <input  type="text" class="form-control" name="surname" value="<?= $editsurname; ?>">
            </div>

            <div class="form-group">
              <label>Company</label>
              <input  type="text" class="form-control" name="company" value="<?= $editcompany; ?>">
            </div>

            <div class="input-append date form-group" id="datepicker" >
              <label>Date joined</label>
              <input class="form-control"  type="text" name="date" value="<?= $editdate; ?>">
              <span class="add-on"><i class="icon-th"></i></span>
            </div>
<?php
if ($_GET['action']=='display'){
  $bvalue='Add new client';
}else{
  $bvalue='Update client';
}
 ?>
            <button type="submit" class="btn btn-success col-lg-12"><?=$bvalue?></button>
          </form>
        </div>

        <div class="col-lg-8">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Date joined</th>
                <th>Company</th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
<?php
$query2=mysqli_query($dbhandle,"select * from clients") or die(mysql_error());
//$res2=mysqli_fetch_assoc($query2);
while($res2 = mysqli_fetch_array($query2))
{
 ?>
 <tr>
   <td><?= $res2['client_name']; ?></td>
   <td><?= $res2['client_surname'];?></td>
   <td><?= $res2['client_date']; ?></td>
   <td><?= $res2['client_firm']; ?></td>
   <td><a class="btn btn-danger" href="../resources/controller/clientController.php?action=delete&deleteid=<?= $res2['client_id']?> ">Delete</a></td>
   <td><a class="btn btn-warning" href="adminViewClients.php?action=edit&editid=<?= $res2['client_id']?> ">Edit</a></td>
 </tr>

<?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../resources/include/footer.php'; ?>
