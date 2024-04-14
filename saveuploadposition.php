<?php

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$chie0 = $_GET['chie0'];

$col1 = "";

$num = 0;
$a= array();
foreach ($chie0 as  $value) {
 	# code...

	$num = $num +1;
 	array_push($a,$value);
 	// echo $value;
 } 
$num2 = $num / 6 ;
$mynum1 = 0;
$mynum2 = 1;
$mynum3 = 2;
$mynum4 = 3;
$mynum5 = 4;
$mynum6 = 5;
// echo $a[$mynum];
// echo $num2 . '|'. $num;
$sql = "";
for ($i=1; $i <= $num ; $i++) { 
	# code...
$position  = $a[$mynum1];
$sql = "insert into  `a_position`(`position`, `isactive`, `createdby`, `creationdate`)
values('$position', 1, $uid, now())";

$qrysqll1 = "select isactive from a_position where isactive = 1 and  position = '$position'";
$qrysqll = mysqli_query($con,$qrysqll1);
if(mysqli_num_rows($qrysqll) == 0 ){
	mysqli_query($con,$sql);	
}

// mysqli_query($con,$sql);
 $mynum1 = $mynum1 + 1;

//   $sql += $sql;
}
//  echo array_chunk($chie0,2);
echo 1;
?>