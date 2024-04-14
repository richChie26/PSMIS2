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


    $sql = 'SELECT 
`id`, `rccode`,`ResponsibilityCenter`, `operationUnitCode`, `Description`
FROM `a_responsibilitycenter` WHERE isactive =1 
order by `ResponsibilityCenter` ASC';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
		echo ' <tr> <td>'. $row['rccode'].'</td>
                    <td>'. $row['ResponsibilityCenter'].'</td>
                    <td>'. $row['operationUnitCode'].'</td> 
     <td><center><a href="#" class="btnrcedit" id="'.$row['id']. '|'.$row['rccode'].'|'.$row['ResponsibilityCenter']. '|'.$row['operationUnitCode'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnrcremove" id="'.$row['id'].'|'.$row['ResponsibilityCenter'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>