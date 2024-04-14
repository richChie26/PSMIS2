

<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;



$sql = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    $Responsibility = $arr['Responsibility'];
 
$txtsupplier = $_GET["txtsupplier"];
$txtPO = $_GET["txtPO"];
$txtddate = $_GET["txtddate"];
$txtpodate = $_GET["txtpodate"];
$txtreceiptn = $_GET["txtreceiptn"];
$txtsource = $_GET["txtsource"];
$txtarticle = $_GET["txtarticle"];
$txtdesc = $_GET["txtdesc"];
$txtengine = $_GET["txtengine"];
$txtchasis = $_GET["txtchasis"];
$dtpdateaquired = $_GET["dtpdateaquired"];
$txtamount = $_GET["txtamount"];


$sqlpropertycode = "Select  

concat(
    substring(now(),1,4),'-',	
     (SELECT 
SubMajorAccountGroup

FROM `m_equipent` a
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
where a.isactive = 1 and  a.id = $txtarticle ),'-',
    
 (SELECT 
GLAccount

FROM `m_equipent` a
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
where a.isactive = 1 and  a.id = $txtarticle ),'-',

(SELECT case when length(count(id) + 1) = 1 then 
		concat( '000',(count(id) + 1))
        when length(count(id) + 1) = 2 then 
		concat( '00',(count(id) + 1))
when length(count(id) + 1) = 3 then 
		concat( '0',(count(id) + 1))
else
	concat((count(id) + 1))

end code FROM `t_equipmentdeliverydetails` WHERE itemid = $txtarticle and isactive = 1 and `ResponsibilityCenter` = $Responsibility  and substring(`creationdate`,1,4) = substring(now(),1,4)) 

,'-',(SELECT 
`operationUnitCode`

FROM `a_responsibilitycenter` WHERE `id` = $Responsibility
) ) Property
 
";

$sqlcode = "SELECT count(`id`) + 1 cnn  FROM `t_equipmentdeliveryheader` ";

$qrydode = mysqli_query($con,$sqlcode);
$delcode = mysqli_fetch_array($qrydode);
$qcode = $delcode['cnn'];

$qryprocode = mysqli_query($con,$sqlpropertycode); 
$arrprop  = mysqli_fetch_array($qryprocode);
$code = $arrprop['Property'];

$sqlinsert = "insert into `t_equipmentdeliverydetails` 
(`deliverycode`,`ResponsibilityCenter`,  `itemid`, `propertyno`, `dateaquired`, `description`, `Serial`, `amount`, `chasisnumber`, `isactive`, `createdby`, `creationdate`)
values
('$qcode',$Responsibility , $txtarticle, '$code', '$dtpdateaquired', '$txtreceiptn', '$txtengine', $txtamount, '$txtchasis', 1, $uid , now())
";
mysqli_query($con,$sqlinsert);

$sqlheader = "insert into  `t_equipmentdeliveryheader` 
(`deliverycode`, `sourceoffund`, `Supplierid`, `PODate`, `PONumber`, `deliverydate`, `deliveryNumber`, `isactive`, `createdby`, `creationdate`)
values
($qcode, $txtsource, $txtsupplier, '$txtpodate', '$txtPO', '$txtddate', '$txtreceiptn', 1, $uid, now())";
mysqli_query($con,$sqlheader);

// echo $sqlheader;
?>

