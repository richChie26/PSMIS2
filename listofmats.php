
<head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $mnuasset = $_GET['mnuasset'];
$sqlres = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";

$qryres = mysqli_query($con,$sqlres);
$arrres = mysqli_fetch_array($qryres);

$Responsibility = $arrres['Responsibility'];


$sql = "SELECT a.`id`, d.accounttitle,a.item , `stockno`, `description`,b.units 

,ifnull((SELECT sum(`qty`) FROM `t_itemreceived`  ax  WHERE ax.`itemid` = a.`id` and ax.isactive =1  and ax.ResponsibilityCenter = $Responsibility 
),0)
- 
ifnull((SELECT 
case when fg.status = 'Pending' then
sum( fg.`qty`) 
else
  sum(fg.`approvedqty`)
end  

FROM `t_requisitiondetails` fg  WHERE fg.itemid = a.id 
and fg.ResponsibilityCenter = $Responsibility 
),0) bal,a.reorderpoint

FROM `m_materials` a 
left join m_units b on a.`units` = b.id and b.isactive = 1 
left join m_itemname c on a.item = c.id and c.isactive = 1 

left join (SELECT x.id ,`typeofasset`,accounttitle FROM `m_accouttitle` x 
left join m_assets y on x.`typeofasset` = y.id and y.isactive = 1 
where x.isactive =1 ) d on a.`titleid` = d.id and d.typeofasset = $mnuasset

where a.isactive = 1 order by a.description Asc 
"; 
 // echo $sql;
$qry = mysqli_query($con,$sql);

echo '

<div class= "row"> <div class="col-xs-12">
<table id="example"  style="width:100%"   class ="display">
                <thead style="background-color: #337ab7;color:white;"> <tr>
		<th>Account Title</th>
    <th>Stoc No.</th>
		<th>Item Name</th>
		<th>Description</th>
		<th>Units</th>
		</tr></thead><tbody id="listofmats">
		';

while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemrow" id="'.$row['id'].'|'.$row['stockno'].'|'.$row['item'].'|'.$row['description'].'|'.$row['units'] .'|'.$row['accounttitle'] .'|'.$row['bal']  .'|'.$row['reorderpoint'] .'" >
        <td>'.$row['accounttitle'].'</td>
			  <td>'.$row['stockno'].'</td>
			  <td>'.$row['item'].'</td>
			  <td>'.$row['description'].'</td>
			  <td>'.$row['units'].'</td>
	</tr>';
}
echo '</tbody></table></div></div>';		
?>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>