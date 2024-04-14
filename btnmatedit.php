<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $mnutitle = $_GET['mnutitle'];
    $txtitem = $_GET['txtitem'];
    $txtreorder = $_GET['txtreorder'];
    $txtdescription = $_GET['txtdescription'];
    $mnuunits = $_GET['mnuunits'];
    $editbtnid = $_GET['editbtnid'];

    $sql = "SELECT `id` FROM `m_materials` WHERE isactive =1 
and `description` = '$txtdescription'  and id != $editbtnid ";
	
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
			$result[] = array("msg" => "Duplicate Materials and Supply Already Exist!" , "tag" =>"1");
	}else{
            $result[] = array("msg" => "Success Materials and Supply is Successefully Saved!" , "tag" =>"2");

            $sqlinsert = "update `m_materials`  set 

`titleid`= $mnutitle,
 `item` ='$txtitem',
reorderpoint = $txtreorder,
  `description` = '$txtdescription', 
  `units` = $mnuunits,
`previouslymodifiedby` = `modifiedby`,
`previousmodificationdate` = `modificationdate` ,
`modifiedby` = $uid, `modificationdate` = now()
where `id` = $editbtnid

";
  mysqli_query($con,$sqlinsert);
    }

// echo $sqlinsert;
	  echo json_encode($result);
     mysqli_close($con);
?>