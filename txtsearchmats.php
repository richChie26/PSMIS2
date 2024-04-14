<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $mnuasset = $_GET['mnuasset'];
    $txtsearchmats = $_GET['txtsearchmats'];
$sql = "SELECT a.`id`, d.accounttitle,a.item, `stockno`, `description`,b.units FROM `m_materials` a 
left join m_units b on a.`units` = b.id and b.isactive = 1 
left join m_itemname c on a.item = c.id and c.isactive = 1 

left join (SELECT x.id ,`typeofasset`,accounttitle FROM `m_accouttitle` x 
left join m_assets y on x.`typeofasset` = y.id and y.isactive = 1 
where x.isactive =1 ) d on a.`titleid` = d.id and d.typeofasset = $mnuasset

where a.isactive = 1 and 
description like '%". $txtsearchmats ."%'

order by a.description Asc limit 10
"; 

$qry = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemrow" id="'.$row['id'].'|'.$row['stockno'].'|'.$row['item'].'|'.$row['description'].'|'.$row['units'] .'|'.$row['accounttitle'] .'" >
        <td>'.$row['accounttitle'].'</td>
			  <td>'.$row['stockno'].'</td>
			  <td>'.ucwords(strtolower($row['item'])).'</td>
			  <td>'.ucwords(strtolower($row['description'])).'</td>
			  <td>'.$row['units'].'</td>
	</tr>';
}
		
?>
