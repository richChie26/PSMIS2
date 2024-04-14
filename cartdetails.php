
<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    

    $sql = "SELECT 

a.`id`,b.accounttitle, stockno,itemname ,description, `qty`,Units 'UN',amount, format((`amount`* qty),2) totalAmount

FROM `t_tempreceived` a 
left join (SELECT x.id,z.accounttitle, `stockno`,item itemname,`description`,za.units FROM `m_materials` x 
left join m_itemname y on x.`item` = y.id and y.isactive  = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.units = za.id and za.isactive = 1 
where x.isactive = 1 ) b on a.itemid = b.id

where a.createdby = $uid    
";
// echo $sql;
	$qry = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($qry)) {
		
		echo 
                   ' <tr><td>'.$row['accounttitle'] .'</td>
                    <td>'.$row['stockno'] .'</td>
                    <td>'.ucwords(strtolower($row['itemname'] )).'</td>
                    <td>'.ucwords(strtolower($row['description'])) .'</td>
                    <td>'.$row['qty'] .'</td>
                    <td>'.$row['UN'] .'</td> 
                    <td> <span>&#8369;</span> ' .$row['totalAmount'] .'</td>
                    <td><center><a href="#" class="btnremovetemplist" id= "'.$row['id'].'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></center></a></td></tr>'; 

	}


                 
?>