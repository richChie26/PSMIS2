<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$txtsearhname = $_GET['txtsearhname'];



   							$sqlmenu = ' SELECT
               userid, up.`profileid`,ifnull(au.username,"") username,

                concat(lname,", ",`fname`," ", substring(`mname`,1,1),".") Completename ,             `Position`,rc. `ResponsibilityCenter`,sec.`Section`,`contactNo`
                ,`address`

                FROM `u_profile` up 
                left join a_user au on up.`profileid` = au.profileid and au.isactive = 1 
                left join a_responsibilitycenter rc on up.`ResponsibilityCenter` =rc.id and           rc.isactive =1 
                left join a_section sec on up.section = sec.id and sec.isactive = 1 
                
                where up.isactive = 1  and ifnull(au.username,"") != ""
                
                and concat(lname,", ",`fname`," ", substring(`mname`,1,1)) like "%'. $txtsearhname.'%" 
                order by  concat(lname,", ",`fname`," ", substring(`mname`,1,1)) ASC ';
   							$qrymenu = mysqli_query($con,$sqlmenu);
   							while($row = mysqli_fetch_array($qrymenu)){
   								echo '<tr><td>
   									<input name="selector[]" id="ad_Checkbox1" class="ads_Checkbox" type="checkbox" value="'.$row['userid'].'" /></td>
   									<td>'.$row['username'].'</td>
   									<td>'.$row['Completename'].'</td>
                      <td>'.$row['Position'].'</td>
   								</tr>';
   							}

          
   						?>
   				

     
