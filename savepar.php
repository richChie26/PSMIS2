<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    
   
$sqlko =" SELECT id,`itemid`, `qty`, `propertyno` ,`daterec`, `receiverid` FROM `t_temppar`  
where createdby = $uid and tag = 0 order by daterec ASC";
$qryko = mysqli_query($con,$sqlko);

while ($row = mysqli_fetch_array($qryko)) {
  $sql = "SELECT 
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
 FROM `t_par` where substring(ifnull(`creationdate`,now()),1,4) = substring(now(),1,4) and tag = 0";
 
 $qry = mysqli_query($con,$sql);
 $arr = mysqli_fetch_array($qry);
 $parno = $arr['parno'];
$myreceiver = $row['receiverid'];
$dtpissued = $row['daterec'];
 $sqlinsertheader = "insert into `t_par` (`PARNO`, `Dateissue`, `datereceived`, `receivedby`, `issuedby`, `isactive`, `createdby`, `creationdate`)
 values
 ('$parno', '$dtpissued', '$dtpissued', $myreceiver, $uid, 1, $uid, now())";
   mysqli_query($con,$sqlinsertheader);



  $itemid =$row['itemid'];
  $propertyno =$row['propertyno'];
  $id =$row['id'];

  $sqlinsertdetails = "insert into `t_pardetails` (`itemid`, `qty`, `parno`, `propertyno`)
  values($itemid,1,'$parno','$propertyno')";
mysqli_query($con,$sqlinsertdetails);

$sqlupdate = "update  `t_equipmentdeliverydetails`
set `Status` = 'Issued'
, `previouslymodifiedby` =`modifiedby`
, `previousmodificationdate` = modificationdate
,`modifiedby` = $uid
, `modificationdate` = now()
WHERE `propertyno` = '$propertyno'";

mysqli_query($con,$sqlupdate);
$sqldel = "Delete FROM `t_temppar`  where id = $id";
mysqli_query($con,$sqldel);


}



    $result[] = array("msg" => "Success PROPERTY ACKNOWLEDGEMENT RECEIPT Successfully Saved!" , "tag" =>"1");


   echo json_encode($result);
     mysqli_close($con);

   ?> 