<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


 if(!isset($_GET['txtsearchrc']) || (trim($_GET['txtsearchrc']) == '')) {
       $_GET["txtsearchrc"]  = "";
    }
    $rc = $_GET["txtsearchrc"] ;

    $sql = 'SELECT `id`, `Suppliername`, `Address`, `tin`, `contactNo`, `contactperson`, `contactpersonPosition` FROM `m_supplier` WHERE `isactive` = 1 
and Suppliername like "%'. $rc .'%"
    order by `Suppliername` Asc


    ';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
		echo ' <tr> <td>'. $row['Suppliername'].'</td>
                    <td>'. $row['Address'].'</td>
                    <td>'. $row['tin'].'</td> 
                    <td>'. $row['contactperson'].'</td>
                    <td>'. $row['contactNo'].'</td>
                    <td>'. $row['contactpersonPosition'].'</td> 


     <td><center><a href="#" class="btnsupplyedit" id="'.$row['id']. '|'.$row['Suppliername'].'|'.$row['Address']. '|'.$row['tin'].'|'.$row['contactperson'].'|'.$row['contactNo']. '|'.$row['contactpersonPosition'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnsupplyremove" id="'.$row['id'].'|'.$row['Suppliername'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>