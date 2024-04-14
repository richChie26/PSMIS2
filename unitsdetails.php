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

    $sql = ' SELECT `id`, `units` FROM `m_units` where isactive = 1 
and units like "%'. $rc .'%"
    order by units ASC';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
		echo ' <tr> <td>'. $row['units'].'</td>
                   
     <td><center><a href="#" class="btnunitsedit" id="'.$row['id']. '|'.$row['units'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnunitsremove" id="'.$row['id'].'|'.$row['units'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>