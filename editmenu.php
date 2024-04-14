<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
  $id = $_GET['id'];

    $sql = "SELECT `id`, `menucode`, `menuname`, `link` FROM `a_menu` WHERE `isactive` = 1 and id = $id";

    $qry = mysqli_query($con,$sql);
    $arr = mysqli_fetch_array($qry);
    $menucode  = $arr['menucode'];
    $menuname = $arr['menuname'];
    $link = $arr['link'];

  ?>

 <form action="#" method="post" id="frmedit">
       
   <div id="myalert"><div class="alert alert-info" >  <strong>Edit Mode!</strong> Please fill-up the form correctly!  .</div></div>

       <div class="row">
        <div class="col-xs-4">
          <div class="form-group has-feedback">
            <input type="hidden" name="mnuid" id="mnuid" value="<?php echo $id; ?>">
            <input type="text" class="form-control" placeholder="Menu Code" id="mcode" name= "mcode" value="<?php echo $menucode; ?>" required="true">
            <span class="glyphicon glyphicon-th-large form-control-feedback"></span>
          </div>
        </div>
<div class="col-xs-4">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Menu Name" id ="mnuname" name="mnuname" value="<?php echo $menuname; ?>" required="true">
            <span class="glyphicon glyphicon-th form-control-feedback"></span>
          </div>
        </div>
        
  </div> 
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Link" id="mnulink" name="mnulink" value="<?php echo $link; ?>"  required="true">
        <span class="glyphicon glyphicon-th-list form-control-feedback"></span>
      </div>
     
     
      <div class="row">
        
   
        <div class="col-xs-4">
          
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin:5px;" id="btnmeuedit">Update Menu</button><br/>
        </div>
       
      </div>
    </form><div id="mnudetails"></div>