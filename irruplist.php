<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename,a.Position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$positon = $aarres['Position'];
$completename  = $aarres['completename'];
$rid = $aarres['rid'];
?>

<table class="table">
			  <thead style="background-color: #337ab7;color:white;padding: 0px;">
			<tr>
				<th>Date Acquired</th>
				<th>Particulars/
				Articles</th>
				<th>Property No.</th>
				<th>Qty</th>
				<th>Unit Cost</th>
				
				<th>Total Cost</th>
				<th>Remarks</th>
				<th></th>
			</tr>
</thead><tbody id="tbats">
			<?php 

$sqlirrup = "SELECT a.id, concat(d.item ,' ', c.description) Particular, c.ResponsibilityCenter,format(amount,2) amount, 
substring(c.dateaquired,1,10) dateaquired,PARNO,a.propertyno ,remarks FROM `t_returndetails` a
left join t_returns b on a.rcode = b.rcode and b.isactive =1 
left join t_equipmentdeliverydetails c on a.propertyno = c.propertyno and c.isactive = 1 
left join m_equipent d on c.itemid = d.id and d.isactive = 1 
left join t_iirupdetails e on  a.`propertyno` = e.propertyno and e.isactive =1 
where `condition` in ('Unserviceable','for Disposal','Disposed')
and ifnull(e.propertyno,'') != '' and c.ResponsibilityCenter = $rid ";
$qryirrup = mysqli_query($con,$sqlirrup);
while ($row = mysqli_fetch_array($qryirrup)) {
	echo '<tr>
			<td>'.$row['dateaquired'].'</td>
			<td>'.$row['Particular'].'</td>
			<td>'.$row['propertyno'].'</td>
			<td>1</td>
			<td><span>&#8369;</span>'.$row['amount'].'</td>
			<td><span>&#8369;</span>'.$row['amount'].'</td>
			<td>'.$row['remarks'].'</td>
			<td><a href="#" id = "'.$row['id'].'"class="btnprintirr"><span class = "glyphicon glyphicon-print"></a></span></td> 
           
			</tr>
';
}
?>
</tbody>
			</table>
