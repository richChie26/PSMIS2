<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


 if(!isset($_GET['txtdivision']) || (trim($_GET['txtdivision']) == '')) {
       $_GET["txtdivision"]  = "";
    }
    $rc = $_GET["txtdivision"] ;

    $sql = ' SELECT `id`, `division` FROM `a_division` WHERE isactive = 1 
and division like "%'. $rc .'%"
    order by `division` ASC';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
		echo ' <tr> <td>'. $row['division'].'</td>
                   
     <td><center><a href="#" class="btndivedit" id="'.$row['id']. '|'.$row['division'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btndivisiondel" id="'.$row['id'].'|'.$row['division'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>