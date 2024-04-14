<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $sql ="SELECT `id`, `accounttitle`,typeofasset FROM `m_accouttitle` WHERE `isactive` = 1 order by  
    typeofasset, accounttitle asc";

    $qry = mysqli_query($con,$sql);

    $sqlunits = "SELECT `id`, `units` FROM `m_units` WHERE `isactive` = 1 order by `units` Asc";

    $qryunits = mysqli_query($con,$sqlunits);



?>

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>
<!-- First row -->
       <div class="row">
          <div class="col-xs-6">
       
        <div class="form-group has-feedback">
           

           <select class="form-control" name ="mnutitle" id="mnutitle">
             <option value ="Select Account Title" >Select Account Title</option>
             <?php 
              while($row = mysqli_fetch_array($qry)){
                  echo '<option value ="'. $row['id'].'|'.$row['typeofasset'].'" >'. $row['accounttitle'].'</option>'; 
              }
             ?>
            </select>
           
       
          </div>
        </div>
      <!--     <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Item" id="txtitem" name= "txtitem" required="true">
            <span class="glyphicon glyphicon-gift form-control-feedback"></span>
       
          </div>
        </div> -->
     <!--    <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Stock No." id="txtstockno" name= "txtstockno" required="true">
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
       
          </div>
        </div> -->
      

        
  </div> 
 <!-- second row -->
<!-- <div class="row">
         <div class="col-xs-12">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Description" id="txtdescription" name= "txtdescription" required="true">
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
       
          </div>
        </div>
</div> -->
    
<!-- <div class="row">
         <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            
           <select class="form-control" id="mnuunits" name = "mnuunits">
                <option value="Select Units">Select Units</option>

                <?php
                  // while($rows = mysqli_fetch_array($qryunits)){
                  // echo '<option value="'.$rows['id'].'">'.$rows['units'].'</option>';
                // }
                ?>
           </select>
       
          </div>
        </div>
</div> -->
  <!-- button row -->

  <div id ="tyller">
    
  </div>

