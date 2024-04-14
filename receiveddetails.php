<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;




    $sql = 'SELECT 
a.id ,`item`, `stockno`, concat(`description`,", ",serials) description,units,`qty`
FROM `t_tempreceived` a 
left join (SELECT x.id,
`item`, `stockno`, `description`
,y.units FROM `m_materials` x 
left join m_units y on x.`units` = y.id and y.isactive = 1 
where x.isactive = 1 ) b on a.`itemid` = b.id 
where `createdby` = '.$uid.' order by a.id asc 

    ';

echo $sql;
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
		echo ' <tr> <td>'. $row['stockno'].'</td>
                <td>'. $row['item'].'</td>
                
                <td>'. $row['description'].'</td>
                <td>'. $row['units'].'</td>
                 <td>'. $row['qty'].'</td>

     
                <td><center><a href="#" class="btnreceivedremove" id="'.$row['id'].'|'.$row['description'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>