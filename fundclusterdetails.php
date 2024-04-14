<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


  

    $sql = 'SELECT `id`, `code`, `FinancingSource`, `Authorization`, `Fundcategory`,
     Activation 
     FROM `m_fundcluster` WHERE isactive = 1 ';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
          $tass = "";
           $Activation = $row['Activation'];
           if($Activation == 1 ){
               $tass = '<span class="glyphicon glyphicon-ok" style="color:#76ff03;"></span>';
              }else{
                 $tass = '<span class="glyphicon glyphicon-remove" style="color:#ef5350;"></span>';
              }
  	echo ' <tr> <td>'. $row['code'].'</td>

          <td>'. $row['FinancingSource'].'</td>
          <td>'. $row['Authorization'].'</td>
          <td>'. $row['Fundcategory'].'</td>
          <td style="text-align:center">'. $tass.'</td>
        
     <td style="text-align:center"><center><a href="#" class="btneditcluster" id="'.$row['id']. '|'.$row['code'].'|'.$row['FinancingSource'].'|'.$row['Authorization'].'|'.$row['Fundcategory'].'|'.$row['Activation'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
     <td style="text-align:center"><center><a href="#" class="btnclusterremove" id="'.$row['id'].'|'.$row['Fundcategory'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>