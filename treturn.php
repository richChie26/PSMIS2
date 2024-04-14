<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
 $uid = $_SESSION["uid"] ;
$sql = "SELECT a.id,
`parno`, a.`propertyno`, `remarks`, `conditions`, item itemname
,`description`, `Serial`, `amount`, `chasisnumber`,d.accounttitle,datereturn
FROM `temptreturn`  a 
left join t_equipmentdeliverydetails b on a.`propertyno` = b.propertyno 
left join m_equipent c on b.itemid = c.id  and c.isactive = 1 
left join m_accouttitle d on c.accounttitle = d.id and d.isactive = 1 
where a.`createdby` = $uid" ;
     $qry = mysqli_query($con,$sql);                                                                                      
 while($row = mysqli_fetch_array($qry)){
        
     echo    '<tr>


    <td>'.$row['propertyno'].'</td>
    <td>'.$row['itemname'].'</td>
    <td>'.$row['description'].'</td>
    <td>'.$row['parno'].'</td>
   <td>'.$row['conditions'].'</td>
    <td>'.$row['remarks'].'</td>
    <td><a href="#" id="'.$row['id'].'" class="btnremovereturn"><span style="color:red;" class="glyphicon glyphicon-minus"></span></a></td>
                      
                </tr>';
      
           }
 ?>