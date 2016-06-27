<?php include '../resources/include/header.php';?>

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
      $('#example').DataTable();
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
      <img src="images/logo.png" alt="image" style="width: 60%; height: 60%; ">
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
          <img src="images/test.jpg" alt="image" class="img-circle" style="width: 150px; height: 150px; margin: 20px 0 0 0; ">
        </li>
        <li style="text-align: center; float:none; color:#fff; margin: 20px 0 20px 0; " ><b><?php echo strtoupper($res['worker_name']) ." "; echo strtoupper($res['worker_surname']) ;?></b></li>

        <?php } ;?>

        <li>
          <a href="adminViewEmployees.php?action=display"><i class="fa fa-fw  fa-group"></i> Employees</a>
        </li>

        <li>
          <a href="adminViewClients.php?action=display"><i class="fa fa-fw  fa-money"></i> Clients </a>
        </li>

        <li class="active">
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
            Add new account
          </h1>
        </div>
        <div class="col-lg-8">
          <h1 class="page-header">
            Accounts overview
          </h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4">
          <form method="POST" action='../resources/controller/accountController.php?action=update'>
            <input type="hidden" name="id" /> <br />

            <div class="form-group">
              <label>Username</label>
              <input  type="text" class="form-control" name="uname" >
            </div>

            <div class="form-group">
              <label>Password</label>
              <input  type="text" class="form-control" name="pass" >
            </div>

            <div class="form-group">
              <label>Status</label>
              <select type="text" class="form-control" name="status">
                <option disabled selected value>Select privilege</option>
                <option value="worker">worker</option>
                <option value="head">head</option>
                <option value="admin">admin</option>
                <option value="client">client</option>
              </select>
            </div>

            <div class="form-group">
              <label>Person</label>
              <select type="text" class="form-control" name="person">
                <option disabled selected value>Select person</option>
                <?php
                $woacc="SELECT worker_id, worker_name, worker_surname FROM workers where worker_id not in (SELECT employee_id from accounts) "
                        ."union "
                        ."SELECT client_id, client_name, client_surname FROM clients where client_id not in (SELECT employee_id from accounts)";
                $query3=mysqli_query($dbhandle,$woacc) or die(mysql_error());

                while($res3 = mysqli_fetch_array($query3))
                {
                 ?>

                 <option value="<?=$res3['worker_id']?>"><?php echo $res3['worker_name']." ".$res3['worker_surname']; ?> </option>
                 <?php } ?>
              </select>
          </div>
<?php
if ($_GET['action']=='display'){
  $bvalue='Add new account';
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
                <th>Username</th>
                <th>Status</th>
                <th>Employee</th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
<?php
$selectall="(select accounts.account_id, accounts.account_uname, accounts.account_pass, accounts.account_status, clients.client_name, clients.client_surname "
        . "from accounts join clients on accounts.employee_id=clients.client_id) "
        . "UNION "
        ."(select accounts.account_id, accounts.account_uname, accounts.account_pass, accounts.account_status, workers.worker_name, workers.worker_surname "
        . "from accounts join workers on accounts.employee_id=workers.worker_id)";
$query2=mysqli_query($dbhandle,$selectall) or die(mysql_error());

while($res2 = mysqli_fetch_array($query2))
{
 ?>
 <tr>
   <td><?= $res2['account_uname']; ?></td>
   <td><?= $res2['account_status'];?></td>
   <td><?php echo $res2[4]." ".$res2[5]; ?></td>
   <td><a class="btn btn-danger" href="../resources/controller/accountController.php?action=delete&deleteid=<?= $res2['account_id']?> ">Delete</a></td>
    <td><a class="btn btn-warning" data-toggle="modal" data-target="#<?php echo $res2[4]."".$res2[5]; ?>">Change password</a></td>
 </tr>
 <!-- Modal -->
 <div class="modal fade" id="<?php echo $res2[4]."".$res2[5]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel">Change password for <?php echo $res2[4]." ".$res2[5]; ?></h4>
       </div>
       <div class="modal-body">

           <form  method="POST" action='../resources/controller/accountController.php?action=edit'>

                       <input  type="hidden" class="form-control" name="id" value="<?= $res2['account_id']?>">
                             <div class="form-group">
                                 <label>New password</label>
                                 <input  type="text" class="form-control" name="newpass" >
                             </div>


       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary">Save changes</button>

            </form>
       </div>
     </div>
   </div>
 </div>


<?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../resources/include/footer.php'; ?>
