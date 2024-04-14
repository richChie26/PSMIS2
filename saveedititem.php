<?php
include 'cn.php';
$propertyno = $_GET['propertyno'];
$dtpdateaquired = $_GET['dtpdateaquired'];
$txtamount = $_GET['txtamount'];
$txtdesc = $_GET['txtdesc'];
$txtserial = $_GET['txtserial'];
$txtarticlee = $_GET['txtarticlee'];
$sql = "update  `t_equipmentdeliverydetails` 
set 
`dateaquired` = '$dtpdateaquired', 
`description` = '$txtdesc', `Serial` ='$txtserial',
amount = $txtamount,
itemid = ( select x.id from m_equipent x where
 x.item = '$txtarticlee' and x.isactive =1 limit 1  ) 

where `propertyno` = '$propertyno'
";


mysqli_query($con,$sql);
?>