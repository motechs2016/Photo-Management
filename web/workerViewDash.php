<?php include '../resources/include/header.php';?>
<title>Dashboard</title>
<link rel="stylesheet" href="../resources/css/bootstrap.min.css">
<link rel="stylesheet" href="../resources/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="../resources/css/sb-admin.css">
<link rel="stylesheet" href="../resources/font-awesome/css/font-awesome.min.css">


<script src="../resources/js/jquery.js"></script>
<script src="../resources/js/plugins/dataTables/jquery.dataTables.min.js"></script>
<script src="../resources/js/plugins/dataTables/dataTables.bootstrap.min.js"></script>
<script src="../resources/js/bootstrap.min.js"></script>
<script src="../resources/js/highcharts.js"></script>
<script src="../resources/js/data.js"></script>
<script src="../resources/js/exporting.js"></script>

<script>
    $(document).ready(function() {

    $("#idk").scrollTop($("#idk")[0].scrollHeight);
    } );

   $(function () {
   $('#container').highcharts({
       data: {
           table: 'datatable'
       },
       chart: {
           type: 'line'
       },
       title: {
           text: 'Number of photos done per month'
       },
       yAxis: {
           allowDecimals: false,
           title: {
               text: 'Number'
           }
       },
       tooltip: {
           formatter: function () {
               return '<b>' + this.series.name + '</b><br/>' +
                   this.point.y + ' photos in ' + this.point.name.toLowerCase();
           }
       }
   });
});


</script>
<script>
$(document).ready(function() {
   $('#example').DataTable({
       "lengthMenu": [ 5],
        "order": [[ 7, "desc" ]]
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

        <li class='active'>
          <a href="workerViewDash.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>


      </ul>
    </div>
  </nav>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">

        <div class="col-lg-4">
                        <h1 class="page-header">
                            Photos done
                        </h1>
                    </div>

                                        <div class="col-lg-8">
                        <h1 class="page-header">
                            Folders overview
                        </h1>
                    </div>
      </div>



      <div class="row">
        <div class="col-lg-4" style="margin-top: 20px">
          <form method="POST" action='../resources/controller/doneController.php'>
            <div class="form-group">
              <label>Folder name</label>
                <select class="form-control" name="folder">
                  <option selected disabled hidden style='display: none' value=''></option>

                  <?php
                  $woacc="select * from assigns "
                          . "inner join orders on assigns.order_id=orders.order_id where worker_id='".$_SESSION['user_id']."' AND order_status='In progress'";
                  $query3=mysqli_query($dbhandle,$woacc) or die(mysql_error());

                  while($res3 = mysqli_fetch_array($query3))
                  {
                   ?>

                   <option value="<?=$res3['order_id']?>"><?php echo $res3['order_folder']?> </option>
                   <?php } ?>
                </select>
            </div>
            <div class="form-group">
              <label>Photos done</label>
              <input type="number" class="form-control" name="photos">
            </div>
            <button type="submit" class="btn btn-primary col-lg-12">Submit photos</button>
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
                <th>Total photos</th>
                <th>Photos done</th>
                <th>Progress</th>
                <th>Status</th>
              </tr>
            </thead>

            <tbody>
<?php

$selectall="SELECT orders.order_folder, clients.client_name, clients.client_surname, orders.order_submitted, orders.order_due,".
"workers.worker_name, workers.worker_surname, orders.order_photos, assigns.assign_done, orders.order_status " .
"FROM orders ".
"LEFT JOIN assigns ".
"ON assigns.order_id=orders.order_id ".
"LEFT JOIN workers ".
"ON assigns.worker_id=workers.worker_id ".
"LEFT JOIN clients ".
"ON orders.client_id=clients.client_id "
. "WHERE assigns.worker_id='".$_SESSION['user_id']."'";
$query2=mysqli_query($dbhandle,$selectall) or die(mysql_error());

while($res2 = mysqli_fetch_array($query2))
{
  if($res2['order_status']=='Not started') $cls="alert alert-danger";
  if($res2['order_status']=='In progress') $cls="alert alert-warning";
  if($res2['order_status']=='Done') $cls="alert alert-success";
 ?>
 <tr>
   <td><?=$res2['order_folder']?></td>
   <td><?php echo $res2['client_name']." ".$res2['client_surname']?></td>
   <td><?=$res2['order_submitted']?></td>
   <td><?=$res2['order_due']?></td>
   <?php if ($res2['order_status']=='Done'){ ?>
  <td><?=$res2["order_photos"]?></td>
  <td><?=$res2["assign_done"]?></td>
  <td>
    <div class="progress " style="margin-bottom: 0px; background-color:#ddd;">
      <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
    </div>
  </td>
  <td class="<?=$cls?>"><?=$res2["order_status"]?></td>

  <?php }else if($res2['order_status']=='In progress'){;
    $tot=intval($res2['order_photos']);
    $done=intval($res2['assign_done']);
    $val=(100*$done)/$tot;
    ?>
    <td><?=$tot?></td>
    <td><?=$res2['assign_done']?></td>
    <td>
      <div class="progress " style="margin-bottom: 0px; background-color:#ddd;">
        <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?=$val?>%"></div>
      </div>
    </td>
    <td class="<?=$cls?>"><?=$res2["order_status"]?></td>
    <?php }; ?>
 </tr>
<?php }; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row" style="margin-top: 20px; margin-bottom: 20px"></div>

      <div class="row">
        <div class="col-lg-6">
          <div class="chat-panel panel panel-default" >
            <div class="panel-heading">
              <i class="fa fa-comments fa-fw"></i>
              Chat
              <div class="btn-group pull-right">
                <button type="button" class="btn btn-default btn-xs " >
                <i class="fa fa-refresh fa-fw"></i>
              </div>
            </div>
            <div class="panel-body" id="idk" style="height: 250px; overflow:auto;">
              <ul class="chat" style="list-style-type:none">
                <?php
                $smessages="select * from messages where ".
                "message_sender='".$_SESSION["user_id"]."' OR message_receiver='".$_SESSION["user_id"]."' ORDER BY message_date";
                $query4=mysqli_query($dbhandle,$smessages) or die(mysql_error());

                while($res4 = mysqli_fetch_array($query4))
                {
                  $mrecepient="(select * from workers where worker_id=".$res4[1].
                  ") UNION (select * from clients where client_id=".$res4[1].")";
                  $query5=mysqli_query($dbhandle,$mrecepient) or die(mysql_error());
                  if($res5=mysqli_fetch_array($query5)){

                 ?>
                 <li class="left clearfix">
                  <span class="chat-img pull-left">
                    <img src="../resources/images/<?php echo $res5[1]."".$res5[2];?>.png" alt="User Avatar" class="img-circle" style="width: 65px; height: 65px; margin-right: 15px; margin-bottom: 10px">
                  </span>
                  <div class="chat-body clearfix" style="margin-top: 10px">
                    <div class="header">
                      <strong class="primary-font"><?php echo $res5[1]." ".$res5[2];?></strong>
                    </div>
                    <p>
                      <?=$res4[3];?>
                    </p>
                     </div>
                 </li>
                <?php }}; ?>

                <?php
                  $msendto="select * from workers where worker_status='Head'";
                  $query6=mysqli_query($dbhandle,$msendto) or die(mysql_error());
                  $to='';
                  if($res6=mysqli_fetch_array($query6)){
                    $to=$res6[0];
                  }
                 ?>
               </ul>
              </div>
              <div class="panel-footer">
                <form method="POST" action='../resources/controller/messageController.php?sender=worker'>
                  <div class="input-group">
                    <input  type="hidden" value="<?=$to?>" name="sendid">
                    <input  type="text" class="form-control input-sm" placeholder="Type your message here..." name="message">
                    <span class="input-group-btn">
                      <button type='submit' class="btn btn-primary btn-sm" id="btn-chat">
                      Send
                      </button>
                    </span>
                  </div>
                </form>
              </div>
            </div>

          </div>



          <div class="col-lg-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Photos Statistics</h3>
              </div>
              <div class="panel-body" >
                <div class="panel-body" id="container" >
                  <table id="datatable" style="display: block;">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Photos</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      $photosdone="SELECT ".
                            "IF (MONTH(assign_completed)='01', 'Jan', ".
                            "IF (MONTH(assign_completed)='02', 'Feb', ".
                            "IF (MONTH(assign_completed)='03', 'Mar', ".
                            "IF (MONTH(assign_completed)='04', 'Apr', ".
                            "IF (MONTH(assign_completed)='05', 'May', ".
                            "IF (MONTH(assign_completed)='06', 'Jun', ".
                            "IF (MONTH(assign_completed)='07', 'Jul', ".
                            "IF (MONTH(assign_completed)='08', 'Aug', ".
                            "IF (MONTH(assign_completed)='09', 'Sep', ".
                            "IF (MONTH(assign_completed)='10', 'Oct', ".
                            "IF (MONTH(assign_completed)='11', 'Nov', ".
                            "IF (MONTH(assign_completed)='12', 'Dec','OTHER'))))))))))) ".
                            ") AS Month, sum(assign_done) as total from assigns where ".
                            "worker_id= +'".$_SESSION['user_id']."' AND assign_completed IS NOT NULL  group by MONTH(assign_completed)";

                      $query=mysqli_query($dbhandle,$photosdone) or die(mysql_error());

                      while($res = mysqli_fetch_array($query))
                      {

                       ?>
                       <tr>
                         <td><?=$res[0]?></td>
                         <td><?=$res[1]?></td>
                       </tr>
                      <?php }; ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



<?php include '../resources/include/footer.php'; ?>
