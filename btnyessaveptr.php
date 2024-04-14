<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$txtothers = $_GET['txtothers'];
$seltypeoftransfer = $_GET['seltypeoftransfer'];
$resid = $_GET['resid'];
$txthiddenid = $_GET['txthiddenid'];
$dtpissued = $_GET['dtpissued'];
$tag = $_GET['tag'];
$trans = "";

if($seltypeoftransfer =="OTHERS"){
$trans = $txtothers; 
}else{
	$trans = $seltypeoftransfer;
}

$sqlrid = "SELECT 

(select r.id from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
userid,
username,
concat(lname, ', ', fname,' ', substring(mname,1,1),'.') Completename ,
contactNo ,
case when ifnull(userpic,'') = '' then 'img/userpic.png' else userpic end pic

FROM a_user au 
left join u_profile up on au.profileid = up.profileid and up.isactive = 1 
where au.isactive = 1 and userid = $uid ";


$qryresid = mysqli_query($con,$sqlrid);
$arrid = mysqli_fetch_array($qryresid);
$Responsibility = $arrid['Responsibility'];
$sql = "SELECT * FROM t_tempptr WHERE createdby = $uid and tag = $tag";
$qry = mysqli_query($con,$sql);
if(mysqli_num_rows($qry) > 0){
		$sqlcode = "SELECT 
 concat(substring(ifnull(creationdate,now()),1,4),'-',
 
 substring(ifnull(creationdate,now()),6,2),'-',
 case when length(count(id) + 1) = 1 then 
		concat('000',(count(id) + 1))
        
       	when length(count(id) + 1) = 2 then 
		concat('00',(count(id) + 1))
        when length(count(id) + 1) = 3 then 
		concat('0',(count(id) + 1))
        else
         
		(count(id) + 1)
	end ) code
 

FROM t_ptrheader WHERE ifnull(substring(creationdate,1,4),substring(now(),1,4))  = substring(now(),1,4)";

$qrycode = mysqli_query($con,$sqlcode);
$arrcode = mysqli_fetch_array($qrycode);
$code = $arrcode['code'];

$sqlheader = "insert into t_ptrheader(transferfrom, ptrcode, datetransfered, transfertoResposibilitycenter, transfertype, approvedby,  tag, isactive, createdby, creationdate)
values
($Responsibility, '$code', '$dtpissued', $resid, '$trans', $txthiddenid,  $tag, 1, $uid, now())";

mysqli_query($con,$sqlheader);
while($row = mysqli_fetch_array($qry)){

$id =$row['id'];
$itemid =$row['itemid']; 
$propertyno =$row['propertyno'];
$reasonfortransfer =$row['reasonfortransfer']; 
$tags =$row['tag']; 
$condition =$row['condition'];  
$sqlinsertdetails = "insert into `t_ptrdetails` (`itemid`, `propertyno`, `ptrcode`, `reasontotransfer`, `condition`, `tag`)values
 ($itemid , '$propertyno', '$code', '$reasonfortransfer', '$condition', $tags)";

 mysqli_query($con,$sqlinsertdetails);
$sqlupdate = "update  `t_equipmentdeliverydetails` 
set `Status` = 'Transfered',
`previouslymodifiedby`=`modifiedby`, `previousmodificationdate` = `modificationdate`,
`modifiedby`= $uid, `modificationdate` = now()
, ResponsibilityCenter = $resid
WHERE `id` = $itemid";

mysqli_query($con,$sqlupdate);
$sqldelete = "delete from t_tempptr where id =$id";
mysqli_query($con,$sqldelete);

}
 $result[] = array("msg" => "PROPERTY, PLANT AND EQUIPMENT Successfully transfered!" , "tag" =>"2");	



}else{
	 $result[] = array("msg" => "Sorry you did not add PROPERTY, PLANT and EQUIPMENT to transfer!" , "tag" =>"1");	

}
   echo json_encode($result);
     mysqli_close($con);

 

?>