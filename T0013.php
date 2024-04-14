<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];

$sqlss = "SELECT `id`, `typeofassets` FROM `m_assets` WHERE `isactive` = 1  ";
$qryss = mysqli_query($con,$sqlss);

$sqlfund = "SELECT `id`, `Fundcategory` FROM `m_fundcluster` WHERE `isactive` = 1 
order by `id` asc";

$qrycluster = mysqli_query($con,$sqlfund );
echo '
<div class="row">
<div class="col-xs-4"><div class="form-group">
<div class="form-group has-feedback">
<input type="text" class="form-control" placeholder="Fund Source" id="txtsource" name= "txtsource" required="true" readonly="true">
<span class="glyphicon glyphicon-bookmark form-control-feedback"></span>

</div>
</div></div>

<div class="col-xs-4">
<select class="form-control" id="selPhysicalA" >';
while ($rows = mysqli_fetch_array($qryss)) {
	
echo 	'<option value="'.$rows['id'].'">'.$rows['typeofassets'].'</option>
	';
}
echo '</select>
</div><div class="col-xs-4">
<button class="btn btn-primary" id="btnshowapprovalspc">Show</button>
</div>
</div>

<div class="row">
<div class="col-xs-4"><div class="form-group">



</div></div>
<div class="col-xs-8">	<div id="cnoption"></div></div>



</div>
<div id="newcontaner"></div>';

?>

