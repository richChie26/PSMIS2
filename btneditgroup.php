<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
  $id = $_GET['id'];

    $sql = "SELECT `id`, `Groupnane`, `Description` FROM `a_group` WHERE `id` = $id 
and `isactive` = 1 ";

    $qry = mysqli_query($con,$sql);
    $arr = mysqli_fetch_array($qry);
    $Groupnane  = $arr['Groupnane'];
    $Description = $arr['Description'];
  

  ?>

 <form action="#" method="post" id="frmedit">
       
   <div id="myalert"><div class="alert alert-info" >  <strong>Edit Mode!</strong> Please fill-up the form correctly!  .</div></div>

       <div class="row">
        <div class="col-xs-4">
          <div class="form-group has-feedback">
            <input type="hidden" name="mnuid" id="mnuid" value="<?php echo $id; ?>">
            <input type="text" class="form-control" placeholder="Menu Code" id="Groupnane" name= "Groupnane" value="<?php echo $Groupnane; ?>" required="true">
            <span class="glyphicon glyphicon-th-large form-control-feedback"></span>
          </div>
        </div>

        
  </div> 
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Description" id="Description" name="Description" value="<?php echo $Description; ?>"  required="true">
        <span class="glyphicon glyphicon-th-list form-control-feedback"></span>
      </div>
     
     
      <div class="row">
        
   
        <div class="col-xs-4">
          
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin:5px;" id="btngroupedit">Update Group</button><br/>
        </div>
       
      </div>
    </form><div id="mnudetails"></div>