<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $txtsearch = $_GET['txtsearch'];

?>
<?php 
   							$sqlmenu = "select  * from ( SELECT 
							   description,   b.`id`,`itemno`, `item`, d.`accounttitle`, `yearoflife`, `units`
								  ,format(amount,2) amount
								  , ifnull((select x.itemid from t_reclass x where x.isactive =1 and  x.itemid = b.id  ),0) tag
								  FROM  t_equipmentdeliverydetails  a
								   left join `m_equipent` b on a.itemid = b.id and b.isactive =1 
								  left join m_units c on b.unitofmeasurement = c.id and c.isactive = 1 
								  left join m_accouttitle d on b.accounttitle = d.id and d.isactive = 1
								  WHERE b.isactive =1 and d.typeofasset = 3 and a.tag = 0 ) rr
                                   where tag = 0  and amount  < 50000
                                   and item like '%$txtsearch%'
                                   "
                                   
                                   ;
   							$qrymenu = mysqli_query($con,$sqlmenu);
   							while($row = mysqli_fetch_array($qrymenu)){
   								echo '<tr><td style="display:none">
   									<input name="selector[]" id="ad_Checkbox1" class="ads_Checkbox" type="checkbox" value="'.$row['id'].'" /></td>
   									<td>'.$row['itemno'].'</td>
									<td>'.$row['item'].'</td>
									<td>'.$row['description'].'</td>
									
									<td>'.$row['amount'].'</td>
									<td>'.$row['accounttitle'].'</td>
									<td> <button class="btn btn-primary bnmyreclass" id = "'.$row['id'].'"> Reclassify</button></td>
   								</tr>';
   							}
   						?>