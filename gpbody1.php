<?php

include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $cmbGroup = $_GET['cmbGroup'];


    $sql = "SELECT gs.id,
username,Cname,Position

FROM `a_groupsetup` gs
left join (SELECT b.userid , b.username,

concat(lname, ', ',`fname`,' ', substring(`mname`,1,1),'.') Cname ,  `Position`

FROM `u_profile` a 
left join a_user b on a.`profileid` = b.profileid and b.isactive =1 

where a.isactive  =1 and ifnull(b.username ,'') !='') prof on gs.`userid` = prof.userid
where gs.isactive =1 and gs.`groupid` = $cmbGroup ";
 
$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {

	echo '<tr class="mytr" id="'.$row['id'].'">
        <td>'.'<input name="selectors[]" id="chkmenu" class="ads_Checkboxs" type="checkbox" value="'.$row['id'].'" /></td>' .
		'<td>'.$row['username'].'</td>' .
		'<td>'.$row['Cname'].'</td>'.
		'<td>'.$row['Position'].'</td>'.
		'</tr>';
}
 ?>