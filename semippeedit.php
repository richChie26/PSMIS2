
<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    
		$mahalid = $_GET['mahalid'];
		$txtartivle = $_GET['txtartivle'];
		$mnuunits = $_GET['mnuunits'];
		$txtyearoflife = $_GET['txtyearoflife'];
		$yourarr = $_GET['yourarr'];

		$sql = "SELECT 
`accounttitle`
FROM `m_equipent` WHERE `accounttitle`  = $yourarr
 and `item`  = '$txtartivle'
 and id != $mahalid
 and isactive = 1 "; 

		$qry = mysqli_query($con,$sql);

if(mysqli_num_rows($qry)){
	$result[] = array("msg" => "Duplicate Item Name !" , "tag" =>"1");
}else{
$sqlupdate = "update  `m_equipent` 
set 
		`accounttitle` = $yourarr , 
		`item` = '$txtartivle', 
		`yearoflife` = $txtyearoflife, 
		`unitofmeasurement` = $mnuunits , 
		`previouslymodifiedby` = `modifiedby`, 
		`previousmodificationdate` = `moficationdate`,

		`modifiedby` = $uid , 
		`moficationdate` = now()
WHERE id = $mahalid ";

mysqli_query($con,$sqlupdate);
	$result[] = array("msg" => "Item Successfully Updated" , "tag" =>"2");
}
echo json_encode($result);
mysqli_close($con);

?>