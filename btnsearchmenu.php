<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$txtsearchmenu = $_GET['txtsearchmenu'];


   							$sqlmenu = 'SELECT `id`, `menucode`, `menuname` FROM `a_menu` WHERE isactive = 1 and menuname like "%'. $txtsearchmenu.'%" order by `menuname` ASC ';
   							$qrymenu = mysqli_query($con,$sqlmenu);
   							while($row = mysqli_fetch_array($qrymenu)){
   								echo '<tr><td>
   									<input name="selector[]" id="ad_Checkbox1" class="ads_Checkbox" type="checkbox" value="'.$row['id'].'" /></td>
   									<td>'.$row['menucode'].'</td>
   									<td>'.$row['menuname'].'</td>
                   
   								</tr>';
   							}

                
   						?>
   				

     
