<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$fundcode = preg_replace("/'/", "",$_GET['fundcode']);
 $fsource = preg_replace("/'/", "",$_GET['fsource']);
 $txtauthorization = preg_replace("/'/", "",$_GET['txtauthorization']);
 $fcategory = preg_replace("/'/", "",$_GET['fcategory']);
    $editbtnid = $_GET['editbtnid'];
    $chkactive = $_GET['chkactive'];
    $sql = "SELECT `id`, `Fundcategory` FROM `m_fundcluster` WHERE isactive =1 and  Fundcategory = '$fcategory' and id != $editbtnid ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist." , "tag" =>"1");
	}else{
             $result[] = array("msg" => "Successefully updated." , "tag" =>"2");

            $sqlinsert = "update  `m_fundcluster` 
set 


`code` ='$fundcode', `FinancingSource` = '$fsource',
 `Authorization` ='$txtauthorization',
  `Fundcategory` = '$fcategory',
`previouslymodifiedby` = `modifiedby`,
activation = $chkactive,
 `previousmodificationdate` = `modificationdate`,
`modifiedby` = $uid , `modificationdate` = now()
where `id` =  $editbtnid
";
  mysqli_query($con,$sqlinsert);
// echo $sqlinsert;
    }
    // $result[] = array("msg" => $sqlinsert , "tag" =>"2");

echo json_encode($result);
mysqli_close($con);
?>