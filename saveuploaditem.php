<?php

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$chie0 = $_POST['chie0'];

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
// units
$unit = $a[$mynum5];

$sqlunits = "SELECT `id`  FROM `m_units` WHERE isactive = 1  and `units` = '$unit'";
$qryunit = mysqli_query($con,$sqlunits);
$unitid = 0;
if(mysqli_num_rows($qryunit) > 0 ){
			$arr = mysqli_fetch_array($qryunit);
		$unitid = $arr['id']; 
}else{

	$sqlinsertunit = "Insert into `m_units` 
(`units`, `isactive`, `createdby`, `creationdate`)
values
('$unit', 1, $uid, now())
";
mysqli_query($con,$sqlinsertunit);
$sqlunitss = "SELECT `id`  FROM `m_units` WHERE isactive = 1  and `units` = '$unit'";
$qryunits = mysqli_query($con,$sqlunitss);

	$arrs = mysqli_fetch_array($qryunits);
		$unitid = $arrs['id']; 
}

// Account Title
$Accounttitle = $a[$mynum1];
$sqlsearchAccountTitle = "SELECT id,typeofasset FROM `m_accouttitle` WHERE `accounttitle` = '$Accounttitle'";
$qrysearchAccountTitle = mysqli_query($con,$sqlsearchAccountTitle);
$accounttitleid = 0;

$arr = mysqli_fetch_array($qrysearchAccountTitle);
		$accounttitleid = $arr['id']; 
			$typeofasset = $arr['typeofasset'];
if(mysqli_num_rows($qrysearchAccountTitle) > 0 ){
	$arr = mysqli_fetch_array($qrysearchAccountTitle);
		$accounttitleid = $arr['id']; 
$typeofasset = $arr['typeofasset'];
}else{
	$sqlinsertAccountTitle = "insert into  `m_accouttitle`(`accounttitle`, `isactive`, `createdby`, `creationdate` )
							VALUES
							('$Accounttitle', 1, $uid, now())";
	mysqli_query($con,$sqlinsertAccountTitle);
$sqlsearchAccountTitles = "SELECT id FROM `m_accouttitle` WHERE `accounttitle` = '$Accounttitle'";
$qrysearchAccountTitles = mysqli_query($con,$sqlsearchAccountTitles);
$arrs = mysqli_fetch_array($qrysearchAccountTitles);
$accounttitleid = $arrs['id']; 
}


$itemName = $a[$mynum2];
$reorder = $a[$mynum6];
$stocknos = $a[$mynum3];
$Description = $a[$mynum4];
if($typeofasset == 1){
	$sqlitemname = "SELECT `id`,`itemname` FROM `m_itemname` WHERE `isactive` = 1 and `itemname` =  '$itemName' ";
	$qyryitemname = mysqli_query($con,$sqlitemname);

	$itemid = 0 ;
	if(mysqli_num_rows($qyryitemname) > 0 ){
		$myarr = mysqli_fetch_array($qyryitemname);
		$itemid = $myarr['id'];
	}else{
		$sqlInsertItem = "insert into  `m_itemname` (`accounttitle`, `itemname`, `isactive`, `createdby`, `creationdate`)
VALUES($accounttitleid, '$itemName', 1, $uid, now())";
	mysqli_query($con,$sqlInsertItem);

	$sqlitemnames = "SELECT `id`,`itemname` FROM `m_itemname` WHERE `isactive` = 1 and `itemname` =  '$itemName' ";
	$qyryitemnames = mysqli_query($con,$sqlitemnames);
	$myarrs = mysqli_fetch_array($qyryitemnames);
		$itemid = $myarrs['id'];
	}

	$sqlinsetmyMats = "insert INTO `m_materials` (`titleid`, `item`, `stockno`, `description`, `units`, `reorderpoint`, `isactive`, `createdby`, `creationdate`)VALUES
($accounttitleid, '$itemName', '$stocknos', '$Description', $unitid, $reorder, 1, $uid, now())";
mysqli_query($con,$sqlinsetmyMats);

}else{


$sqlitemname = "SELECT `id`,`itemname` FROM `m_itemname` WHERE `isactive` = 1 and `itemname` =  '$itemName' ";
	$qyryitemname = mysqli_query($con,$sqlitemname);

	$itemid = 0 ;
	if(mysqli_num_rows($qyryitemname) > 0 ){
		$myarr = mysqli_fetch_array($qyryitemname);
		$itemid = $myarr['id'];
	}else{
		$sqlInsertItem = "insert into  `m_itemname` (`accounttitle`, `itemname`, `isactive`, `createdby`, `creationdate`)
VALUES($accounttitleid, '$itemName', 1, $uid, now())";
	mysqli_query($con,$sqlInsertItem);

	$sqlitemnames = "SELECT `id`,`itemname` FROM `m_itemname` WHERE `isactive` = 1 and `itemname` =  '$itemName' ";
	$qyryitemnames = mysqli_query($con,$sqlitemnames);
	$myarrs = mysqli_fetch_array($qyryitemnames);
		$itemid = $myarrs['id'];

		$sqlinserequipment = "INSERT into  `m_equipent` (`itemno`, `accounttitle`, `item`, `unitofmeasurement`, `isactive`, `createdby`, `creationdate`)
VALUES 
('$stocknos', $accounttitleid, '$itemName', $unitid, 1, $uid, now())"
mysqli_query($con,$sqlinserequipment);
	}


}




				$mynum1 = $mynum1 + 6;
				$mynum2 = $mynum2 + 6;
				$mynum3 = $mynum3 + 6;
				$mynum4 = $mynum4 + 6;
				$mynum5 = $mynum5 + 6;
				$mynum6 = $mynum6 + 6;

}

echo 1;

?>