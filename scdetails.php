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
$editbtnid = $_GET['editbtnid'];
$Responsibility = $arrres['Responsibility'];

$sql = "Select * from (SELECT  b.receiptno, convert(b.`datereceived`,date) cd, 1 tag, `qty` rqty, '' iss ,

format(`bal`,0) bal ,a.creationdate   FROM `t_itemreceived`  a
  left join t_receivedheader b on a.transcode = b.transcode and b.isactive = 1          
               WHERE 
`itemid`  = $editbtnid  and  `ResponsibilityCenter`  = $Responsibility
union all 

SELECT x.`RSIcode`,convert(dateissued,date),2, '', approvedqty,format(bal,0) ,dateapproved  FROM `t_requisitiondetails` x
left join t_requesitionhead y on x.`RSIcode` = y.risno
where y.isactive = 1 and x.status !='Pending'
and `itemid` = $editbtnid and  `ResponsibilityCenter` = $Responsibility
) a order by creationdate ASC
";
// echo '<tr><td>' .$sql .'</td></tr>';

$qry = mysqli_query($con,$sql);
while ( $row= mysqli_fetch_array($qry)) {
echo '<tr>
                  <td>'.$row['cd'].'</td>
                  <td>'.$row['receiptno'].'</td>
                  <td>'.$row['rqty'].'</td>
                  <td>'.$row['iss'].'</td>
                   <td></td>
                   <td>'.$row['bal'].'</td>
                  
                  
                   <td></td>
                                   </tr>';	
}



?>