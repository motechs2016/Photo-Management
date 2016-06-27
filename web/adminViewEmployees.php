<?php include '../resources/include/header.php';?>
<title>Employees</title>
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

        <li class="active">
          <a href="adminViewEmployees.php?action=display"><i class="fa fa-fw  fa-group"></i> Employees</a>
        </li>

        <li>
            <a href="adminViewClients.php?action=display"><i class="fa fa-fw  fa-money"></i> Clients </a>
        </li>

        <li>
          <a href="adminViewAccounts.php?action=display"><i class="fa fa-fw  fa-money"></i> Accounts </a>
        </li>
      </ul>
    </div>
  </nav>

  <div id="page-wrapper">
    <div class="container-fluid" style="height: 900px">
      <div class="row">
        <div class="col-lg-4">
          <h1 class="page-header">
            Add or edit employee
          </h1>
        </div>
        <div class="col-lg-8">
          <h1 class="page-header">
            Employees overview
          </h1>
        </div>
      </div>
<?php

$editname='';$editsurname='';$editdate='';$editid='';
$admin='';$head='';$worker='';

if ($_GET['action']=='edit'){
  $sql=mysqli_query($dbhandle,"select * from workers where worker_id='".$_GET["editid"]."'") or die(mysql_error());
  $res3=mysqli_fetch_assoc($sql);
  if($res3)
  {
    $editname=$res3['worker_name'];
    $editsurname=$res3['worker_surname'];
    $editdate=$res3['worker_date'];
    $editid=$res3['worker_id'];

    if($res3['worker_status']=='Head'){
      $head='selected';
    }elseif ($res3['worker_status']=='Admin') {
      $admin='selected';
    }elseif ($res3['worker_status']=='Worker') {
      $worker='selected';
    }
  }
}
 ?>
      <div class="row">
        <div class="col-lg-4">
          <form method="POST" action='../resources/controller/employeeController.php?action=update' enctype="multipart/form-data">
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
              <label>Status</label>
              <select type="text" class="form-control" name="status">
                <option disabled selected value>Select status</option>
                <option value="Worker" <?=$worker;?> >Worker</option>
                <option value="Head" <?=$head;?>>Head</option>
                <option value="Admin" <?=$admin;?>>Admin</option>
              </select>
            </div>

            <div class="input-append date form-group" id="datepicker" >
              <label>Date hired</label>
              <input class="form-control"  type="text" name="date" value="<?= $editdate; ?>">
              <span class="add-on"><i class="icon-th"></i></span>
            </div>

            <div class="form-group">
              <label>Picture</label>
              <input type="file" name="image" />
            </div>
<?php
if ($_GET['action']=='display'){
  $bvalue='Add new employee';
}else{
  $bvalue='Update employee';
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
                <th>Date hired</th>
                <th>Status</th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
<?php
$query2=mysqli_query($dbhandle,"select * from workers") or die(mysql_error());
//$res2=mysqli_fetch_assoc($query2);
while($res2 = mysqli_fetch_array($query2))
{
 ?>
 <tr>
   <td><?= $res2['worker_name']; ?></td>
   <td><?= $res2['worker_surname']; ?></td>
   <td><?= $res2['worker_date']; ?></td>
   <td><?= $res2['worker_status']; ?></td>
   <td><a class="btn btn-danger" href="../resources/controller/employeeController.php?action=delete&deleteid=<?= $res2['worker_id']?> ">Delete</a></td>
   <td><a class="btn btn-warning" href="adminViewEmployees.php?action=edit&editid=<?= $res2['worker_id']?> ">Edit</a></td>
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
