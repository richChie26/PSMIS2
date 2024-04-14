<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"];
    $txtproperty = $_GET['txtproperty'];
    $propertyid = $_GET['propertyid'];
    $txtrecidforis = $_GET['txtrecidforis'];
    $dtpissued = $_GET['dtpissued'];

$sqlsearch = "select propertyno from t_temppar where propertyno = '$txtproperty'";


$qry = mysqli_query($con,$sqlsearch);

if(mysqli_num_rows($qry) > 0 ){
	$result[] = array("msg" => "Property, Plant and Equipment already exist!" , "tag" =>"1");
}else{
    $sql = "insert into  `t_temppar` (`itemid`, `qty`, `propertyno`, `createdby`,receiverid,daterec)
values
 ($propertyid, 1, '$txtproperty', $uid,$txtrecidforis,'$dtpissued')
                          ";

             mysqli_query($con,$sql);


$result[] = array("msg" => "Property, Plant and Equipment Successfully Added!" , "tag" =>"2");
}
  echo json_encode($result);
     mysqli_close($con);
?>