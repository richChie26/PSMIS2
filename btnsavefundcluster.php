<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

 $fundcode = preg_replace("/'/", "",$_GET['fundcode']);
 $fsource = preg_replace("/'/", "",$_GET['fsource']);
 $txtauthorization = preg_replace("/'/", "",$_GET['txtauthorization']);
 $fcategory = preg_replace("/'/", "",$_GET['fcategory']);
$chkactive = $_GET['chkactive'];


    $sql = "SELECT `id`, `Fundcategory` FROM `m_fundcluster` WHERE isactive =1 and  Fundcategory = '$fcategory' ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist." , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Successefully saved." , "tag" =>"2");

            $sqlinsert = "insert into  `m_fundcluster` (`code`, `FinancingSource`, `Authorization`, `Fundcategory`,`isactive`, `createdby`, `creationdate`
            ,activation )values
 ('$fundcode', '$fsource', '$txtauthorization', '$fcategory',1, $uid, now(),$chkactive)";
  mysqli_query($con,$sqlinsert);

    }


echo json_encode($result);
mysqli_close($con);
?>