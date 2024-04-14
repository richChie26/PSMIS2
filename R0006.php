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

$sqlss = "SELECT id,`accounttitle` FROM `m_accouttitle` where isactive = 1 and `typeofasset` = 1 order by `accounttitle` asc ";
$qryss = mysqli_query($con,$sqlss);
echo '<div class="row"><div class="col-xs-5"><div class="form-group"><select class="form-control" id="selmyacct" >';
while ($rows = mysqli_fetch_array($qryss)) {
	
echo 	'<option value="'.$rows['id'].'">'.$rows['accounttitle'].'</option>
	';
}
echo '</select></div></div>

<div class="col-xs-6"><button class="btn btn-primary" id="btnprintrpci" style="float: right;">Print</button></div>
</div>';
?>


<table class="table table-stripped">
	<tr>
		<td>Article</td>
		<td>Description</td>
		<td>Stock No.</td>
		<td>Unit of Measurement</td>
		<td>Unit Cost</td>
		<td>Balance Per Card</td>
		<td>On Hand Per Count</td>
		<td>Shortage/Overage</td>
		<td></td>
		<td>Remarks</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>Quantity</td>
		<td>Quantity</td>
		<td>Quantity</td>
		<td>Value</td>
		<td></td>
	</tr>
	<tbody id="tblrpci"></tbody>
</table>
