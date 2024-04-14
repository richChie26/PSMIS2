<?php

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$sqlss = 'SELECT `id`, `AgencyHeader`, `AgencyName`, `RegionalOffice`, `OperatingUnit`, `AgencyAddess`, `logo` FROM `a_agencyprofile`  ';
$qry = mysqli_query($con,$sqlss);
$AgencyHeader = "";
$AgencyName = "";
$RegionalOffice = "";
$OperatingUnit = "";
$AgencyAddess = "";
$logo = "";
while($row = mysqli_fetch_array($qry)){
  $AgencyHeader = $row['AgencyHeader'];
  $AgencyName = $row['AgencyName'];
  $RegionalOffice = $row['RegionalOffice'];
  $OperatingUnit = $row['OperatingUnit'];
  $AgencyAddess = $row['AgencyAddess'];
  $logo = $row['logo'];

}
?> 

</form> 

  <form id="form" action="uploadLogo.php" method="post" enctype="multipart/form-data">

  <input id="uploadImage" type="file" accept="image/*" name="image" />
<div id="preview"><img src="<?php echo $logo ;?>"  style="width:100px; height: 100px;" /></div><br>
  <div class="row">
    <div class="col-sm col-md-2 " style="margin-left:20px">
      <label>Agency Header</label>
    </div>
    <div class="col-sm col-md-4 ">
      <div class="form-group has-feedback">
        <input type="text" class="form-control myinput" placeholder="Header" id="mheader" value="<?php echo $AgencyHeader ;?>" name="mheader"required="true">
        <span class="glyphicon glyphicon-flag form-control-feedback"></span>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-sm col-md-2 " style="margin-left:20px">
      <label>Agency Name</label>
    </div>
    <div class="col-sm col-md-4 ">
      <div class="form-group has-feedback">
      <input type="text" class="form-control myinput" placeholder="Name" id="mname" name="mname"  value="<?php echo $AgencyName;?>"  required="true">
        <span class="glyphicon glyphicon-tag form-control-feedback"></span>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-sm col-md-2 " style="margin-left:20px">
      <label>Regional Office</label>
    </div>
    <div class="col-sm col-md-4 ">
      <div class="form-group has-feedback">
      <input type="text" class="form-control myinput" placeholder="Regional Office" id="moffice" name="moffice"  value="<?php echo   $RegionalOffice;?>" required="true">
      <span class="glyphicon glyphicon-home form-control-feedback"></span>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-sm col-md-2 " style="margin-left:20px">
      <label>Operations Unit</label>
    </div>
    <div class="col-sm col-md-4 ">
      <div class="form-group has-feedback">
      <input type="text" class="form-control myinput" placeholder="Office" id="munits" name="munits"  value="<?php echo   $OperatingUnit;?>" required="true">
      <span class="glyphicon glyphicon-tags form-control-feedback"></span>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-sm col-md-2 " style="margin-left:20px">
      <label>Agency Address</label>
    </div>
    <div class="col-sm col-md-4 ">
      <div class="form-group has-feedback">
      <input type="text" class="form-control myinput" placeholder="Address" id="maddress" name="maddress"  value="<?php echo   $AgencyAddess ;?>" required="true">
      <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
      </div>
    </div>
</div>




<input class="btn btn-success" type="submit" value="Upload">
<label class="btn btn-primary " id="btneditLogo" > <span class="glyphicon glyphicon-pencil">&nbsp;Edit</span> </label>
</form>  

 
<!-- 
value="'.$row['AgencyHeader'].'" 

value="'.$row['AgencyName'].'"
value="'.$row['RegionalOffice'].'" 
 value="'.$row['OperatingUnit'].'"
value="'.$row['AgencyAddess'].'"  -->