<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"];
    $editbtnid = $_GET['editbtnid'];
	$txtquantity = $_GET['txtquantity'];
	$txtamount = $_GET['txtamount'];
	$txtserial = $_GET['txtserial'];

$sql = "SELECT id FROM `t_tempreceived` WHERE `itemid`  = $editbtnid and `createdby` = $uid ";

	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry)> 0 ){
	$result[] = array("msg" => "Item Already Exist!" , "tag" =>"1");

	}else{
			$sqlinsert = "insert into `t_tempreceived`(`itemid`, `qty`, `createdby`,amount,serials)
values($editbtnid, $txtquantity, $uid,$txtamount,'$txtserial')";
			mysqli_query($con,$sqlinsert);	
			 $result[] = array("msg" => "Success Materials and Supply  is Successefully Added!" , "tag" =>"2");
	}
	

	   echo json_encode($result);
     mysqli_close($con);
    ?>