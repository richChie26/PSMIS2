<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$txtaccounttitle = preg_replace("/'/", "",$_GET['txtaccounttitle']);
$accasset = preg_replace("/'/", "",$_GET['accasset']);
$Acronyms = preg_replace("/'/", "",$_GET['Acronyms']);
$aucscode = preg_replace("/'/", "",$_GET['aucscode']);
$submajor = preg_replace("/'/", "",$_GET['submajor']);
$glaccount = preg_replace("/'/", "",$_GET['glaccount']);
$chkactive = $_GET['chkactive'];
$editbtnid = $_GET['editbtnid'];

    $sql = "SELECT `accounttitle` FROM `m_accouttitle` WHERE isactive =1 
and `accounttitle` = '$txtaccounttitle'  and id != $editbtnid ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Duplicate Account Title Already Exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Success Account Title is Successefully Saved!" , "tag" =>"2");

            $sqlinsert = "update `m_accouttitle`  set 
`accounttitle` ='$txtaccounttitle', 
`typeofasset` = $accasset, 
`Acronyms`= '$Acronyms', 
`AccAUCScode`= '$aucscode',
`SubMajorAccountGroup`= '$submajor',
`GLAccount`=  '$glaccount', 
`Activation` =  $chkactive

,`previouslymodifiedby` = `modifiedby`,
`previousmodificationdate` = `modificationdate` ,
`modifiedby` = $uid, `modificationdate` = now()
where `id` = $editbtnid

";
  mysqli_query($con,$sqlinsert);
    }
	  echo json_encode($result);
     mysqli_close($con);
?>