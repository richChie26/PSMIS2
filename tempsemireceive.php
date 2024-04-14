<?php

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sql = "SELECT f.id
,accounttitle
,item
,yearoflife,
format(`amount`,2) amount, `description`, `serial`, `dateaquire`
,b.units
FROM `t_tempsemipee` f
left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife`,units FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1
           left join m_units z    on x.unitofmeasurement = z.id and z.isactive = 1
           where y.typeofasset = 2 and x.isactive =1) b on `itemid` = b.id 
where tag = 2 and `createdby` = $uid ";



$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {
	echo '<tr>
	<td>'.ucwords(strtolower($row['accounttitle'])).'</td>
	<td>'.ucwords(strtolower($row['item'])).'</td>
	<td>'.ucwords(strtolower($row['description'])).' </td>
	<td>'.$row['serial'].'</td>
	<td>'.$row['dateaquire'].' </td>
	<td> '.$row['yearoflife'].'</td>
	<td>1</td> 
	<td>'.ucwords(strtolower($row['units'])).'</td> 
	<td><span>&#8369;</span> '.$row['amount'].'</td>

	<td><center><a href="#" class="btnremovesimeppe" id= "'.$row['id'].'|'.$row['item'].'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></center></td> 
</tr>';
}
?>

