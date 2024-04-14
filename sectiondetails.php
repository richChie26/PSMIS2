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


    $sql = ' SELECT `section`,`id` FROM `a_section` WHERE `isactive` = 1 

    order by `section` ASC';
$qry = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($qry)){
    echo ' <tr> <td>'. $row['section'].'</td>
                   
     <td><center><a href="#" class="btnsectionedit" id="'.$row['id']. '|'.$row['section'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnsectiondel" id="'.$row['id'].'|'.$row['section'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


  }
?>

