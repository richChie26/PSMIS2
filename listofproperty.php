<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $editbtnid = $_GET['editbtnid'];

    	$sql = "SELECT `id`, `propertyno` FROM `t_equipmentdeliverydetails` WHERE isactive = 1 and `itemid` = $editbtnid";

    	$qry = mysqli_query($con,$sql);

    	while ($row= mysqli_fetch_array($qry)) {
    		
    		echo '<option value = "'.$row['id'].'" >'. $row['propertyno'].'</option>'; 
    	}

 ?>