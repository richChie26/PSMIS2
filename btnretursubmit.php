<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
$uid = $_SESSION["uid"] ;
$dtpdateret = $_GET['dtpdateret'];
$sql = "Select a.id, a.parno, a.`propertyno`, `remarks`, `conditions`, 
case when a.`tag` = 3 then 
    '0'
else 2
end tag
 ,datereturn,cname,office,receivedby
from `temptreturn` a
left join t_pardetails ff on a.`parno` =  ff.parno  and a.propertyno = ff.propertyno
left join t_par xx  on a.parno =xx.parno and case when a.`tag` = 3 then 
    '0'
else 2
end = xx.tag 

left join (SELECT userid
,
concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname,office

FROM `a_user`  x
left join u_profile y on x.`profileid`=  y.`profileid` and y.isactive =1 
)   b on xx.`receivedby` = b.userid 

 where a.createdby = $uid
 order by  datereturn Asc 
 ";
$qry = mysqli_query($con,$sql);
$qry2 = mysqli_query($con,$sql);
$qry3 = mysqli_query($con,$sql);
// echo $sql;
while ($row = mysqli_fetch_array($qry2)) {

// echo $sql;

$newdate = $row['datereturn'];
$sqlcode = "

SELECT 
 concat(substring(ifnull(`creationdate`,now()),1,4),'-',
         substring(ifnull(`creationdate`,now()),6,2),'-',
         case when length(count(id) + 1 ) = 1 then 
          concat('000',count(id) + 1)
        when length(count(id) + 1 ) = 2 then 
          concat('00',count(id) + 1)
         when length(count(id) + 1 ) = 3 then 
          concat('0',count(id) + 1)
         else
           count(id) + 1
        end 
        ) parno
FROM `t_returns` where substring(ifnull(`creationdate`,now()),1,4) = substring(now(),1,4)";
$qrycode = mysqli_query($con,$sqlcode);

$arrcode = mysqli_fetch_array($qrycode);
$arrcodel = mysqli_fetch_array($qry);
$parnos = $arrcodel['parno'];
$newtag = $arrcodel['tag'];
$receivedby = $arrcodel['receivedby'];
$code = $arrcode['parno'];

$sqlheader = "insert into  `t_returns`(`rcode`, `datereturn`, `isactive`, `createdby`, 
`creationdate`,returnby, `lastpar`, `tag`)
values('$code', '$newdate', 1, $uid, now(),$receivedby,'$parnos',$newtag)";
// echo $sqlheader;
mysqli_query($con,$sqlheader);

$id = $row['id'];
$parno = $row['parno'];
$propertyno = $row['propertyno'];
$remarks = $row['remarks'];
$tag = $row['tag'];
$conditions = $row['conditions'];
	$sqlinsert = "insert into `t_returndetails`(`PARNO`, `propertyno`, `condition`, `remarks`,rcode,tag)
	values
		('$parno', '$propertyno', '$conditions', '$remarks','$code',$tag)

	";
// echo $sqlinsert;
	mysqli_query($con,$sqlinsert);
	$sqlupdate = "update  `t_equipmentdeliverydetails` set `Status` = '$conditions' WHERE `propertyno` ='$propertyno'";
	$sqldel = "delete from `temptreturn` where id =$id ";
 mysqli_query($con,$sqlupdate);
 	mysqli_query($con,$sqldel);
}



?>