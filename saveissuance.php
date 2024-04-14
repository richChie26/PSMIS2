<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$myid = $_GET['myid'];
$txtapproveqty = $_GET['txtapproveqty'];
$ris = $_GET['ris'];
$tagabato = $_GET['tagabato'];
$app = $_GET['app'];
$req = $_GET['req'];
$sql = "SELECT `RSIcode` FROM `t_requisitiondetails` where id = $myid ";
$qry = mysqli_query($con,$sql);

$code = mysqli_fetch_array($qry);
$RSIcode = $code['RSIcode'];
$sqlcount = "Select RSIcode from t_requisitiondetails where RSIcode = '$RSIcode' and status ='Pending' ";


 $qrycode = mysqli_query($con,$sqlcount);

if($app > $req){
echo "2";
}else if($txtapproveqty < 1){
echo "3";
}else if(mysqli_num_rows($qrycode)  == 1){
$sqlii = "SELECT `itemid`, `ResponsibilityCenter` FROM `t_requisitiondetails` WHERE `id` = $myid";
$qryii = mysqli_query($con,$sqlii);
$arrii = mysqli_fetch_array($qryii);

$itemid = $arrii['itemid'];
$ResponsibilityCenter = $arrii['ResponsibilityCenter'];


$sqls = "SELECT ifnull(sum(`qty`),0) bal  FROM `t_itemreceived` where `itemid` = $itemid
and `ResponsibilityCenter` = $ResponsibilityCenter ";
$qrys = mysqli_query($con,$sqls);
$arrs = mysqli_fetch_array($qrys);
$cbal = $arrs['bal'];
$sqlrel = "SELECT ifnull(sum(`approvedqty`),0) rel FROM `t_requisitiondetails` WHERE `itemid` = $itemid  and `ResponsibilityCenter` = $ResponsibilityCenter  and Status= 'Issued'";
$qryrel = mysqli_query($con,$sqlrel);
$arrrel = mysqli_fetch_array($qryrel);
$rel = $arrrel['rel'];
$runbal = $cbal - ($rel + $txtapproveqty);
$sqlko = "update 

`t_requisitiondetails`

set `approvedqty` = $txtapproveqty , `Status` = 'Issued' ,bal = $runbal
WHERE id = $myid ";

mysqli_query($con,$sqlko);
	$sqlupdate ="update  `t_requesitionhead`
set 

`issuedby` = $uid, `dateissued` = now(), `receivedby` = $tagabato , `datereceived` = now()
,`previouslymodifiedby` = modifiedby
,`previousmodificationdate` = modificationdate
,status = 'Released'
,modifiedby = $uid 
,modificationdate = now()
WHERE `risno` = '$RSIcode'";

mysqli_query($con,$sqlupdate);


$ssts = "select id from  t_itemreceived  where `itemid` = $itemid
and `ResponsibilityCenter` = $ResponsibilityCenter
order by id desc 
";

$sqllsss = mysqli_query($con,$ssts);
$ftid = mysqli_fetch_array($sqllsss);
$ftidds =$ftid['id'];
// echo $ssts;
$sqlupdarunbal = "update t_itemreceived set bal = $runbal 
where id = $ftidds";
// mysqli_query($con,$sqlupdarunbal);
// echo $sqlupdarunbal ;
echo "1";
}else{
 $sqlii = "SELECT `itemid`, `ResponsibilityCenter` FROM `t_requisitiondetails` WHERE `id` = $myid";
$qryii = mysqli_query($con,$sqlii);
$arrii = mysqli_fetch_array($qryii);

$itemid = $arrii['itemid'];
$ResponsibilityCenter = $arrii['ResponsibilityCenter'];


$sqls = "SELECT ifnull(sum(`qty`),0) bal  FROM `t_itemreceived` where `itemid` = $itemid
and `ResponsibilityCenter` = $ResponsibilityCenter ";
$qrys = mysqli_query($con,$sqls);
$arrs = mysqli_fetch_array($qrys);
$cbal = $arrs['bal'];
$sqlrel = "SELECT ifnull(sum(`approvedqty`),0) rel FROM `t_requisitiondetails` WHERE `itemid` = $itemid  and `ResponsibilityCenter` = $ResponsibilityCenter   and Status= 'Issued'";
$qryrel = mysqli_query($con,$sqlrel);
$arrrel = mysqli_fetch_array($qryrel);
$rel = $arrrel['rel'];
$runbal = $cbal - ($rel + $txtapproveqty); 

$sqlko = "update 

`t_requisitiondetails`

set `approvedqty` = $txtapproveqty , `Status` = 'Issued' ,bal = $runbal
WHERE id = $myid ";

mysqli_query($con,$sqlko);

 $sqllist = "SELECT a.id,
accounttitle,stockno,itemname,
description,`qty`,
 (SELECT 
 
sum(`qty`) Received



FROM `t_itemreceived` k 
where k.`itemid` = a.itemid and k.`ResponsibilityCenter` = a.ResponsibilityCenter 
and k.isactive = 1 )    
 - (SELECT ifnull(
case when `Status` = 'Pending' then 
  sum(ifnull(`qty`,0))
   when  `Status` = 'Approved' then
   sum( ifnull(`approvedqty`,0))
end,0) issued

FROM `t_requisitiondetails` x WHERE  x.`itemid` = a.itemid   and x. `ResponsibilityCenter` = a.ResponsibilityCenter
and `Status` in ('Approved') ) Available

,units
FROM `t_requisitiondetails` a 
left join (SELECT 
x.id,z.accounttitle,
itemname,`stockno`,`description`
,za.units
FROM `m_materials` x 
left join m_itemname y on x.item = y.id and y.isactive = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.`units` = za.id and za.isactive = 1  
where x.isactive = 1 ) b on a.`itemid` = b.id 
where `RSIcode` = '$RSIcode' and ifnull(a.Status,'') = 'Pending'";

  $qrylist = mysqli_query($con,$sqllist);

                          while ($newrow = mysqli_fetch_array($qrylist)) {
  echo '<tr class= "itemrow" id="'.$newrow['id'].'|'.$newrow['stockno'].'|'.$newrow['itemname'].'|'.$newrow['description'].'|'.$newrow['units'] .'" >
        <td>'.$newrow['stockno'].'</td>
        <td>'.$newrow['itemname'].'</td>
        <td>'.$newrow['description'].'</td>
        <td>'.$newrow['units'].'</td>
        <td>'.$newrow['qty'].' 
        <input type="hidden" value ="'.$newrow['qty'].'" id="txtmyqty'.$newrow['id'].'" name = "txtmyqty'.$newrow['id'].'"></td>
        <td>'.$newrow['Available'].'</td>
        <td><div class="form-group"><input class="form-control" type="number" id="txtapproveqty'.$newrow['id'].'" name="txtapproveqty" size="1" > </div></td>
        <td > <button class="btn btn-primary btnreleaseitem" id="'.$newrow['id'].'|'.$RSIcode.'|'.$RSIcode.$RSIcode.$RSIcode.$RSIcode.'" style=" padding-right: : 15px;margin-right: :15px;"><span class="glyphicon glyphicon-thumbs-up">&nbsp;Release</span></button></td>
  </tr>';

                          }
                       


}


 ?>