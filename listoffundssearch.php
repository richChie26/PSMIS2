<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$txtsearchfund = $_GET['txtsearchfund'];
$sql = "SELECT 
`id`, `code`, `FinancingSource`, `Authorization`, `Fundcategory`
FROM `m_fundcluster` WHERE `isactive` = 1 
and Fundcategory like '%".$txtsearchfund."%'
order by code ASC "; 

$qry = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemrowfund" id="'.$row['id'].'|'.$row['Fundcategory'].'" >
			  <td>'.$row['code'].'</td>
			  <td>'.$row['FinancingSource'].'</td>
			  <td>'.$row['Authorization'].'</td>
			  <td>'.$row['Fundcategory'].'</td>
	</tr>';
}
?>