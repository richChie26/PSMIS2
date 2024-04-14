<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $sql ="SELECT `id`, `Suppliername` FROM `m_supplier` WHERE isactive = 1 order by `Suppliername` asc ";

    $qry = mysqli_query($con,$sql);

    $sqlunits = "SELECT `id`, `units` FROM `m_units` WHERE `isactive` = 1 order by `units` Asc";

    $qryunits = mysqli_query($con,$sqlunits);



?>

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>
       <div class="row">
         
          <div class="col-xs-4">
       


        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Stock No." id="txtstocknosc" name= "txtstocknosc" required="true" readonly="true">
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
       
          </div>
        
        </div>
        <div class="col-xs-4">
     <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Item" id="txtitemsc" readonly="true" name= "txtitemsc" required="true">
            <span class="glyphicon glyphicon-gift form-control-feedback"></span>
       
          </div>
        </div>
      
 <div class="col-xs-4">
     <div class="form-group has-feedback">
            <button class="btn btn-primary" style="float:right;" id="btnprintsc">Print</button>
       
          </div>
        </div>
        
  </div> 
 <!-- second row -->
<div class="row">
         <div class="col-xs-12">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Description" id="txtdescription3" name= "txtdescription3" required="true" readonly="true">
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
       
          </div>
        </div>
</div>
    
<div class="row">
         <div class="col-xs-4">
       
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Units of Measurement" id="txtunits" name= "txtunits" required="true" readonly="true" >
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
           
              </div>
        </div>
                <div class="col-xs-4">
       
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Reorder Point" id="txtreorder" name= "txtreorder" required="true" readonly="true" >
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
           
              </div>
        </div>

             
</div>



  <!-- button row -->
  
  
    </form> 
    <div class="row">
         <div class="col-xs-12">
           <div >
             <table  class="table table-striped" cellspacing="0" cellpadding="0">
               <!-- <thead> -->
               <thead style="background-color: #337ab7;color:white;padding: 0px;">
                <tr>

           


                    <th >Date</th>
                    <th >Reference</th>
                    <th>Receipt</th>
                    <th colspan="2">Issue</th>
                   
                    <th>Balance</th>
                    <th >No. of Days to Consume</th>
                  
                </tr> <tr>
                  <th></th>
                  <th></th>
                  <th>Qty</th>
                  <th>Qty</th>
                   <th>Office</th>
                  
                   <th>Qty</th>
                   <th></th>
                                   </tr>
              </thead>
                <tbody id="scdetails"></tbody>
             </table>
           </div>
         </div>
    </div>