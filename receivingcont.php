<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$mnuasset = $_GET['mnuasset'];
$seltype = $_GET['seltype'];


$sql = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    $Responsibility = $arr['Responsibility'];

// PPE 3
// Semi 2
if(($mnuasset  == 2) && ($seltype == "Receiving (Purchase)")){
// Sime Receiving 
?>  

<div class="panel panel-primary" id="supplannel">
   <div class="panel-heading">Supplier Details</div>
  <div class="panel-body" >
      <div class="row">
         

      <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Supplier" id="txtsupplier" name= "txtsupplier" required="true" readonly="true">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
       
          </div>
      </div>
      
        <div class="col-xs-4">
            
            <label>Date of Delivery &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="date"  id="txtddate" name= "txtddate" placeholder="Date of Delivery">
    
       
          </div>


   
      </div>

 <div class="row">
      <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="P.O. Number" id="txtPO" name= "txtPO" required="true" >
            <span class="glyphicon glyphicon-file form-control-feedback"></span>
       
          </div>
      </div>
      
        <div class="col-xs-4">
            
            <label>Purchase Order Date</label>
            <input type="date"  id="txtpodate" name= "txtpodate" >
    
       
          </div>



           <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Delivery Receipt Number:" id="txtreceiptn" name= "txtreceiptn" >
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
       
          </div>
      </div>
      </div>


      </div>


  </div>

<div class="panel panel-primary">
   <div class="panel-heading">Article/Item Details</div>
  <div class="panel-body" >
      <div class="row">
       <div class="col-xs-6">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Fund Source" id="txtsource" name= "txtsource" required="true" readonly="true">
            <span class="glyphicon glyphicon-bookmark form-control-feedback"></span>
       
          </div>
      </div> 
      <div class="col-xs-4"><label>Date Acquired</label>
          <input type="date" name="dtpdateaquired" id="dtpdateaquired">
      </div>

      </div>


      <div class="row">
             <div class="col-xs-6">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Account Title" id="txtaccount" name= "txtaccount" required="true" readonly="true">
            <span class="glyphicon glyphicon-tag form-control-feedback"></span>
       
          </div>
      </div>
    
          <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Article/Item:" id="txtarticle" name= "txtarticle" required="true" readonly="true">
            <span class="glyphicon glyphicon-tags form-control-feedback"></span>
       
          </div>
      </div>
      </div>
      <div class="row">
           <div class="col-xs-6">
             
             <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Estimated Useful Life:" id="txtestimated" name= "txtestimated" required="true" readonly="true" >
            <span class="glyphicon glyphicon-menu-hamburger form-control-feedback"></span>
       
          </div>
           </div> 
           <div class="col-xs-4">  <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Amount" id="txtamount" name= "txtamount" required="true" >
            <span class=" glyphicon glyphicon-ruble form-control-feedback"></span>
       
          </div></div>


      </div>
      <div class="row">
        <div class="col-xs-10">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Description" id="txtdesc" name= "txtdesc" required="true" >
            <span class="glyphicon glyphicon-tasks form-control-feedback"></span>
        </div>
          </div>
      </div>

       <div class="row">
        <div class="col-xs-5">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Serial Number" id="txtserial" name= "txtserial" required="true" >
            <span class="glyphicon glyphicon-equalizer form-control-feedback"></span>
        </div>
          </div>
          
      </div>



      </div>


  </div>

  <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;Semi Expendables to Receive</a></li>
    <li><a data-toggle="tab" href="#menu1" id="receivesemitab">List of Received Semi Expendables</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">

      <br/>

      <div class="row">
  <div class="col-xs-6">
      <button class="btn btn-primary" id ="btntempsemireceive"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button>
  </div>
    <div class="col-xs-4">
     
  </div>
    <div class="col-xs-2">
      <button class="btn btn-primary" id="btnsavesemireceive"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Submit</button>
  </div>  
</div>

      <div class="row">
         <div class="col-xs-12">
           <div >
            <br/>
             <table  class="table table-striped table-condensed" id="tblrichie">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                     <th> Account Title</th>
                     <th>Item</th>
                    <th>Description</th>
                    <th>Serial</th>
                    <th>Date Acquire</th>
                    <th>Useful Life</th>
                    <th>Quantity</th> 
                    <th>Unit</th> 
                    <th>Amount</th>
                  
                      <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails"></tbody>
             </table>
           </div>
         </div>
    </div>
     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "tabrichie"></div>

    </div>
   
 
  </div>
<?php
// Semi Receiving
}else if(($mnuasset  == 2) && ($seltype == "Receiving (Transfer From)")){
?>

<?php
}else if(($mnuasset  == 3) && ($seltype == "Receiving (Purchase)")){
// PPE Receiving
?>  

<div class="panel panel-primary" id="supplannel">
   <div class="panel-heading">Supplier Details</div>
  <div class="panel-body" >
      <div class="row">
         

      <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Supplier" id="txtsupplier" name= "txtsupplier" required="true" readonly="true">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
       
          </div>
      </div>
      
        <div class="col-xs-4">
            
            <label>Date of Delivery &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="date"  id="txtddate" name= "txtddate" placeholder="Date of Delivery">
    
       
          </div>


   
      </div>





 <div class="row">
      <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="P.O. Number" id="txtPO" name= "txtPO" required="true" >
            <span class="glyphicon glyphicon-file form-control-feedback"></span>
       
          </div>
      </div>
      
        <div class="col-xs-4">
            
            <label>Purchase Order Date</label>
            <input type="date"  id="txtpodate" name= "txtpodate" >
    
       
          </div>



           <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Delivery Receipt Number:" id="txtreceiptn" name= "txtreceiptn" >
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
       
          </div>
      </div>
      </div>


      </div>


  </div>

<div class="panel panel-primary">
   <div class="panel-heading">Article/Item Details</div>
  <div class="panel-body" >
      <div class="row">
       <div class="col-xs-6">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Fund Source" id="txtsource" name= "txtsource" required="true" readonly="true">
            <span class="glyphicon glyphicon-bookmark form-control-feedback"></span>
       
          </div>
      </div> 
      <div class="col-xs-4"><label>Date Acquired</label>
          <input type="date" name="dtpdateaquired" id="dtpdateaquired">
      </div>

      </div>


      <div class="row">
             <div class="col-xs-6">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Account Title" id="txtaccount" name= "txtaccount" required="true" readonly="true">
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
       
          </div>
      </div>
    
          <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Article/Item:" id="txtarticle" name= "txtarticle" required="true" readonly="true">
            <span class="glyphicon glyphicon-tag form-control-feedback"></span>
       
          </div>
      </div>
      </div>
      <div class="row">
           <div class="col-xs-6">
             
             <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Estimated Useful Life:" id="txtestimated" name= "txtestimated" required="true" readonly="true" >
            <span class="glyphicon glyphicon-tags form-control-feedback"></span>
       
          </div>
           </div> 
           <div class="col-xs-4">  <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Amount" id="txtamount" name= "txtamount" required="true" >
            <span class="glyphicon glyphicon-ruble form-control-feedback"></span>
       
          </div></div>


      </div>
      <div class="row">
        <div class="col-xs-10">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Description" id="txtdesc" name= "txtdesc" required="true" >
            <span class="glyphicon glyphicon-tasks  form-control-feedback"></span>
        </div>
          </div>
      </div>

       <div class="row">
        <div class="col-xs-5">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Serial" id="txtengine" name= "txtengine" required="true" >
            <span class="glyphicon glyphicon-equalizer form-control-feedback"></span>
        </div>
          </div>
            <div class="col-xs-5">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Chassis Number" id="txtchasis" name= "txtchasis" required="true" >
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
        </div>
          </div>
      </div>



      </div>


  </div>

 <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp; Property Plants and Equipment to Receive</a></li>
    <li><a data-toggle="tab" href="#menu1" id="receiveppetab">List of Received Property Plants and Equipment</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">

      <br/>

      <div class="row">
  <div class="col-xs-6">
      <button class="btn btn-primary" id ="btntempppereceive"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button>
  </div>
    <div class="col-xs-4">
     
  </div>
    <div class="col-xs-2">
      <button class="btn btn-primary" id="btnsaveppereceive"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Submit</button>
  </div>  
</div>

      <div class="row">
         <div class="col-xs-12">
           <div >
            <br/>
             <table  class="table table-striped table-condensed" id="tblrichie">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                     <th> Account Title</th>
                     <th>Item</th>
                    <th>Description</th>
                    <th>Serial</th>
                    <th>Date Acquire</th>
                    <th>Useful Life</th>
                    <th>Quantity</th>
                    <th>Unit</th> 
                    <th>Amount</th>
                  
                      <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails"></tbody>
             </table>
           </div>
         </div>
    </div>
     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "tabrichie"></div>

    </div>
   
 
  </div>




<?php
// PPE Receiving
}else if(($mnuasset  == 3) && ($seltype == "Receiving (Transfer From)")){
// PPE Receiving Transfer
  ?>  


<?php


// PPE Receiving Transfer
}else{
?>

<!-- Supply Inventory received -->
<div class="panel panel-primary">
   <div class="panel-heading">Supplier Details</div>
  <div class="panel-body" >
      <div class="row">
         

      <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Supplier" id="txtsupplier" name= "txtsupplier" required="true" readonly="true">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
       
          </div>
      </div>
      
        <div class="col-xs-4">
            
            <label>Date of Delivery &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="date"  id="txtddate" name= "txtddate" placeholder="Date of Delivery">
    
       
          </div>


      <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Fund Source" id="txtsource" name= "txtsource" required="true" readonly="true">
            <span class="glyphicon glyphicon-bookmark form-control-feedback"></span>
       
          </div>
      </div>
      </div>

 <div class="row">
      <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="P.O. Number" id="txtPO" name= "txtPO" required="true" >
            <span class="glyphicon glyphicon-file form-control-feedback"></span>
       
          </div>
      </div>
      
        <div class="col-xs-4">
            
            <label>Purchase Order Date</label>
            <input type="date"  id="txtpodate" name= "txtpodate" >
    
       
          </div>



           <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Delivery Receipt Number:" id="txtreceiptni" name= "txtreceiptni" >
            <span class="glyphicon glyphicon-book  form-control-feedback"></span>
       
          </div>
      </div>
      </div>


      </div>


  </div></div>
      <div class="row">
         


            <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Account Title" id="txtaccount" name= "txtaccount" required="true" readonly="true">
            <span class="glyphicon glyphicon-tag form-control-feedback"></span>
       
          </div>
      </div>
          <div class="col-xs-4">
       


        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Stock No." id="txtstockno3" name= "txtstockno3" required="true" readonly="true">
            <span class="glyphicon glyphicon-tags form-control-feedback"></span>
       
          </div>
        
        </div>
        <div class="col-xs-4">
     <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Item" id="txtitem3" readonly="true" name= "txtitem3" required="true">
            <span class="glyphicon glyphicon-gift form-control-feedback"></span>
       
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
                <input type="number" class="form-control" placeholder="Quantity" id="txtquantity" name= "txtquantity" required="true" >
                <span class="glyphicon glyphicon-menu-hamburger form-control-feedback"></span>
           
              </div>
        </div>

                  <div class="col-xs-4">
       
            <div class="form-group has-feedback">
                <input type="number" class="form-control" placeholder="Amount per Unit" id="txtamount" name= "txtamount" required="true" >
                <span class="glyphicon glyphicon-ruble  form-control-feedback"></span>
           
              </div>
        </div>
</div>

<div class="row">
         <div class="col-xs-12">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Serial Number" id="txtserial" name= "txtserial" required="true" style="display: none;" >
            <span class="glyphicon glyphicon-book form-control-feedback" style="display: none;" ></span>
       
          </div>
        </div>
</div>

  <!-- button row -->
   <div class="row">
      <div class="col-xs-10">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnadd"><span class="glyphicon glyphicon-plus">&nbsp;Add</span></button>
          
          </div>
        </div>

      <div class="col-xs-1">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnsavereceived" style=" padding-right: : 15px;margin-right: :15px;"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Submit</span></button>
          
          </div>
        </div>
   </div>
       
    </form> 



  
  <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;Supplies to Receive</a></li>
    <li><a data-toggle="tab" href="#menu1" id="receivelisttab">List of Received Supplies</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="row">
         <div class="col-xs-12">
           <div >
            <br/>
             <table  class="table table-striped">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                     <th> Account Title</th>
                    <th>Stock No.</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Quantity</th> 
                    <th>Unit of Measure</th>
                    <th>Amount</th>
                      <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails"></tbody>
             </table>
           </div>
         </div>
    </div>
     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "tabrichie"></div>

    </div>
   
 
  </div>


   




<?php
}
// Supply inventory Receive
?>

