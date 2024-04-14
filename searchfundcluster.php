<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


  

    $sql = 'SELECT `id`, `code`, `FinancingSource`, `Authorization`, `Fundcategory` FROM `m_fundcluster` WHERE isactive = 1 ';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
	
           

  	echo ' <tr> <td>'. $row['code'].'</td>

          <td>'. $row['FinancingSource'].'</td>
          <td>'. $row['Authorization'].'</td>
          <td>'. $row['Fundcategory'].'</td>
        
     <td><center><a href="#" class="btneditcluster" id="'.$row['id']. '|'.$row['code'].'|'.$row['FinancingSource'].'|'.$row['Authorization'].'|'.$row['Fundcategory'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnclusterremove" id="'.$row['id'].'|'.$row['Fundcategory'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>