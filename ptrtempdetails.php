<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $tag = $_GET['tag'];
$sql ="SELECT a.id ,b.* FROM `t_tempptr`
 a left join (SELECT a.id delid , 
 b.accounttitle,item,yearoflife,typeofasset, 
 concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, 
 `propertyno` FROM `t_equipmentdeliverydetails` a 
 left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife`,y.typeofasset FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = $tag  and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 and ifnull(a.`Status`,'') = '') b on a.`propertyno` = b.propertyno where a.createdby = $uid and typeofasset = $tag 

  and a.tag = $tag 
";

$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {
	echo '    <tr>

                    <td>'.$row['accounttitle'].'</td>
                    <td>'.$row['propertyno'].'</td>
                    <td>'.$row['description'].'</td>
                    <td>'.$row['yearoflife'].'</td>
                    <td>1</td>
                    <td><center><a href="#" class="btntempptrremove" id="'.$row['id'].'|'.$row['description'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> 
                </tr>';
}
?>

   