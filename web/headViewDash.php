<?php include '../resources/include/header.php'; ?>
<title>Dashboard</title>
<link rel="stylesheet" href="../resources/css/bootstrap.min.css">
<link rel="stylesheet" href="../resources/css/sb-admin.css">
<link rel="stylesheet" href="../resources/font-awesome/css/font-awesome.min.css">

<script src="../resources/js/jquery.js"></script>
<script src="../resources/js/bootstrap.min.js"></script>
<script src="../resources/js/highcharts.js"></script>
<script src="../resources/js/highcharts-3d.js"></script>
<script src="../resources/js/data.js"></script>
<script src="../resources/js/exporting.js"></script>

<script>
        $(function () {
    $('#container').highcharts({
        data: {
            table: 'datatable'
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Orders per clients'
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Number of orders'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.point.y + ' by ' + this.point.name.toUpperCase();
            }
        }
    });
});

$(function () {
    $('#container2').highcharts({
        data: {
            table: 'datatable2'
        },
        chart: {
            type: 'line'
        },
        title: {
            text: 'Orders per months'
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Number of orders'
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

$(function () {
    $('#container3').highcharts({
        data: {
            table: 'datatable3'
        },
        chart: {
            type: 'column',
                options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'Currently working on orders'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Orders in progress'
            }
        },
        tooltip: {
            formatter: function () {
                return '<center><b>' + this.series.name + '</b></center><br/>' +
                    this.point.y + ' is being done by <br>' + this.point.name;
            }
        }
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

        <li class='active'>
          <a href="headViewDash.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>

        <li>
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
              <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Clients statistics</h3>
            </div>
            <div class="panel-body" id="container">
              <table id="datatable" style="display: block;">
                <thead>
                  <tr>
                    <th></th>
                    <th>Orders</th>
                  </tr>
                </thead>
                <tbody>

                    <?php
                    $orderssql="SELECT client_name, client_surname, COUNT(*) FROM orders join clients on orders.client_id=clients.client_id group by orders.client_id";
                    $orderquery=mysqli_query($dbhandle, $orderssql);
                    while($orderres=mysqli_fetch_array($orderquery)){
                    ?>
                    <tr>
                      <td><?php echo $orderres[0]." ".$orderres[1] ?></td>
                      <td><?= $orderres[2] ?></td>
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
              <h3 class="panel-title"><i class="fa fa-external-link fa-fw"></i>Orders Statistics</h3>
            </div>
            <div class="panel-body" id="container2">
              <table id="datatable2" style="display: block;">
                <thead>
                  <tr>
                    <th></th>
                    <th>Orders</th>
                  </tr>
                </thead>
                <tbody>

                    <?php
                    $amsql="SELECT ".
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
                              ") AS Month, count(*) as total from orders group by MONTH(order_submitted)";
                    $amquery=mysqli_query($dbhandle, $amsql);
                    while($amres=mysqli_fetch_array($amquery)){
                    ?>
                    <tr>
                      <td><?= $amres[0] ?></td>
                      <td><?= $amres[1] ?></td>
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
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>Employees statistics</h3>
            </div>
            <div class="panel-body" id="container3">
              <table id="datatable3" style="display: block;">
                <thead>
                  <tr>
                    <th></th>
                    <th>In progress</th>
                  </tr>
                </thead>
                <tbody>

                    <?php
                    $empsql="(SELECT workers.worker_name, workers.worker_surname, count(*) from assigns join workers on "
                    ."assigns.worker_id=workers.worker_id where assign_completed is null "
                    ."group by workers.worker_id) union "
                    ."(SELECT workers.worker_name, workers.worker_surname, 0 from workers "
                    ."where worker_id not in (select worker_id from assigns where assigns.assign_completed is null) and workers.worker_status='Worker') ";
                    $empquery=mysqli_query($dbhandle, $empsql);
                    while($empres=mysqli_fetch_array($empquery)){
                    ?>
                    <tr>
                      <td><?php echo $empres['worker_name']." ".$empres[1] ?></td>
                      <td><?= $empres[2] ?></td>
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
              <h3 class="panel-title"><i class="fa fa-check-circle fa-fw"></i> Last completed orders</h3>
             </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                  <thead>
                    <tr>
                      <th>Folder name</th>
                      <th>Client</th>
                      <th>Order submitted</th>
                      <th>Order completed</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $orsql="select orders.order_folder, clients.client_name, clients.client_surname, orders.order_submitted, assigns.assign_completed ".
                            "from assigns join orders on assigns.order_id=orders.order_id ".
                            "join clients on orders.client_id=clients.client_id where assign_completed is not null order by assign_completed desc LIMIT 10";
                    $orquery=mysqli_query($dbhandle, $orsql);
                    while($orres=mysqli_fetch_array($orquery)){
                    ?>
                    <tr>
                      <td><?= $orres[0] ?></td>
                      <td><?php echo $orres[1]." ".$orres[2] ?></td>
                      <td><?= $orres[3] ?></td>
                      <td><?= $orres[4] ?></td>
                    </tr>
                    <?php }; ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>



    </div> <?php //CONTAINER FLUID ?>
  </div>  <?php //PAGE WRAPPER ?>



<?php include '../resources/include/footer.php'; ?>
