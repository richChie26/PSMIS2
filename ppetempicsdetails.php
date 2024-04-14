<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$sql ="SELECT a.id aid ,b.* FROM `t_temppar` a 
left join (SELECT a.id, b.accounttitle,item,yearoflife,typeofasset, concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, `propertyno` FROM `t_equipmentdeliverydetails` a left join
 (SELECT x.id , y.`accounttitle`, `item`,`yearoflife`,y.typeofasset FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = 2 and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 and  ifnull(a.`Status`,'') = '')  b on a.`propertyno` = b.propertyno 
where a.createdby = $uid and typeofasset =2
";

$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {
	echo '    <tr>

                    <td>'.$row['accounttitle'].'</td>
                    <td>'.$row['propertyno'].'</td>
                    <td>'.$row['description'].'</td>
                    <td>'.$row['yearoflife'].'</td>
                    <td>1</td>
                    <td><center><a href="#" class="btnremovemyppedetails" id="'.$row['aid'].'|'.$row['description'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> 
                </tr>';
}
?>

   