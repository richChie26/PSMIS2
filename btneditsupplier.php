<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$supplier = $_GET['supplier'];
$address =   $_GET['address'];
$tin =  $_GET['tin'];
$cp =  $_GET['cp'];
$cpnumber  =  $_GET['cpnumber'];
$cpPosition =  $_GET['cpPosition'];
    $editbtnid = $_GET['editbtnid'];

    $sql = "SELECT `Suppliername` FROM `m_supplier` WHERE isactive =1 
and `Suppliername` = '$supplier'  and id != $editbtnid ";


	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Successefully updated" , "tag" =>"2");

            $sqlinsert = "update `m_supplier`  set 


`Suppliername` = '$supplier',
 `Address` = '$address ', 
 `tin` = '$tin', 
 `contactNo` = '$cpnumber', 
 `contactperson` = '$cp',
  `contactpersonPosition` = '$cpPosition',

`previouslymodifiedby` = `modifiedby`,
`previousmodificationdate` = `modificationdate` ,
`modifiedby` = $uid, `modificationdate` = now()
where `id` = $editbtnid

";
  mysqli_query($con,$sqlinsert);
    }
	  echo json_encode($result);
     mysqli_close($con);
?>