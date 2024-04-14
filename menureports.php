<?php
	include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$sql = "SELECT  ams.id,
`menucode`, `menuname`, `link`
FROM `a_menusetup`  ams
left join a_menu am on ams.`menuid` = am.id and am.isactive = 1 
where ams.`isactive` = 1 and 
tag ='report' and 
ams.`groupid` in (select distinct groupid from a_groupsetup a where a.isactive = 1 and a.userid = $uid  )

order by seq ASC

";

	$qry = mysqli_query($con,$sql);

	while($rows = mysqli_fetch_array($qry)){

		$menucode = $rows['menucode'];
	    $menuname = $rows['menuname'];
	    $link = $rows['link'];
	 
	 $result[] = array("menucode" => $menucode,
                    "menuname" => $menuname,
                    "link" => $link);
   

 
	}
 echo json_encode($result);
     mysqli_close($con);
 ?>