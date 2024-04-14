<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $sql ="SELECT `id`, `typeofassets` FROM `m_assets` WHERE isactive = 1 ";

    $qry = mysqli_query($con,$sql);

    $sqlunits = "SELECT `id`, `units` FROM `m_units` WHERE `isactive` = 1 order by `units` Asc";

    $qryunits = mysqli_query($con,$sqlunits);



?>

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>
<!-- First row -->

<div class="panel panel-primary">
   <div class="panel-heading">Type of Transaction</div>
  <div class="panel-body" >
<div class="row">
       <div class="col-xs-4">
       
        <div class="form-group has-feedback">
          <div class="form-group"> 
         
           <select class="form-control" name ="selmytype" id="selmytype">
            
             <?php 
              while($row = mysqli_fetch_array($qry)){
                  echo '<option value ="'. $row['id'].'" >'. $row['typeofassets'].'</option>'; 
              }
             ?>
            </select>
           
            </div>
          </div>
        </div>
         <div class="col-xs-4">
             <div class="form-group">
             
             <select id="seltypetrans" class="form-control">
            
             </select>
               <!--  <div class='input-group date' id='datetimepicker1'>
                    <input type='date' id="dtpdate" name="dtpdate" class="form-control" />
                   
                </div> -->
            </div>
         </div>

         <div class="col-xs-4">
             <div class="form-group">
             
           <button id="btnshowtrans" class="btn btn-primary">Show</button>
          
               <!--  <div class='input-group date' id='datetimepicker1'>
                    <input type='date' id="dtpdate" name="dtpdate" class="form-control" />
                   
                </div> -->
            </div>
         </div>

</div>

</div></div>
<div id="receivingbox"></div>
