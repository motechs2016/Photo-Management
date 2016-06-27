<?php include '../resources/include/header.php';?>
<title>Messages</title>
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
        "lengthMenu": [5],
        "searching": false,
        "paging": false,
        "lengthChange": false,
        "order": [[ 1, "desc" ]]
    }
    );

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

        <li >
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



        <li class="active">
          <a href="headViewMessages.php?sendid=<?=$lastsender?>"><i class="fa fa-fw  fa-list-alt"></i> Messages </a>
        </li>

        <li >
          <a href="headViewReports.php"><i class="fa fa-fw  fa-comments"></i> Reports </a>
        </li>



      </ul>
    </div>
  </nav>


  <div id="page-wrapper">
    <div class="container-fluid" style="height: 900px">
      <div class="row">
        <div class="col-lg-3">
          <h1 class="page-header">
            Select person
          </h1>
        </div>

        <?php
        $print='';
        $name=$_GET['sendid'];
        if($name==''){$print='';}else{
          if(intval($name)<1000){
            $chatwith="select worker_name, worker_surname from workers where worker_id='".$name."'";
            $chat_query=mysqli_query($dbhandle,$chatwith) or die(mysql_error());
            while($chat_res = mysqli_fetch_array($chat_query))            {
              $print=$chat_res[0].' '.$chat_res[1];
            }
          }else{
            $chatwith="select client_name, client_surname from clients where client_id='".$name."'";
            $chat_query=mysqli_query($dbhandle,$chatwith) or die(mysql_error());
            while($chat_res = mysqli_fetch_array($chat_query))            {
              $print=$chat_res[0].' '.$chat_res[1];
            }
          }
        }
         ?>
         <div class="col-lg-6">
           <h1 class="page-header">
            Chat with <?=$print?>
          </h1>
        </div>

        <div class="col-lg-3">
          <?php if(intval($name)<1000){ ?>
          <h1 class="page-header">Working on</h1>
          <?php }else{ ?>
          <h1 class="page-header">Recent orders</h1>
          <?php } ?>
        </div>
      </div>



      <div class="row">
        <div class="col-lg-3 ">
          <form method="post">
            <select name='PreviousReceiver' class="form-control" onchange='if(this.value != 0) { location = this.value; }'>
              <option selected disabled hidden style='display: none' value=''></option>
              <optgroup label="Employees">
                <?php
                $select_emp="select * from workers where worker_status='Worker'";
                $query_emp=mysqli_query($dbhandle,$select_emp) or die(mysql_error());

                while($res_emp = mysqli_fetch_array($query_emp))
                {
                 ?>

                 <option value="headViewMessages.php?sendid=<?=$res_emp['worker_id']?>"><?php echo $res_emp['worker_name'].' '.$res_emp['worker_surname']?> </option>
                 <?php } ?>
               </optgroup>

               <optgroup label="Clients">
                 <?php
                 $select_cl="select * from clients";
                 $query_cl=mysqli_query($dbhandle,$select_cl) or die(mysql_error());

                 while($res_cl = mysqli_fetch_array($query_cl))
                 {
                  ?>

                  <option value="headViewMessages.php?sendid=<?=$res_cl['client_id']?>"><?php echo $res_cl['client_name'].' '.$res_cl['client_surname']?> </option>
                  <?php } ?>
                </optgroup>
              </select>
            </form>
          </div>

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
                  "message_sender='".$_GET["sendid"]."' OR message_receiver='".$_GET["sendid"]."' ORDER BY message_date";
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


                 </ul>
                </div>
                <div class="panel-footer">
                  <form method="POST" action='../resources/controller/messageController.php?sender=head'>
                    <div class="input-group"><?php $to=$_GET["sendid"] ; ?>
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

            <div class="col-lg-3">
              <?php if(intval($name)<1000){ ?>
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Folder</th>
                    <th>Progress</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $selectf="SELECT orders.order_folder, clients.client_name, clients.client_surname, orders.order_submitted, orders.order_due, ".
                            "workers.worker_name, workers.worker_surname, orders.order_photos, assigns.assign_done, orders.order_status ".
                            "FROM orders ".
                            "LEFT JOIN assigns ".
                            "ON assigns.order_id=orders.order_id ".
                            "LEFT JOIN workers ".
                            "ON assigns.worker_id=workers.worker_id ".
                            "LEFT JOIN clients ".
                            "ON orders.client_id=clients.client_id ".
                            "WHERE assigns.worker_id='".$_GET['sendid']."' AND orders.order_status='In progress' ";
                    $queryf=mysqli_query($dbhandle,$selectf) or die(mysql_error());
                    while($resf = mysqli_fetch_array($queryf))
                    {
                    ?>
                    <tr>
                      <td><?=$resf['order_folder']?></td>
                      <?php
                      $tot=intval($resf['order_photos']);
                      $done=intval($resf['assign_done']);
                      $val=(100*$done)/$tot;
                      ?>
                      <td>
                        <div class="progress " style="margin-bottom: 0px; background-color:#ddd;">
                          <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?= $val ?>%"></div>
                        </div>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
              </table>
              <?php } else{?>
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                 <thead>
                     <tr>
                         <th>Folder</th>
                         <th>Submitted</th>
                     </tr>
                 </thead>
                 <tbody>
                   <?php
                     $selectc="SELECT order_folder, order_submitted from orders "
                              . "WHERE client_id='".$name."' order by order_submitted desc LIMIT 5  ";
                       $queryc=mysqli_query($dbhandle,$selectc) or die(mysql_error());
                       while($resc = mysqli_fetch_array($queryc))
                       {
                       ?>
                       <tr>
                         <td><?=$resc['order_folder']?></td>
                         <td><?=$resc['order_submitted']?></td>
                       </tr>
                       <?php } ?>
                  </tbody>
                </table>
              <?php } ?>
  </div>
</div>



<?php include '../resources/include/footer.php'; ?>
