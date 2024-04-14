<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;



    $sqlposition = "SELECT `id`, `position` FROM `a_position` WHERE `isactive` = 1 
order by `position` ASC";
  $qryposition = mysqli_query($con,$sqlposition);

 

?>
<div id="showcontent">
  <form action="#" method="post" id="frmuserreg">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>

       <div class="row">
        <div class="col-xs-4">
         <div class="form-group has-feedback">
           <input type="text" class="form-control" placeholder="First name" id="fname" name= "fname" required="true" maxlength="225">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Middle name" id ="mname" name="mname"  required="true" maxlength="225">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
         </div>
        </div>
        <div class="col-xs-4">
         <div class="form-group has-feedback">
           <input type="text" class="form-control" placeholder="Last name" id="lname" name="lname"  required="true" maxlength="225">
           <span class="glyphicon glyphicon-user form-control-feedback"></span>
         </div>
        </div>
  </div> 
    <div class="row">
        <div class="col-xs-12">
    
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Address" id="address" name="address"  required="true">
        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
      </div>
      </div>
    </div> 
    <div class="row"> 
        <div class="col-xs-4">
      <div class="form-group has-feedback">
        <label>Contact Number</label>
        <input type="text" class="form-control" placeholder="Contact Number" name="contact" id="contact" >
       <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
      </div></div>
      <div class="col-xs-4">
           <div class="form-group has-feedback">
         <label> Responsibility Center</label>
          <select class="form-control" id="rc">
           
              <option value="Select Responsibility Center"> Select Responsibility Center</option>
 <?php
  $sqlrc = "SELECT id,`ResponsibilityCenter` FROM `a_responsibilitycenter` WHERE `isactive` = 1 
order by `ResponsibilityCenter` ASC";
  $qryrc = mysqli_query($con,$sqlrc);
            while ($rowrc = mysqli_fetch_array($qryrc)) {
                  echo '<option value="'. $rowrc['id'].'">'. $rowrc['ResponsibilityCenter'].'</option>' ;

                }

              ?>

          </select>
       
      </div>
      </div>
    </div>
     <div class="row"> 
        <div class="col-xs-4">
 <div class="form-group has-feedback">
          <label>Division</label>
          <select class="form-control" id="divid">
            
              <option value="Select Section"> Select Division</option>
              <?php 
                $sqldiv = "SELECT `id`, `division` FROM `a_division` WHERE isactive = 1 order by `division` Asc ";
                 $qrydiv = mysqli_query($con,$sqldiv);
            while ($rowdiv = mysqli_fetch_array($qrydiv)) {
                  echo '<option value="'. $rowdiv['id'].'">'. $rowdiv['division'].'</option>' ;

                }

              ?>
          
          </select>
      
      </div>

     </div>
       <div class="col-xs-4">
      <div class="form-group has-feedback">
          <label>Section</label>
          <select class="form-control" id="sec">
            
              <option value="Select Section"> Select Section</option>
              <?php 
                $sqlsec = "SELECT id, `section` FROM `a_section` WHERE isactive =1 order by `section` ASC ";
                 $qrysec = mysqli_query($con,$sqlsec);
            while ($rowsec = mysqli_fetch_array($qrysec)) {
                  echo '<option value="'. $rowsec['id'].'">'. $rowsec['section'].'</option>' ;

                }

              ?>
          
          </select>
      
      </div></div>

        <div class="col-xs-4">
    <div class="form-group has-feedback">
        <label>Position</label>
          <select class="form-control" id="pos" >
              <option value="Select Position"> Select Position</option>
              <?php
          while ($rowpos = mysqli_fetch_array($qryposition)) {
                  echo '<option value="'. $rowpos['position'].'">'. $rowpos['position'].'</option>' ;

                }

              ?>
`
          </select>
      
      </div>
    </div>
             
    </div>
     


     <div class="row">
        
   
        <div class="col-xs-3">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin:5px;" id="btnprofile">Save</button><br/>
        </div>
         <div class="col-xs-6">
         <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnprofileimport" style="float: right;"><span class="glyphicon glyphicon-import">&nbsp;Import</span></button>
          
          </div>
        </div>
         <div class="col-xs-2">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin:5px;" id="btnprofilerefresh"><span class="glyphicon glyphicon-refresh">&nbsp;Refresh</span></button><br/>
        </div>
       
      </div>
  
   </form>
    <div class="row">
         <div class="col-xs-11" id ="vwprofiledetails" style="margin-left:20px;">
           
         </div>
    </div>
  </div>