<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$val  = $_GET['val'];
// $chars = str_split();
 $cmbGroup = $_GET['cmbGroup'];
// echo $val;

foreach ($val as $chie ){
	# code...

	$sqlchk = "SELECT id FROM `a_groupsetup` WHERE isactive =1 and `userid` = $chie";
	$qrychk = mysqli_query($con,$sqlchk);
	if(mysqli_num_rows($qrychk) < 1){	
		$sqllll = "
		Insert into `a_groupsetup` ( `groupid`, `userid`,`isactive`, `createdby`, `creationdate`)
values
 ($cmbGroup, $chie,1, $uid, now())
		";
		mysqli_query($con,$sqllll);  
		}
	
}



?>
   	