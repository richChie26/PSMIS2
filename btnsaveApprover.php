<?php
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;


$ressel = $_GET['ressel'];
$scesel = $_GET['scesel'];
$appid = $_GET['appid'];

$sqlselect ="select userid from a_deparmentapproval where isactive = 1 and 
`userid` = $appid and 
 `responsibilitycenterid` = $ressel and  `sectionid` =$scesel 
";
$qrysel = mysqli_query($con,$sqlselect);

if(mysqli_num_rows($qrysel) > 0 ){
echo 2 ;
}else{
    $sql = "insert into  `a_deparmentapproval`(`userid`, `responsibilitycenterid`, `sectionid`, `isactive`, `createdby`, `creationdate`)
    VALUES
    ($appid, $ressel,$scesel , 1, $uid, now())";
    mysqli_query($con,$sql);
    echo 1 ;
}


?>