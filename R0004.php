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
   <button class="btn btn-primary" style="float: right;" id="btnprintpcsemi">Print</button>
<div class="row">
       <div class="col-xs-4">
            <div  class="form-group">
          <input type="text" name="txtEntity" id="txtEntity" class="form-control" readonly="true" placeholder="Entity Name" value="DENR PENRO ISABELA">
        </div>
       </div>
       <div class="col-xs-4"></div>
       <div class="col-xs-4">
           <div  class="form-group">
          <input type="text" name="txtfundcluster" id="txtfundcluster" class="form-control" readonly="true" placeholder="Fund Cluster">
        </div>
          </div>
       </div>
</div>      
<div class="row">
       <div class="col-xs-4">
        <div  class="form-group">
        <input type="text" name="txtproperty4" id="txtproperty4" class="form-control" readonly="true" placeholder="Property Number">
          </div>
        </div>
        <div class="col-xs-4">
        <div  class="form-group">
        <input type="text" name="txtsimeitem4" id="txtsimeitem4" class="form-control" readonly="true" placeholder="Item Name">
          </div>
        </div>
       <div class="col-xs-4">
        <div  class="form-group">
        <input type="text" name="txtsemidesc" id="txtsemidesc" class="form-control" readonly="true" placeholder="Description:">
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
                    <th >Reference/ PAR No.</th>
                    <th>Receipt</th>
                    <th colspan="2">Issue/Transfer/ Disposal</th>
                   
                    <th>Balance</th>
                    <th >Amount </th>
                     <th >Remarks </th>
                  
                </tr> <tr>
                  <th></th>
                  <th></th>
                  <th>Qty</th>
                  <th>Qty</th>
                   <th>Office</th>
                  
                   <th>Qty</th>
                   <th></th>
                   <th></th>
                                   </tr>
              </thead>
                <tbody id="scdetails"></tbody>
             </table>
           </div>
         </div>
    </div>
   