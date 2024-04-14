<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


 if(!isset($_GET['txtsections']) || (trim($_GET['txtsections']) == '')) {
       $_GET["txtsections"]  = "";
    }
    $rc = $_GET["txtsections"] ;

    $sql = ' SELECT `id`, `position` FROM `a_position` where  position like "%'. $rc .'%"
    order by `position` ASC';
$qry = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($qry)){
    echo ' <tr> <td>'. $row['position'].'</td>
                   
     <td><center><a href="#" class="btnpositionedit" id="'.$row['id']. '|'.$row['position'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnpositiondel" id="'.$row['id'].'|'.$row['position'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


  }
?>