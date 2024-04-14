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
       
            <select id="ressel" class="form-control">
                <option value="Select  Responsibility Center">Select  Responsibility Center</option>
                
                <?php 
                  $sqlact = "SELECT `id`, `ResponsibilityCenter` FROM `a_responsibilitycenter` WHERE  isactive =1 order by `ResponsibilityCenter` ASC";
                  $qryacct = mysqli_query($con,$sqlact);
                  while ($rows = mysqli_fetch_array($qryacct)) {
                    # code...
                    echo ' <option value="'. $rows['id'] .'">'. $rows['ResponsibilityCenter'] .'</option>';
                  }
                ?>

               
            </select>       
        
        </div>
        <div class="col-xs-4">
       
       <select id="scesel" class="form-control">
           <option value="Select Section">Select Section</option>
           
           <?php 
             $sqlact = "SELECT `id`,`section` FROM `a_section` WHERE isactive =1 ORDER by section";
             $qryacct = mysqli_query($con,$sqlact);
             while ($rows = mysqli_fetch_array($qryacct)) {
               # code...
               echo ' <option value="'. $rows['id'] .'">'. $rows['section'] .'</option>';
             }
           ?>

          
       </select>       
   
   </div>
          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Employee Name" id="txtdempname" name= "txtdempname" required="true">
            <span class="glyphicon glyphicon-align-left form-control-feedback"></span>
       
          </div>
        </div>

        
      
      

        
  </div> 
  

   <div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnsaveApprover"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
          </div>
        </div>
           <div class="col-xs-8">
          <div class="form-group has-feedback" style="display: none;">
                    <button class="btn btn-primary" id="btnaccoutntitleimport" style="float: right;"><span class="glyphicon glyphicon-import">&nbsp;Import</span></button>
          
          </div>
        </div>

   </div>


     <div class="row">
         <div class="col-xs-6">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Search Responsibility Center" 
            id="txtsearchapprover" name= "txtsearchapprover" required="true">
            <span class="glyphicon glyphicon-zoom-in form-control-feedback text-info" ></span>
       
          </div>
        </div>
         <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnSearchapprover"><span class="glyphicon glyphicon-zoom-in"></span></button>
           
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

           

                    <th>Responsibility Center</th>
                    <th>Section</th>
                   <th>Name</th>
                   
                   
                   
                   
                    
                    <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails"></tbody>
             </table>
           </div>
         </div>
    </div>

  </div>