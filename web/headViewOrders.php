<?php include '../resources/include/header.php'; session_start();?>

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
          "lengthMenu": [ 15,25,50],
         "order": [[ 6, "desc" ]]
      }
              );
  $('#datepicker').datepicker({
      format: 'mm/dd/yyyy'
  });
  } );

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

        <li >
          <a href="headViewDash.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>

        <li class='active'>
          <a href="headViewOrders.php"><i class="fa fa-fw  fa-edit"></i> Orders </a>
        </li>

        <?php
        $sqls="SELECT message_receiver from messages where message_sender='".$_SESSION["user_id"]."'"." order by message_date desc limit 1";
        $querys=mysqli_query($dbhandle, $sqls);
        while($ress=mysqli_fetch_array($querys)){
          $lastsender=$ress[0];
        }
        ?>
          
        <li>
          <a href="headViewMessages.php?sendid=<?=$lastsender?>"><i class="fa fa-fw  fa-list-alt"></i> Messages </a>
        </li>

        <li>
          <a href="headViewReports.php"><i class="fa fa-fw  fa-comments"></i> Reports </a>
        </li>



      </ul>
    </div>
  </nav>


  <div id="page-wrapper">
    <div class="container-fluid" style="height: 900px">
      <div class="row">
        <div class="col-lg-4">
          <h1 class="page-header">
            Assign folders
          </h1>
        </div>
        <div class="col-lg-8">
          <h1 class="page-header">
            Orders overview
          </h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4">
          <form method="POST" action='../resources/controller/assignController.php'>
            <div class="form-group">
              <label>Folder name</label>
              <select class="form-control" name="order_id">
                <option selected disabled hidden style='display: none' value=''></option>
                <option selected disabled hidden style='display: none' value=''></option>

                <?php
                $woacc='select * from orders where order_status=\'Not started\' ';
                $query3=mysqli_query($dbhandle,$woacc) or die(mysql_error());

                while($res3 = mysqli_fetch_array($query3))
                {
                 ?>

                 <option value="<?=$res3['order_id']?>"><?php echo $res3['order_folder']?> </option>
                 <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <label>Folder name</label>
              <select class="form-control" name="worker_id">
                <option selected disabled hidden style='display: none' value=''></option>
                <?php
                $select_emp="select * from workers where worker_status='Worker'";
                $query_emp=mysqli_query($dbhandle,$select_emp) or die(mysql_error());

                while($res_emp = mysqli_fetch_array($query_emp))
                {
                 ?>

                 <option value="<?=$res_emp['worker_id']?>"><?php echo $res_emp['worker_name'].' '.$res_emp['worker_surname']?> </option>
                 <?php } ?>
              </select>
            </div>



            <button type="submit" class="btn btn-success col-lg-12">Place order</button>
          </form>
        </div>

        <div class="col-lg-8">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                       <tr>
                           <th>Folder</th>
                           <th>Client name</th>
                           <th>Submitted</th>
                           <th>Due date</th>
                           <th>Employee</th>
                           <th>Progress</th>
                           <th>Status</th>
                       </tr>
                   </thead>

            <tbody>
<?php
$selectall="SELECT orders.order_folder, clients.client_name, clients.client_surname, orders.order_submitted, orders.order_due, ".
"workers.worker_name, workers.worker_surname, orders.order_photos, assigns.assign_done, orders.order_status ".
"FROM orders ".
"LEFT JOIN assigns ".
"ON assigns.order_id=orders.order_id ".
"LEFT JOIN workers ".
"ON assigns.worker_id=workers.worker_id ".
"LEFT JOIN clients ".
"ON orders.client_id=clients.client_id";
$query2=mysqli_query($dbhandle,$selectall) or die(mysql_error());

while($res2 = mysqli_fetch_array($query2))
{

  $style='';$bar='';
  if($res2['order_status']=='Not started') $style="alert alert-danger";
  if($res2['order_status']=='In progress') {$style="alert alert-warning"; $bar='progress-bar-warning';}
  if($res2['order_status']=='Done') {$style="alert alert-success";$bar='progress-bar-success';}
 ?>
 <tr>
   <td><?= $res2['order_folder']; ?></td>
   <td><?php echo $res2['client_name'].' '.$res2['client_surname']; ?></td>
   <td><?= $res2['order_submitted']; ?></td>
   <td><?= $res2['order_due']; ?></td>
   <?php if ($res2['worker_name']==''){ ?>
     <td></td>
    <?php }else{ ?>
    <td><?php echo $res2['worker_name'].' '.$res2['worker_surname']; ?></td>
    <?php };?>
    <?php
    $tot=intval($res2['order_photos']);
    $done=intval($res2['assign_done']);
    $val=(100*$done)/$tot;
    ?>
    <?php
      if($res2['order_status']=='Not started'){
     ?>
        <td></td>
    <?php  }else{?>

      <td>
        <div class="progress " style="margin-bottom: 0px; background-color:#ddd;">
            <div class="progress-bar <?=$bar?> progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?=$val?>%"></div>
        </div>
      </td>

    <?php }; ?>
    <td class='<?=$style?>'><?= $res2['order_status']; ?></td>



<?php }; //WHILE END?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../resources/include/footer.php'; ?>
