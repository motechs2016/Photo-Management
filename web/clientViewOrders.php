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
    "order": [[ 4, "desc" ]]
}
        );

var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

$('#datepicker').datepicker({
onRender: function(date) {
return date.valueOf() < now.valueOf() ? 'disabled' : '';
},
format: 'yyyy-mm-dd'




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
  $query=mysqli_query($dbhandle,"select * from clients where client_id='".$_SESSION["user_id"]."'") or die(mysql_error());
  $res=mysqli_fetch_assoc($query);
  if($res)
  {
  ?>
        <li style="text-align: center; float:none;">
          <img src="images/test.jpg" alt="image" class="img-circle" style="width: 150px; height: 150px; margin: 20px 0 0 0; ">
        </li>
        <li style="text-align: center; float:none; color:#fff; margin: 20px 0 20px 0; " ><b><?php echo strtoupper($res['client_name']) ." "; echo strtoupper($res['client_surname']) ;?></b></li>

        <?php } ;?>

        <li >
          <a href="clientViewDash.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>

        <li class='active'>
          <a href="clientViewOrders.php"><i class="fa fa-fw  fa-edit"></i> Orders </a>
        </li>


      </ul>
    </div>
  </nav>


  <div id="page-wrapper">
    <div class="container-fluid" style="height: 900px">
      <div class="row">
        <div class="col-lg-4">
          <h1 class="page-header">
            Add new order
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
          <form role="form" method='post' action='../resources/controller/orderController.php?action=add'>
            <div class="form-group">
              <label>Folder name</label>
              <input  type="text" class="form-control" name="folder_name">
            </div>

            <div class="form-group">
              <label>Number of photos</label>
              <input  type="number" class="form-control" name="folder_photos">
            </div>

            <div class="input-append date form-group" id="datepicker" >
              <label>Due date</label>
              <input class="form-control"  type="text" name="folder_due">
              <span class="add-on"><i class="icon-th"></i></span>
            </div>

            <button type="submit" class="btn btn-success col-lg-12">Place order</button>
          </form>
        </div>

        <div class="col-lg-8">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Folder</th>
                    <th>Date submitted</th>
                    <th>Due date</th>
                    <th>Photos</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
<?php
$selectall="select * from orders where client_id='".$_SESSION['user_id']."'";
$query2=mysqli_query($dbhandle,$selectall) or die(mysql_error());

while($res2 = mysqli_fetch_array($query2))
{
 ?>
 <tr>
   <td><?= $res2[2]; ?></td>
   <td><?= $res2[3]; ?></td>
   <td><?= $res2[4]; ?></td>
   <td><?= $res2[5]; ?></td>
<?php if ($res2[6]=='Not started'){ ?>
  <td style="cursor: pointer" class="alert alert-danger" data-toggle="modal" data-target="#<?= $res2[0]; ?>"><?= $res2[6]; ?></td>


<div class="modal fade" id="<?= $res2[0]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Are you sure you want to delete <b><?= $res2[2]; ?></b> order?</h4>
      </div>
      <div class="modal-body">
        This action is irreversible.
      </div>
      <form  method="post" action='../resources/controller/orderController.php?action=delete'>
        <input  type="hidden" class="form-control" name="deleteid" value="<?= $res2[0]; ?>">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete order</button>
        </div>
      </form>
    </div>
  </div>
</div>



<?php }elseif($res2[6]=='In progress') {?>
  <td class="alert alert-warning" style="cursor: pointer" class="alert alert-danger" data-toggle="modal" data-target="#<?= $res2[0]; ?>percent"><?= $res2[6]; ?></td>
  <div class="modal fade" id="<?= $res2[0]; ?>percent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Current progress for <b><?= $res2[2]; ?></b></h4>
        </div>
        <div class="modal-body">
          <?php
          $sprogres="select orders.order_photos, assigns.assign_done from orders join assigns on orders.order_id=assigns.order_id where assigns.order_id='".$res2[0]."'";
          $squery=mysqli_query($dbhandle,$sprogres) or die(mysql_error());
          while($sres = mysqli_fetch_array($squery)){
            $tot=intval($sres['order_photos']);
            $done=intval($sres['assign_done']);
            $val=(100*$done)/$tot;
          ?>
          <div class="progress " style="margin-bottom: 0px; background-color:#ddd;">
            <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar"
            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?=$val?>%"></div>
          </div>
          <center> <b><?=$done?> / <?=$tot?></b></center>
          <?php } ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<?php }else{ ?>

  <td class="alert alert-success" style="cursor: pointer"  data-toggle="modal" data-target="#<?= $res2[0]; ?>percent"><?= $res2[6]; ?></td>
  <div class="modal fade" id="<?= $res2[0]; ?>percent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><b><?= $res2[2]; ?></b> folder was completed!</h4>
        </div>
        <div class="modal-body">
          <?php
          $sprogres="select orders.order_photos, assigns.assign_done, assign_completed, worker_name, worker_surname from orders "
                          ."join assigns on orders.order_id=assigns.order_id join workers on assigns.worker_id=workers.worker_id where assigns.order_id='".$res2[0]."'";
          $squery=mysqli_query($dbhandle,$sprogres) or die(mysql_error());
          while($sres = mysqli_fetch_array($squery)){
            $tot=intval($sres['order_photos']);
            $done=intval($sres['assign_done']);
            $val=(100*$done)/$tot;
          ?>
          <div class="progress " style="margin-bottom: 0px; background-color:#ddd;">
            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?=$val?>%"></div>
          </div>
          <br>Completed by <?php echo $sres[3].' '.$sres[4].' on '.$sres[2] ?>
          <?php } ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<?php } ?>



<?php }; //WHILE END?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../resources/include/footer.php'; ?>
