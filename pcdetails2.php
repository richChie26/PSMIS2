<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$sqlres = "SELECT 

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

$qryres = mysqli_query($con,$sqlres);
$arrres = mysqli_fetch_array($qryres);

$Responsibility = $arrres['Responsibility'];
$txtproperty3 = $_GET['txtproperty3'];
$sql = "Select deliveryNumber,convert(deliverydate,date) deliverydate, Oname,
case when Tag = 'Del' or Tag = 'return'  then
 '1'
 else
  '' 
 end qtyin ,
  
case when Tag = 'PAR' or Tag = 'transfer'  then
 '1'
 else
  '' 
 end qtyout

from  ( SELECT  deliveryNumber ,deliverydate,'Del' Tag,
(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  
left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = a.createdby) Oname

FROM `t_equipmentdeliverydetails` a 
left join t_equipmentdeliveryheader b on a.`deliverycode`  = b.deliverycode and b.isactive = 1 
where a.isactive = 1  and `propertyno` = '$txtproperty3'

union all

SELECT x.PARNO,Dateissue, 'PAR' 
,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  
left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = yi.receivedby)

FROM `t_pardetails` x 
left join t_par yi on x.`parno` = yi.`parno` and yi.isactive = 1 
where `propertyno` = '$txtproperty3'

union all

SELECT  f.`rcode`,datereturn ,'return' 
,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  
left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = (SELECT yii.`receivedby`


FROM `t_pardetails` xi 
left join t_par yii on xi.`parno` = yii.`parno` and yii.isactive = 1 
where xi.`propertyno` = '$txtproperty3')) 
FROM `t_returndetails` f 
left join t_returns g on f.rcode  = g.rcode and g.isactive = 1 
where `propertyno` = '$txtproperty3' 

union all 

SELECT k.`ptrcode`,datetransfered,'transfer',(
    SELECT `ResponsibilityCenter` FROM `a_responsibilitycenter` ss WHERE ss.`id` = transfertoResposibilitycenter
    ) FROM `t_ptrdetails` j 
left join t_ptrheader k on k.`ptrcode` = j.ptrcode and k.isactive = 1
where `propertyno` = '$txtproperty3'
) chie order by deliverydate asc ";



$qry = mysqli_query($con,$sql);
while ( $row= mysqli_fetch_array($qry)) {
echo '<tr>
                  <td>'.$row['deliverydate'].'</td>
                  <td>'.$row['deliveryNumber'].'</td>
                  <td>'.$row['qtyin'].'</td>
                  <td>'.$row['qtyout'].'</td>
                   <td>'.$row['Oname'].'</td>
                  
                   <td></td>
                   <td></td> <td></td>
                                   </tr>';	
}



?>