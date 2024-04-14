<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $myid = $_GET['myid'];
$purpose = $_GET['purpose'];
$Requestedby = $_GET['Requestedby'];
$DateRequest =  strtotime($_GET['DateRequest']);
$remarks = $_GET['result'];
$yourid = $_GET['yourid'];
$formatted_date = date("F d, Y ", $DateRequest);
$sql = "SELECT a.id,
accounttitle,stockno,itemname,
description,`qty`,
 (SELECT 
 
sum(`qty`) Received



FROM `t_itemreceived` k 
where k.`itemid` = a.itemid and k.`ResponsibilityCenter` = a.ResponsibilityCenter 
and k.isactive = 1 )    
 - (SELECT ifnull(
case when `Status` = 'Pending' then 
  sum(ifnull(`qty`,0))
   when  `Status` = 'Approved' then
   sum( ifnull(`approvedqty`,0))
end,0) issued

FROM `t_requisitiondetails` x WHERE  x.`itemid` = a.itemid   and x. `ResponsibilityCenter` = a.ResponsibilityCenter
and `Status` in ('Approved') ) Available

,units
FROM `t_requisitiondetails` a 
left join (SELECT 
x.id,z.accounttitle,
itemname,`stockno`,`description`
,za.units
FROM `m_materials` x 
left join m_itemname y on x.item = y.itemname and y.isactive = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.`units` = za.id and za.isactive = 1  
where x.isactive = 1 ) b on a.`itemid` = b.id 
where `RSIcode` = '$myid' and ifnull(a.Status,'') = 'Pending'
 "; 

$qry = mysqli_query($con,$sql);
// echo $sql;
echo ' <center><h3>Inventory Requested</h3></center><br/>
<div class= "row">
 <div class="col-xs-6">
  <span style="font-weight:bold"> RIS Code:</span> '.$myid.'<br/>

</div>
<div class="col-xs-6">
<span style="font-weight:bold">Date Requested: </span>'.$formatted_date.'<br/>

</div>


</div>
<div class= "row"> <div class="col-xs-6">
 <span style="font-weight:bold">  Purpose:</span> '.$purpose.'<br/>
 
</div>
 <div class="col-xs-6">
  <span style="font-weight:bold"> Requested by: </span>'.$Requestedby.'<br/>

</div></div>

<div class= "row"> <div class="col-xs-12">
  <span style="font-weight:bold">  Remarks: </span>'.$remarks.'<br/>
<label></label>
</div></div>
<div class= "row"> <div class="col-xs-12"><table class ="table table-striped">
                <thead style="background-color: #337ab7;color:white;"> <tr>
		<th>Stoc No.</th>
		<th>Item Name</th>
		<th>Description</th>
		<th>Units</th>
    <th>Qty</th>
    <th>Available</th>
   
      <th style="display:none">Approve</th>
		</tr></thead><tbody id="listofmats">
		';

while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemrow" id="'.$row['id'].'|'.$row['stockno'].'|'.$row['itemname'].'|'.$row['description'].'|'.$row['units'] .'" >
			  <td>'.$row['stockno'].'</td>
			  <td>'.$row['itemname'].'</td>
			  <td>'.$row['description'].'</td>
			  <td>'.$row['units'].'</td>
        <td>'.$row['qty'].'</td>
        <td>'.$row['Available'].'</td>
       
        <td style="display:none;"> <button class="btn btn-primary btnapproveris" id="'.$row['id'].'" style=" padding-right: : 15px;margin-right: :15px;"><span class="glyphicon glyphicon-thumbs-up">&nbsp;Approve</span></button></td>
	</tr>';
}
echo '</tbody></table></div></div>';		
?>

<div class="row">
      <div class="col-xs-12">
          <div class="alert alert-info"> Are you sure you want to approve this request? </div>
      </div>

</div>

<div class="row">
    <div class="col-xs-12">

        <button class="btn btn-primary btnyesapproval" id="<?php
        echo $yourid .'|'. $remarks;

        ?>">Yes</button>
        <button class="btn btn-danger" id="bntnonono">No</button>
    </div>
</div>
