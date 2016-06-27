<?php include '../resources/include/header.php'; session_start();?>
<title>Reports</title>
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
   var tableToExcel = (function () {
   var uri = 'data:application/vnd.ms-excel;base64,'
   , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
   , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
   , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
   return function (table, name, filename) {
       if (!table.nodeType) table = document.getElementById(table)
       var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

       document.getElementById("dlink").href = uri + base64(format(template, ctx));
       document.getElementById("dlink").download = filename;
       document.getElementById("dlink").click();

   }
})()
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

        <li>
          <a href="headViewOrders.php"><i class="fa fa-fw  fa-edit"></i> Orders </a>
        </li>


        <li>
          <a href="headViewReports.php"><i class="fa fa-fw  fa-list-alt"></i> Messages </a>
        </li>

        <li  class='active'>
          <a href="headViewReports.php"><i class="fa fa-fw  fa-comments"></i> Reports </a>
        </li>



      </ul>
    </div>
  </nav>


  <div id="page-wrapper">
    <div class="container-fluid" style="height: 900px">

      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Reports
          </h1>
        </div>
      </div>

      <?php
      $today = getdate();
      $d = $today['mday'];
      $m = $today['mon'];
      $y = $today['year'];
      $td=$y.'-'.$m.'-'.$d;
       ?>

    <div class="row">
      <div class="col-lg-3 col-md-6 col-lg-offset-3">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-user fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <?php
                $sql="select count(*) from clients";
                $query=mysqli_query($dbhandle, $sql);
                while($res=mysqli_fetch_array($query)){
                 ?>
                  <div class="huge"><?=$res[0]?></div>
                 <?php }; ?>

                 <div>Satisfied clients!</div>
               </div>
             </div>
           </div>
           <a id="dlink"  style="display:none;"></a>
           <a onclick="tableToExcel('satisfied', 'Satisfied Clients', '<?=$td?>-Clients')" style="cursor: pointer">
               <div class="panel-footer" >
                   <span class="pull-left">Export data</span>
                   <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                   <div class="clearfix"></div>
               </div>
           </a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
       <div class="panel panel-green">
         <div class="panel-heading">
           <div class="row">
             <div class="col-xs-3">
               <i class="fa fa-check-square-o fa-5x"></i>
             </div>
             <div class="col-xs-9 text-right">
               <?php
               $sql2="select count(*) from orders where order_status='Done'";
               $query2=mysqli_query($dbhandle, $sql2);
               while($res2=mysqli_fetch_array($query2)){
                ?>
                 <div class="huge"><?=$res2[0]?></div>
                <?php }; ?>

                <div>Completed Orders!</div>
              </div>
            </div>
          </div>
          <a id="dlink"  style="display:none;"></a>
          <a onclick="tableToExcel('done', 'Orders Done', '<?=$td?>-Completed')" style="cursor: pointer">
              <div class="panel-footer" >
                  <span class="pull-left">Export data</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-lg-3 col-md-6 col-lg-offset-3">
        <div class="panel panel-yellow">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-tasks fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <?php
                $sql1="select count(*) from orders where order_status='In progress'";
                $query1=mysqli_query($dbhandle, $sql1);
                while($res1=mysqli_fetch_array($query1)){
                 ?>
                  <div class="huge"><?=$res1[0]?></div>
                 <?php }; ?>

                 <div>Orders in progress!</div>
               </div>
             </div>
           </div>
           <a id="dlink"  style="display:none;"></a>
           <a onclick="tableToExcel('progress', 'Orders in progress', '<?=$td?>-Progress')" style="cursor: pointer">
               <div class="panel-footer" >
                   <span class="pull-left">Export data</span>
                   <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                   <div class="clearfix"></div>
               </div>
           </a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
       <div class="panel panel-red">
         <div class="panel-heading">
           <div class="row">
             <div class="col-xs-3">
               <i class="fa fa-support fa-5x"></i>
             </div>
             <div class="col-xs-9 text-right">
               <?php
               $sql3="select count(*) from orders where order_status='Not started'";
               $query3=mysqli_query($dbhandle, $sql3);
               while($res3=mysqli_fetch_array($query3)){
                ?>
                 <div class="huge"><?=$res3[0]?></div>
                <?php }; ?>

                <div>Orders not started!</div>
              </div>
            </div>
          </div>
          <a id="dlink"  style="display:none;"></a>
          <a onclick="tableToExcel('not', 'Orders not started', '<?=$td?>-NotStarted')" style="cursor: pointer">
              <div class="panel-footer" >
                  <span class="pull-left">Export data</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
              </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<table id="satisfied" style="display:none;">
  <thead>
    <th>Client</th>
    <th>Date joined</th>
    <th>Company</th>
    <th>Total orders</th>
  </thead>
  <?php
  $clsql="SELECT clients.*, count(orders.order_id) as number_of_orders from clients left join orders on (clients.client_id = orders.client_id) group by clients.client_id";
  $clquery=mysqli_query($dbhandle,$clsql);
  while($clres=mysqli_fetch_array($clquery)){
  ?>
  <tr>
    <td><?php echo $clres[1]." ".$clres[2];?></td>
    <td><?=$clres[3]?></td>
    <td><?=$clres[4]?></td>
    <td><?=$clres[5]?></td>
  </tr>
  <?php }; ?>
</table>

<table id="done" style="display:none;">
  <thead>
    <th>Client</th>
    <th>Folder</th>
    <th>Photos</th>
    <th>Submitted</th>
    <th>Due date</th>
    <th>Completed on</th>
    <th>Completed by </th>
  </thead>
  <?php
  $donesql="select orders.*, clients.client_name, clients.client_surname, assign_completed, workers.worker_name, workers.worker_surname "
          . "from orders "
          . "join clients on orders.client_id=clients.client_id "
          . "join assigns on assigns.order_id=orders.order_id "
          . "join workers on assigns.worker_id=workers.worker_id "
          . "where orders.order_status='Done' "
          . "order by assign_completed desc";
  $donequery=mysqli_query($dbhandle,$donesql);
  while($doneres=mysqli_fetch_array($donequery)){
  ?>
  <tr>
    <td><?php echo $doneres[7]." ".$doneres[8];?></td>
    <td><?=$doneres[2]?></td>
    <td><?=$doneres[5]?></td>
    <td><?=$doneres[3]?></td>
    <td><?=$doneres[4]?></td>
    <td><?=$doneres[9]?></td>
    <td><?php echo $doneres[10]." ".$doneres[11];?></td>
  </tr>
  <?php }; ?>
</table>

<table id="progress" style="display:none;">
  <thead>
    <th>Client</th>
    <th>Folder</th>
    <th>Submitted</th>
    <th>Due date</th>
    <th>Worker assigned</th>
  </thead>
  <?php
  $prsql="select orders.*, clients.client_name, clients.client_surname, workers.worker_name, workers.worker_surname "
          . "from orders "
          . "join clients on orders.client_id=clients.client_id "
          . "join assigns on assigns.order_id=orders.order_id "
          . "join workers on assigns.worker_id=workers.worker_id "
          . "where orders.order_status='In progress' order by order_due";
  $prquery=mysqli_query($dbhandle,$prsql);
  while($prres=mysqli_fetch_array($prquery)){
  ?>
  <tr>
    <td><?php echo $prres[7]." ".$prres[8];?></td>
    <td><?=$prres[2]?></td>
    <td><?=$prres[3]?></td>
    <td><?=$prres[4]?></td>
    <td><?php echo $prres[9]." ".$prres[10];?></td>
  </tr>
  <?php }; ?>
</table>

<table id="not" style="display:none;">
  <thead>
    <th>Client</th>
    <th>Folder</th>
    <th>Order photos</th>
    <th>Submitted</th>
    <th>Due date</th>
  </thead>
  <?php
  $dsql="select orders.*, clients.client_name, clients.client_surname "
          . "from orders join clients on orders.client_id=clients.client_id "
          . "where orders.order_status='Not started' order by order_due";
  $dquery=mysqli_query($dbhandle,$dsql);
  while($dres=mysqli_fetch_array($dquery)){
  ?>
  <tr>
    <td><?php echo $dres[7]." ".$dres[8];?></td>
    <td><?=$dres[2]?></td>
    <td><?=$dres[5]?></td>
    <td><?=$dres[3]?></td>
    <td><?=$dres[4]?></td>
  </tr>
  <?php }; ?>





<?php include '../resources/include/footer.php'; ?>
