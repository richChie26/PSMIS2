<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"];
    $txtproperty = $_GET['txtproperty'];
    $propertyid = $_GET['propertyid'];


$sqlsearch = "select propertyno from t_temppar where propertyno = '$txtproperty'";


$qry = mysqli_query($con,$sqlsearch);

if(mysqli_num_rows($qry) > 0 ){
  $result[] = array("msg" => "Duplicate PROPERTY, PLANT AND EQUIPMENT Already Exist!" , "tag" =>"1");
}else{
    $sql = "insert into  `t_temppar` (`itemid`, `qty`, `propertyno`, `createdby`,tag)
values
 ($propertyid, 1, '$txtproperty', $uid,2)
                          ";

             mysqli_query($con,$sql);


$result[] = array("msg" => "PROPERTY, PLANT AND EQUIPMENT Successfully Added!" , "tag" =>"2");
}
  echo json_encode($result);
     mysqli_close($con);
?>