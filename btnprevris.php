
<?php

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$risno = $_GET['mydata'];
  $sqllist = "SELECT a.id,
accounttitle,stockno,itemname,
description,Approvedqty qty,


units
FROM `t_requisitiondetails` a 
left join (SELECT 
x.id,z.accounttitle,
 x.item itemname,`stockno`,`description`
,za.units
FROM `m_materials` x 
left join m_itemname y on x.item = y.id and y.isactive = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.`units` = za.id and za.isactive = 1  
where x.isactive = 1 ) b on a.`itemid` = b.id 
where `RSIcode` = '$risno' 
";

  $qrylist = mysqli_query($con,$sqllist);


?>

<table class="table table-striped">
                      <thead>
                        <tr class="info">
                           <th>Stoc No.</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Units</th>
                            <th>Qty</th>
                        
                            
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['risno']; ?>">
                        <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {
                           echo '<tr class= "itemrow" id="'.$newrow['id'].'|'.$newrow['stockno'].'|'.$newrow['itemname'].'|'.$newrow['description'].'|'.$newrow['units'] .'" >
                                <td>'.$newrow['stockno'].'</td>
                                <td>'.$newrow['itemname'].'</td>
                                <td>'.$newrow['description'].'</td>
                                <td>'.$newrow['units'].'</td>
                                <td>'.$newrow['qty'].'  </td>
                            
        
  </tr>';

                          }
                        ?>
                    
                           
                      </tbody>
                </table>