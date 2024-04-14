<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;




    $sql = "SELECT a.id ,b.accounttitle, stockno , `itemname`,  `description`, a.qty, `units` FROM `t_temprec` a
left join (SELECT  x.id, z.accounttitle, stockno ,item itemname,  `description`, y.`units` FROM `m_materials` x 
left join m_accouttitle z on x.`titleid` = z.id  and z.isactive = 1 
left join m_units y on x.`units` = y.id and y.isactive  = 1
left join m_itemname za on x.item = za.id and za.isactive =1            
           
where x.isactive = 1) b on a.itemid = b.id 
where `createdby` = $uid ";


$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
		echo ' <tr> <td>'. $row['stockno'].'</td>
                <td>'. $row['itemname'].'</td>
                
                <td>'. $row['description'].'</td>
                <td>'. $row['units'].'</td>
                 <td>'. $row['qty'].'</td>
                

     
                <td><center><a href="#" class="btnrequestremove" id="'.$row['id'].'|'.$row['description'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>