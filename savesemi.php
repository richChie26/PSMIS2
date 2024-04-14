<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

 
$mnutitle = $_GET['mnutitle'];
$txtitem = preg_replace("/'/", "",$_GET['txtartivle']);
// $txtstockno = $_GET['txtstockno'];
$mnuunits = $_GET['mnuunits'];
$txtyearoflife = $_GET['txtyearoflife'];
$sqltit = "SELECT b.typeofassets  FROM `m_accouttitle` a 
left join m_assets b on a.`typeofasset` = b.id and b.isactive =1 
where a.isactive = 1 and a.id = $mnutitle";

$fetqry = mysqli_query($con,$sqltit);
$fetching = mysqli_fetch_array($fetqry);
$typeofassets = $fetching['typeofassets'];

$sql = "SELECT `item` FROM `m_equipent` WHERE  isactive = 1 and `item` = '$txtitem' and accounttitle = $mnutitle";

	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Duplicate ".$typeofassets." Already Exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" =>  $typeofassets ." is Successefully Saved!" , "tag" =>"2");

$sqlcode = "Select  
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

(SELECT (count(a.id) + 1 ) cnn  ,b.Acronyms   acro  FROM `m_equipent` a 
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
where a.isactive = 1 
and b.id = $mnutitle )  x";
$qrycode = mysqli_query($con,$sqlcode);

$arrcode = mysqli_fetch_array($qrycode);
$code = $arrcode['code'];
            $sqlinsert = "insert into  `m_equipent`( `accounttitle`, `item`,  `yearoflife`, `isactive`, `createdby`, `creationdate`,unitofmeasurement,itemno)values
( $mnutitle, '$txtitem ', $txtyearoflife, 1, $uid, now() , $mnuunits ,'$code')";
  mysqli_query($con,$sqlinsert);
    }
echo json_encode($result);
mysqli_close($con);

 
?>