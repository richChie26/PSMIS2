<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


  

    $sql = 'SELECT a.id, b.typeofassets,a.typeofasset ta ,`accounttitle` ,`Acronyms`, `AccAUCScode`, `SubMajorAccountGroup`, `GLAccount`,   `Activation` FROM `m_accouttitle` a 
left join m_assets b on a.`typeofasset` = b.id and b.isactive = 1 
where a.isactive =1 
order by b.typeofassets,accounttitle ASC
    ';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
	
           $activate = $row['Activation'];
            $img = "";
           if($activate == 1 ){
            $img = '<span class="glyphicon glyphicon-ok" style="color:#76ff03;"></span>';
           }else{
              $img = '<span class="glyphicon glyphicon-remove" style="color:#ef5350;"></span>';
           }

  	echo ' <tr> <td>'. $row['typeofassets'].'</td>

          <td>'. $row['accounttitle'].'</td>
          <td>'. $row['Acronyms'].'</td>
          <td>'. $row['AccAUCScode'].'</td>
          <td>'. $row['SubMajorAccountGroup'].'</td>
            <td>'. $row['GLAccount'].'</td>
             <td>'. $img .'</td>
 
     <td><center><a href="#" class="btnedittitle" id="'.$row['id']. '|'.$row['ta'].'|'.$row['accounttitle'].'|'.$row['Acronyms'].'|'.$row['AccAUCScode'].'|'.$row['SubMajorAccountGroup'].'|'.$row['GLAccount'].'|'.$row['Activation'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btntitleremove" id="'.$row['id'].'|'.$row['accounttitle'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>