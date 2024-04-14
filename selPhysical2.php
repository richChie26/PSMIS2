<?php 

include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ; 
$Accid = $_GET['Accid'];
$sqlss2 = "SELECT id,`accounttitle` FROM `m_accouttitle`
 where isactive = 1 and `typeofasset` =  $Accid order by `accounttitle` asc ";

 $qry = mysqli_query($con,$sqlss2);

 echo '<div class="row"><div class="col-xs-5"> <div class="form-group"><select class="form-control" id="optcount" >';

 while($rows = mysqli_fetch_array($qry)){
  	
echo 	'<option value="'.$rows['id'].'">'.$rows['accounttitle'].'</option>
';

 }

 echo '</select></div></div>
 
 
 <div class="col-xs-3"><div class="form-group"><input type="date"  class="form-control" width="30%" id="dtpReportDate" /> </div> </div>
 <div class="col-xs-2"><button class="btn btn-primary" id= "btnshowReports2">Show</button></div>
 <div class="col-xs-2"><button class="btn btn-primary"  style="float:right; id= "btnPhysicalprint2">Print</button></div>
 </div>';


?>