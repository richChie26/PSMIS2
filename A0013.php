<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sql = "SELECT `id`, `Groupnane` FROM `a_group` WHERE isactive = 1 order by `Groupnane` ASC";

$qry = mysqli_query($con,$sql);
?>

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>

       <div class="row">
          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Division" id="division" name= "division" required="true">
            <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>
       
          </div>
        </div>
      
      

        
  </div> 
 
   <div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnsavedivision"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
          </div>
        </div>

   </div>
     <div class="row">
         <div class="col-xs-6">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Search Division" id="txtdivision" name= "txtdivision" required="true">
            <span class="glyphicon glyphicon-zoom-in form-control-feedback text-info" ></span>
       
          </div>
        </div>
         <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btndivision"><span class="glyphicon glyphicon-zoom-in"></span></button>
          
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
                    <th>Division</th>
                    
                    <th><center>Edit</center></th>
                    <th><center>Remove</center></th> 
                </tr>
              </thead>
                <tbody id="rcdetails"></tbody>
             </table>
           </div>
         </div>
    </div>