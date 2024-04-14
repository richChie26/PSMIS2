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
for ($i=1; $i <= $num2 ; $i++) { 
	# code...
$typeofassets  = $a[$mynum1];
$accounttitle = $a[$mynum2];
$Acronyms = $a[$mynum3];
$AccAUCScode = $a[$mynum4];
$SubMajorAccountGroup =$a[$mynum5];
$GLAccount =$a[$mynum6];

$sqlsearch = " SELECT id  FROM `m_assets` WHERE `typeofassets`  = '$typeofassets'  ";	
$qrysearch = mysqli_query($con,$sqlsearch);
// echo $sqlsearch;
$arr = mysqli_fetch_array($qrysearch);
$id = $arr['id'];

$sqll = " select accounttitle from m_accouttitle where accounttitle = '$accounttitle' ";
$qrysqll = mysqli_query($con,$sqll);


$sql = "insert into `m_accouttitle` 
(`typeofasset`,
`accounttitle`, 
`Acronyms`, `AccAUCScode`, `SubMajorAccountGroup`, `GLAccount`,`isactive`, `createdby`, `creationdate`
)

values(
$id, '$accounttitle',
'$Acronyms',
'$AccAUCScode',
'$SubMajorAccountGroup',
'$GLAccount',1,$uid,now() 
)
";
if(mysqli_num_rows($qrysqll) == 0 ){
	mysqli_query($con,$sql);	
}

$mynum1 = $mynum1 + 6;
$mynum2 = $mynum2 + 6;
$mynum3 = $mynum3 + 6;
$mynum4 = $mynum4 + 6;
$mynum5 = $mynum5 + 6;
$mynum6 = $mynum6 + 6;
}
// echo array_chunk($chie0,2);
echo 1;
?>