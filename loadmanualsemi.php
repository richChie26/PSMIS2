<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sql = "SELECT a.id ,
`itemid`,
accounttitle , itemno, item,yearoflife ,units,
`decription` , `cha`, `serial`,amount
FROM `t_temptransfer` a
left join (SELECT x.id,
z.accounttitle , `itemno`, `item`,`yearoflife` ,y.units
FROM `m_equipent` x
left join m_units y on x.`unitofmeasurement` = y.id and y.isactive = 1 
left join m_accouttitle  z on x.`accounttitle` = z.id and z.isactive = 1 
          where x.isactive =1 ) b on a.`itemid` =b.id 
          where `createdby` =  $uid and a.tag = 1 ";
   
$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {
echo '         <tr>


                <td>  '.$row['accounttitle'].'</td>
                     <td> '.$row['item'].'</td>
                    <td> '.$row['decription'].'</td>
                    <td> '.$row['serial'].'</td>
                    <td> '.$row['cha'].'</td>
                    
                    <td> '.$row['yearoflife'].'</td>
                    <td> 1</td>
                     <td> '.$row['units'].'</td> 
                    <td> '.$row['amount'].'</td>
                  
                     <td><center><a href="#" class="btnremovemanualsemi" id= "'.$row['id'].'|'.$row['item'].'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></center></td> <tr> ';
}
    ?> 