<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

 
$mnutitle = $_GET['mnutitle'];
$txtitem = preg_replace("/'/", "",$_GET['txtitem']);
// $txtstockno = $_GET['txtstockno'];
$txtdescription =preg_replace("/'/", "",$_GET['txtdescription']);
$mnuunits = $_GET['mnuunits'];
$txtreorder = $_GET['txtreorder'];

$sqlstockno = "Select  
case when length(cnn) = 1 then
  concat(acro,'-','000',cnn)
     when length(cnn) = 2 then
  concat(acro,'-','00',cnn)
     when length(cnn) = 3 then
  concat(acro,'-','0',cnn)
else

  concat(acro,'-',cnn)
end code
from

(SELECT (count(a.id) + 1 ) cnn  ,b.Acronyms   acro  FROM `m_materials` a 
left join m_accouttitle b on a.`titleid` = b.id and b.isactive = 1 
where a.isactive = 1 
and b.id = $mnutitle )  x ";

$qrystrockno = mysqli_query($con,$sqlstockno);
$arrstockno = mysqli_fetch_array($qrystrockno);
$txtstockno = $arrstockno['code']; 
    $sql = "SELECT `id` FROM `m_materials` WHERE `isactive` = 1  and 
( `description` = '$txtdescription') ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Duplicate Materials and Supply description or Stock Number already exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Success Materials and Supply is Successefully Saved!" , "tag" =>"2");

            $sqlinsert = "insert into `m_materials`(`titleid`, `item`, `stockno`, `description`, `units`, `isactive`, `createdby`, `creationdate`,reorderpoint )
values
($mnutitle, '$txtitem', '$txtstockno', '$txtdescription', $mnuunits, 1, $uid, now(),$txtreorder )";
  mysqli_query($con,$sqlinsert);
    }
echo json_encode($result);
mysqli_close($con);

 
?>