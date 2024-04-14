<?php
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;


$PARNO = $_GET['mydata'];
$sqllist = "SELECT f.id ,b.* FROM `t_pardetails` f left join (SELECT a.id delitemid, b.accounttitle,item,yearoflife, concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, `propertyno` FROM `t_equipmentdeliverydetails` a left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife` FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = 2 and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 ) b on f.`propertyno` = b.propertyno
where f.parno = '$PARNO' and f.tag = 2";
$qrylist = mysqli_query($con,$sqllist);
?>

<table class="table table-striped">
                <thead>
                  <tr class="info">

                    <th>Account Title</th>
                    <th>Property No.</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Estimated Usefull life</th>

                  </tr>
                </thead>

                <tbody >
                  <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {
                           echo '<tr>
                           	<td>'.$newrow['accounttitle'].'</td>
                           	<td>'.$newrow['propertyno'].'</td>
                           	<td>'.$newrow['description'].'</td>
                           	<td>1</td>
                           	<td>'.$newrow['yearoflife'].'</td>
                           </tr>';

                          }
                        ?>

                </tbody>
              </table>
