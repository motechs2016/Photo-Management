<?php include '../resources/include/header.php';?>

<link rel="stylesheet" href="../resources/css/bootstrap.min.css">
<link rel="stylesheet" href="../resources/css/sb-admin.css">
<link rel="stylesheet" href="../resources/font-awesome/css/font-awesome.min.css">

<script src="../resources/js/jquery.js"></script>


<script src="../resources/js/bootstrap.min.js"></script>
<script src="../resources/js/highcharts.js"></script>
<script src="../resources/js/data.js"></script>
<script src="../resources/js/exporting.js"></script>

<script>

$(function () {
    $('#container').highcharts({
        data: {
            table: 'datatable'
        },
        colors: ['#bbdefb', '#42a5f5', '#1976d2'],
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Orders status'
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Units'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.point.y + ' ' + this.point.name.toLowerCase();
            }
        }
    });
});


$(function () {
    $('#chart2').highcharts({
        data: {
            table: 'datatable2'
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthly overview'
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
                    this.point.y + ' in ' + this.point.name;
            }
        }
    });
});

$(document).ready(function() {

$("#mydiv").scrollTop($("#mydiv")[0].scrollHeight);
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

        <li class='active'>
          <a href="clientViewDash.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>

        <li>
          <a href="clientViewOrders.php"><i class="fa fa-fw  fa-edit"></i> Orders </a>
        </li>


      </ul>
    </div>
  </nav>

  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Dashboard <small>Statistics Overview</small>
          </h1>
        </div>
      </div>


      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Orders</h3>
            </div>
            <div class="panel-body" id="chart2">
              <table id="datatable2" style="display: block;">
                <thead>
                  <tr>
                    <th></th>
                    <th>Orders</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $selectbymonths="SELECT ".
                    "IF (MONTH(order_submitted)='01', 'Jan', ".
                    "IF (MONTH(order_submitted)='02', 'Feb', ".
                    "IF (MONTH(order_submitted)='03', 'Mar', ".
                    "IF (MONTH(order_submitted)='04', 'Apr', ".
                    "IF (MONTH(order_submitted)='05', 'May', ".
                    "IF (MONTH(order_submitted)='06', 'Jun', ".
                    "IF (MONTH(order_submitted)='07', 'Jul', ".
                    "IF (MONTH(order_submitted)='08', 'Aug', ".
                    "IF (MONTH(order_submitted)='09', 'Sep', ".
                    "IF (MONTH(order_submitted)='10', 'Oct', ".
                    "IF (MONTH(order_submitted)='11', 'Nov', ".
                    "IF (MONTH(order_submitted)='12', 'Dec','OTHER'))))))))))) ".
                    ") AS Month, count(*) as total from orders where ".
                    "client_id= +'".$_SESSION["user_id"]."' group by MONTH(order_submitted)";
                  $query2=mysqli_query($dbhandle,$selectbymonths) or die(mysql_error());

                  while($res2 = mysqli_fetch_array($query2))
                  {
                   ?>
                   <tr>
                     <td><?= $res2['Month']; ?></td>
                     <td><?= $res2[1]; ?></td>
                   </tr>
                  <?php }; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa  fa-adjust fa-fw"></i> Statistics  </h3>
            </div>
            <div class="panel-body" id="container">
              <table id="datatable" style="display: block;">
                <thead>
                  <tr>
                    <th></th>
                    <th>Orders </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $selectbyprogress="SELECT order_status, count(*) as total from orders where (order_status='In progress' OR order_status='Not started' OR order_status='Done') "
                  . "AND client_id= +'".$_SESSION["user_id"]."' group by order_status";

                  $query3=mysqli_query($dbhandle,$selectbyprogress) or die(mysql_error());

                  while($res3 = mysqli_fetch_array($query3))
                  {
                   ?>
                   <tr>
                     <td><?= $res3['order_status']; ?></td>
                     <td><?= $res3[1]; ?></td>
                   </tr>
                  <?php }; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

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
            <div class="panel-body" id="mydiv" style="height: 250px; overflow:auto;">
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
                    <img src="images/<?php echo $res5[1]."".$res5[2];?>.png" alt="User Avatar" class="img-circle" style="width: 65px; height: 65px; margin-right: 15px; margin-bottom: 10px">
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
                <form method="POST" action='../resources/controller/messageController.php?sender=client'>
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
                <h3 class="panel-title"><i class="fa fa-check-circle fa-fw"></i> Last completed orders</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Folder name</th>
                        <th>Submitted date</th>
                        <th>Completed date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sqlrecent="select order_folder, order_submitted, assign_completed from assigns join orders ".
                                 "on assigns.order_id=orders.order_id where order_status='Done' and orders.client_id='".$_SESSION["user_id"].
                                 "' order by assign_completed desc LIMIT 5";
                      $queryn=mysqli_query($dbhandle,$sqlrecent) or die(mysql_error());

                      while($resn = mysqli_fetch_array($queryn))
                      {
                       ?>
                       <tr>
                         <td><?= $resn['order_folder']; ?></td>
                         <td><?= $resn['order_submitted']; ?></td>
                         <td><?= $resn['assign_completed']; ?></td>
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
