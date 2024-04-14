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
$mynum7 = 4;
$mynum8 = 5;
// echo $a[$mynum];
// echo $num2 . '|'. $num;
for ($i=1; $i <= $num2 ; $i++) { 
	# code...


$fname = $num1;
$mname = $num2;
$lname = $num3;
$contact = $num4;
$resposibility = $num5;
$division = $num6;
$section = $num7;
$position = $num8;

$sql= "SELECT `fname` FROM `u_profile` WHERE `isactive` = 1 and concat(`fname`, `mname`, `lname`) = concat('$fname','$mname','$lname')";

$qry = mysqli_query($con,$sql);

if($mysqli_num_rows($qry) < 1 ){
$sqlr = "SELECT `id` FROM `a_responsibilitycenter` WHERE `isactive` = 1 and `ResponsibilityCenter` = '$resposibility'";
$rqry = mysqli_query($con,$rqry);
$arr = mysqli_fetch_array($rqry);
$myrid = $arr['id'];
// $sqldiv = "SELECT id FROM `a_division` WHERE isactive =1 and `division` = '$division'";
// $qrydiv = mysqli_query($con,$sqldiv);
// $arrdiv = mysqli_fetch_array($qrydiv);
// $mydiv = $arrdiv['id'];
$sqlsec = "SELECT id FROM `a_section` WHERE `isactive` = 1 and `section` ='$section'";
$qrysec = mysqli_query($con,$sqlsec);
$arrsec = mysqli_fetch_array($qrysec);
$mysec = $arrsec['id'];
// $sqlpos = "SELECT id  FROM `a_position` WHERE `isactive` = 1 and `position` = '$position'";
// $qrypos = mysqli_query($con,$sqlpos);
// $arrpos = mysqli_fetch_array($qrypos);
// $mypos = $arrpos['id'];
$sqlinsert = "insert INTO `u_profile` (`fname`, `mname`, `lname`, `Position`, `ResponsibilityCenter`, `Section`, `contactNo`,  `isactive`, `createdby`, `creationdate`, `divsion`)
VALUES('$fname', '$mname', '$lname', '$position', $myrid, $mysec, '$contact', 1, $uid, $uid, '$division')";
mysqli_query($con,$sqlinsert);
}
$mynum1 = $mynum1 + 6;
$mynum2 = $mynum2 + 6;
$mynum3 = $mynum3 + 6;
$mynum4 = $mynum4 + 6;
$mynum5 = $mynum5 + 6;
$mynum6 = $mynum6 + 6;
$mynum7 = $mynum7 + 6;
$mynum8 = $mynum8 + 6;



}
// echo array_chunk($chie0,2);
echo 1;
?>