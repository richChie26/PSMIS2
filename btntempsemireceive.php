<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$editbtnid = $_GET['editbtnid'];
$txtdesc = $_GET['txtdesc'];
$txtserial = $_GET['txtserial'];
$txtamount = $_GET['txtamount'];
$dtpdateaquired = $_GET['dtpdateaquired'];
$txtddate = $_GET['txtddate'];
$txtpodate = $_GET['txtpodate'];

if($txtpodate > $txtddate ){
	 $result[] = array("msg" => " PO should not be ahead of the Delivery Date!" , "tag" =>"1");	




  echo json_encode($result);
}
	else{
 $sqlinsert = "insert into  `t_tempsemipee` (`itemid`, `amount`, `description`, `serial`, `createdby`, `tag`,dateaquire )values($editbtnid , $txtamount, '$txtdesc', '$txtserial', $uid, 2,'$dtpdateaquired')";


mysqli_query($con,$sqlinsert);
   $result[] = array("msg" => "Semi Expendable Successfully added!" , "tag" =>"2");	

  // $result[] = array("msg" =>  $sqlinsert, "tag" =>"2");	


  echo json_encode($result);
     mysqli_close($con);
}
    ?>