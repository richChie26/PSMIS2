<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


?>
   <div class="showimportaccount">
 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>
<!-- First row -->
       <div class="row">
                  <div class="col-xs-4">
       
            <select id="accasset" class="form-control">
                <option value="Select type of Assets">Select type of Assets</option>
                
                <?php 
                  $sqlact = "SELECT `id`, `typeofassets` FROM `m_assets` WHERE isactive =1 ";
                  $qryacct = mysqli_query($con,$sqlact);
                  while ($rows = mysqli_fetch_array($qryacct)) {
                    # code...
                    echo ' <option value="'. $rows['id'] .'">'. $rows['typeofassets'] .'</option>';
                  }
                ?>

               
            </select>       
        
        </div>

          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Account Title" id="txtaccounttitle" name= "txtaccounttitle" required="true">
            <span class="glyphicon glyphicon-align-left form-control-feedback"></span>
       
          </div>
        </div>

           <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Acronyms" id="txtacro" name= "txtacro" required="true" maxlength="3" >
            <span class="glyphicon glyphicon-align-center form-control-feedback"></span>
       
          </div>
        </div>
      
      

        
  </div> 
  
 <!-- second row -->

    <div class="row">
       <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Account UACS Code" id="aucscode" name= "aucscode" required="true" maxlength="8" >
            <span class="glyphicon glyphicon-align-right form-control-feedback"></span>
       
          </div>
        </div>

        <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Sub-Major Account Group" id="submajor" name= "submajor" required="true" maxlength="2" >
            <span class="glyphicon glyphicon-list form-control-feedback"></span>
       
          </div>
        </div>

        <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="GL Account" id="glaccount" name= "glaccount" required="true" maxlength="2" >
            <span class="glyphicon glyphicon-indent-left form-control-feedback"></span>
       
          </div>
        </div>
    </div>
<div class="row">
       <div class="col-xs-4">
       
        <div class="form-group has-feedback">
           <input type="checkbox" id="chkactive" name="chkactive" >

           <!-- <input type="checkbox" name="chk[]" id="chk[]" value="Apples" /> -->
          <label for="chkactive">Activation </label>
          </div>
        </div>

  </div>
  <!-- button row -->
   <div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnsaveaccounttitle"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
          </div>
        </div>
           <div class="col-xs-8">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnaccoutntitleimport" style="float: right;"><span class="glyphicon glyphicon-import">&nbsp;Import</span></button>
          
          </div>
        </div>

   </div>


     <div class="row">
         <div class="col-xs-6">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Search Account Title" id="txtsearchaccunttile" name= "txtsearchaccunttile" required="true">
            <span class="glyphicon glyphicon-zoom-in form-control-feedback text-info" ></span>
       
          </div>
        </div>
         <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnaccoutntitle"><span class="glyphicon glyphicon-zoom-in"></span></button>
           
          </div>
        </div> 
       
     </div>
     
    </form> 
    <div class="row">
         <div class="col-xs-12">
           <div >
             <table  class="table table-striped">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                    <th>Type of Asset</th>
                    <th>Account Title</th>
                   <th>Acronyms</th>
                   <th>Account UACS Code</th>
                   <th>Sub-Major Account Group</th>
                   <th>GL Account</th>
                   <th>Activation</th>
                    <th>Edit</th>
                    <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails"></tbody>
             </table>
           </div>
         </div>
    </div>

  </div>