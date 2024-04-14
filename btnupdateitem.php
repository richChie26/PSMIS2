<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $txtitemname = preg_replace("/'/", "",$_GET['txtitemname']);
    $editbtnid = $_GET['editbtnid'];
    $seltitle = $_GET['seltitle'];
    $sql = "SELECT `id`, `itemname` FROM `m_itemname` WHERE isactive =1 and  itemname = '$txtitemname' and id != $editbtnid ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Already exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Successefully updated!" , "tag" =>"2");

            $sqlinsert = "update  `m_itemname` 
set accounttitle = $seltitle ,
`itemname` = '$txtitemname',
`previouslymodifiedby` = `modifiedby`
, `previousmodificationdate` = `modificationdate`,
`modifiedby` = $uid , `modificationdate` = now()
where `id` =  $editbtnid
";
  mysqli_query($con,$sqlinsert);

    }


echo json_encode($result);
mysqli_close($con);
?>