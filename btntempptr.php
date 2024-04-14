<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;



$propertyid = $_GET['propertyid'];
$txtsimeitem = $_GET['txtsimeitem'];
$selcondition = $_GET['selcondition'];
$txtreason = $_GET['txtreason'];
$tag = $_GET['tag'];
$sql = "SELECT id  FROM `t_tempptr` WHERE `itemid` = $propertyid ";

$qry = mysqli_query($con,$sql);
if(mysqli_num_rows($qry) > 0 ){
 $result[] = array("msg" => "PROPERTY, PLANT AND EQUIPMENT Already exist" , "tag" =>"1");	
}else{

	$sqlinsert = "insert into  `t_tempptr` (`itemid`, `propertyno`, `reasonfortransfer`, `tag`, `condition`, `createdby`)
values($propertyid, '$txtsimeitem', '$txtreason', $tag, '$selcondition', $uid)";
  mysqli_query($con,$sqlinsert);
  $result[] = array("msg" => "PROPERTY, PLANT AND EQUIPMENT Successfully added!" , "tag" =>"2");	
}






  echo json_encode($result);
     mysqli_close($con);
?>