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

	$sqlchk = "select menuid from a_menusetup where isactive = 1 
	and menuid = $chie and groupid = $cmbGroup";
	$qrychk = mysqli_query($con,$sqlchk);
	if(mysqli_num_rows($qrychk) < 1){	
		$sqllll = "
		insert into `a_menusetup` (`menuid`, `groupid`, `isactive`, `createdby`, `creationdate`)
		value($chie,  $cmbGroup, 1, $uid, now())
		";
		mysqli_query($con,$sqllll);  
		}
	
}



?>
   	