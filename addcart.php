<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    
    $editbtnid = $_GET['editbtnid'];
	$txtquantity  = $_GET['txtquantity'];
	$txtamount = $_GET['txtamount'];
    $txtsource = $_GET['txtsource'];
  
 $sqlq = "SELECT id  FROM `m_fundcluster` WHERE isactive = 1 and `Fundcategory` = '$txtsource'";
 $qryq = mysqli_query($con, $sqlq );

 $id = 0;
while($row = mysqli_fetch_array($qryq)){
	$id = $row['id'];
}


 $sql = "SELECT 

a.`id`,accounttitle, stockno,itemname ,description, `qty`,Units,amount, (`amount`* qty) totalAmount

FROM `t_tempreceived` a 
left join (SELECT x.id,z.accounttitle, `stockno`,item itemname,`description`,za.units FROM `m_materials` x 
left join m_itemname y on x.`item` = y.id and y.isactive  = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.units = za.id and za.isactive = 1 
where x.isactive = 1 ) b on a.itemid = b.id
where a.createdby = $uid  and a.itemid = $editbtnid
";


// echo $sql;
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) >0 ){
		while ($row = mysqli_fetch_array($qry )) {
			# code...

			$myid = $row['id'];
			$sqlupdate = "update t_tempreceived set qty = qty + $txtquantity 
			where id = $myid ";

			mysqli_query($con,$sqlupdate);

		}
		
	}else{
		$sqlinsert = "insert into  `t_tempreceived` (`itemid`, `qty`, `amount`, `createdby` ,fundSource)
value($editbtnid, $txtquantity , $txtamount, $uid, $id  )";	

		mysqli_query($con,$sqlinsert);


	}
?>