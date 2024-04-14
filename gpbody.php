<?php

include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $cmbGroup = $_GET['cmbGroup'];


    $sql = "SELECT 
a.id 
,`menucode`, `menuname`,

`Groupnane`, `Description`

FROM `a_menusetup` a
left join a_group  b on a.`groupid` = b.id and b.isactive =1 
left join a_menu c on a.`menuid` = c.id and c.isactive =1 
where a.isactive =1 and a.`groupid` =$cmbGroup ";
 
$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {

	echo '<tr class="mytr" id="'.$row['id'].'">
        <td>'.'<input name="selectors[]" id="chkmenu" class="ads_Checkboxs" type="checkbox" value="'.$row['id'].'" /></td>' .
		'<td>'.$row['Groupnane'].'</td>' .
		'<td>'.$row['Description'].'</td>'.
		'<td style="background-color:#98FB98;border-color:#98FB98;">'.$row['menucode'].'</td>'.
		'<td style="background-color:#98FB98;border-color:#98FB98;">'.$row['menuname'].'</td></tr>';
}
 ?>