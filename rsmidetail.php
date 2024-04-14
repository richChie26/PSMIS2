<?php
	include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

// $mydata = $_GET['mydata'];
    // $mydata = "RIS-0001";
 
$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename,a.position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['rid'];
$completename = $aarres['completename'];
$position = $aarres['position'];

$sqlrsm = "

select   
concat(
substring(now(),1,4),'-',substring(now(),6,2) ,
 '-', 
case when length(cnn) =1 then 
    concat('000' ,cnn)
when length(cnn) =2 then 
    concat('00' ,cnn)
when length(cnn) =3 then 
    concat('0' ,cnn)
else 
    cnn
    end 
    ) mycode
from 
(SELECT count(id) + 1 cnn,`creationdate`  FROM `t_rsmicode` 
where 
substring(convert(`creationdate`,date),1,7)  = 
substring(convert(now(),date),1,7) 
 
) 
a

";
$qryrsm = mysqli_query($con,$sqlrsm);
$arrcode = mysqli_fetch_array($qryrsm);
$code = $arrcode['mycode'];

$sqlupdate = "update  `t_rsmi`

set 
`newrsmicode` = '$code', 
`submitedby` = $uid, 
`datesubmited` = now(),
`previouslymodifiedby` = `modifiedby`, 
`previousmodificationdate` = `modificationdate`,
`modifiedby` = $uid,
`modificationdate` = now()


WHERE newrsmicode = ''";

mysqli_query($con,$sqlupdate);

$sqlinsert = "insert into  `t_rsmicode` (`code`, `creationdate`)
values('$code', now())
                           ";
mysqli_query($con,$sqlinsert);
?>