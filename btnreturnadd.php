<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$txtpropertyreturn = $_GET['txtpropertyreturn'];

$acctperson =$_GET['acctperson'];
$lblpar = $_GET['lblpar'];
$dtpdateret = $_GET['dtpdateret'];
$txtmyremarks = $_GET['txtmyremarks'];
$optsets = $_GET['optsets'];
$selcondition = $_GET['selcondition'];

$sqlsearch = "select propertyno from temptreturn where propertyno = '$txtpropertyreturn'";
$qry = mysqli_query($con,$sqlsearch);

if(mysqli_num_rows($qry)){
	echo 2;
}else{
$sql = "insert into `temptreturn`(`parno`, `propertyno`, `remarks`, `conditions`, `tag`,datereturn,createdby,acctperson)
values('$lblpar', '$txtpropertyreturn ', '$txtmyremarks', '$selcondition', $optsets,'$dtpdateret',$uid,'$acctperson')";
mysqli_query($con,$sql);
echo 1;

}

    ?>