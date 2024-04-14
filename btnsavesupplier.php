<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$supplier = ucwords(strtolower($_GET['supplier']));
$address =   ucwords(strtolower($_GET['address']));
$tin =  ucwords(strtolower($_GET['tin']));
$cp =  ucwords(strtolower($_GET['cp']));
$cpnumber  =  ucwords(strtolower($_GET['cpnumber']));
$cpPosition =  ucwords(strtolower($_GET['cpPosition']));


// $supplier = ucwords(strtolower(preg_replace("/'/",$_GET['supplier'])));
// $address =   ucwords(strtolower(preg_replace("/'/",$_GET['address'])));
// $tin =  ucwords(strtolower(preg_replace("/'/",$_GET['tin'])));
// $cp =  ucwords(strtolower(preg_replace("/'/",$_GET['cp'])));
// $cpnumber  =  ucwords(strtolower(preg_replace("/'/",$_GET['cpnumber'])));
// $cpPosition =  ucwords(strtolower(preg_replace("/'/",$_GET['cpPosition'])));

    $sql = "SELECT `Suppliername` FROM `m_supplier` WHERE `isactive`  = 1 and `Suppliername` = '$supplier'";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Supplier Name Already Exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Success Supplier   Name is Successefully Saved!" , "tag" =>"2");

            $sqlinsert = "Insert into`m_supplier`(`Suppliername`, `Address`, `tin`, `contactNo`, `contactperson`, `contactpersonPosition`, `isactive`, `createdby`, `creationdate`)
values
('$supplier', '$address', '$tin', '$cpnumber', '$cp', '$cpPosition', 1, $uid, now())";
  mysqli_query($con,$sqlinsert);
    }
	  echo json_encode($result);
     mysqli_close($con);
?>