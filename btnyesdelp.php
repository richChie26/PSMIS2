<?php 
include 'cn.php';

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
    $_SESSION["uid"]  = 0;
 }
 $uid = $_SESSION["uid"] ;

$propertyno = $_GET['propertyno'];

$sql = "update  `t_equipmentdeliverydetails` set isactive = 0 ,
`previouslymodifiedby` =`modifiedby` ,
 `previousmodificationdate` =`modificationdate`,
`modifiedby` = $uid, `modificationdate` = now() 


where 
`propertyno` ='$propertyno'";

mysqli_query($con,$sql);
$sql2 = "update  `t_par` set isactive = 0 

,`previouslymodifiedby` = `modifiedby`, 
`previousmodificationdate` = `modificationdate`,
`modifiedby` = $uid, `modificationdate` = now()
WHERE `PARNO` = (select parno from t_pardetails where `propertyno` = '$propertyno') ";

$sql3 ="delete  FROM `t_pardetails` WHERE `propertyno` = '$propertyno'";
mysqli_query($con,$sql3);
$sql4 = "delete  FROM `t_returndetails` WHERE `propertyno` = '$propertyno'";
mysqli_query($con,$sql4);
?>