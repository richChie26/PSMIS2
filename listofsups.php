<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$txtsearchsupplier = $_GET['txtsearchsupplier'];
$sql = "SELECT `id`, `Suppliername`,
`Address`, `tin`, `contactNo`, `contactperson`, `contactpersonPosition`
 FROM `m_supplier` WHERE `isactive` = 1
and Suppliername like '%".$txtsearchsupplier."%'
  order by `Suppliername` ASC limit 10"; 

$qry = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemrowsupplier" id="'.$row['id'].'|'.$row['Suppliername'].'" >
			  <td>'.$row['Suppliername'].'</td>
			
			
			  <td>'.$row['contactperson'].'</td>
        <td>'.$row['contactNo'].'</td>
        <td>'.$row['contactpersonPosition'].'</td>

	</tr>';
}
?>