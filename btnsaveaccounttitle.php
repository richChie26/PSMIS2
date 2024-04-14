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
    $chkactive = preg_replace("/'/", "",$_GET['chkactive']);

    $sql = "SELECT `id`, `accounttitle` FROM `m_accouttitle` WHERE isactive =1 and  accounttitle = '$txtaccounttitle' ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Duplicate Account Title Already Exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Success Account Title is Successefully Saved!" , "tag" =>"2");

            $sqlinsert = "insert into  `m_accouttitle` (`accounttitle`, `isactive`, `createdby`, `creationdate`,
`typeofasset`, `Acronyms`, `AccAUCScode`, `SubMajorAccountGroup`, `GLAccount`, `Activation`)
values
 ('$txtaccounttitle', 1, $uid, now()
,'$accasset'
,'$Acronyms'
,'$aucscode'
,'$submajor'
,'$glaccount' 
,$chkactive
)";
  mysqli_query($con,$sqlinsert);

    }


echo json_encode($result);
mysqli_close($con);
?>