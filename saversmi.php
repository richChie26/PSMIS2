<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$sqlres = "SELECT 
(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter)
rid ,
(select r.`ResponsibilityCenter` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
$qryres = mysqli_query($con,$sqlres);
$arr = mysqli_fetch_array($qryres);
$Responsibility  = $arr['Responsibility'];
 $rid  = $arr['rid'];
$val = $_GET['val'];

$sql = "
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
(SELECT count(id) + 1 cnn,`creationdate`  FROM `t_rsmi` 
where 
substring(convert(`creationdate`,date),1,7)  = 
substring(convert(now(),date),1,7)

) 
a
";
$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);
$mycode = $arr['mycode'];

$sqlinserts = "insert into `t_rsmi`(`rsmicode`, `rsmiDate`, `ResponsibilityCenter`, `isactive`, `createdby`, `creationdate`)values
('$mycode', now(), $rid , 1, $uid, now())";
mysqli_query($con,$sqlinserts);
foreach ($val as $chie ){


$sqlkk = "insert into  `t_rsmidetails`(`codes`, `rsiid`)values
('$mycode', $chie)";
mysqli_query($con,$sqlkk);

$sqlkkkk = "update  `t_requesitionhead`
set `status` ='Submited'
, `previouslymodifiedby` = `modifiedby`
, `previousmodificationdate` = `modificationdate`
,`modifiedby` = $uid, 
`modificationdate` =  now()
WHERE id =$chie  ";
mysqli_query($con,$sqlkkkk);
}



?>