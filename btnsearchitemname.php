<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $txtsearchitemname  = $_GET['txtsearchitemname'];
  $seltitle = $_GET['seltitle'];

    $sql = 'SELECT a.`id`, a.`itemname` , a.`accounttitle` accounttitleid ,b.accounttitle  FROM `m_itemname` a 
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
WHERE a.`isactive` = 1 

 and  a.`itemname` like "%'.$txtsearchitemname .'%" 
order by a.`itemname` ASC 
    ';

$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
	
        

  	echo ' <tr> 
<td>'. $row['accounttitle'].'</td>
    <td>'. $row['itemname'].'</td>

         


                   


     <td><center><a href="#" class="btnedititemname" id="'.$row['id']. '|'.$row['itemname'].'|'.$row['accounttitleid'].'|'.$row['accounttitle'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnremoveitemname" id="'.$row['id'].'|'.$row['itemname'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>