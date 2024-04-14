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
$richie = "";
foreach ($val as $chie ){
$richie = $richie . $chie .',';
}
$richie = substr($richie,0,-1);

$sql = "SELECT a.id,`risno`,`purpose`, substring(`datarerequest`,1,10) DateRequest,b.Requestedby
    , case when ifnull(`status`,'') = '' then 
         'For Approval'
        else 
            ifnull(`status`,'')
     end status, `remarksforapproval` 'Remarks'
     ,ResponsibilityCenter
     FROM `t_requesitionhead` a
left join (SELECT `userid`,
concat(`fname`, ', ' , substring(`mname`,1,1),'.',' ',`lname`) Requestedby, `ResponsibilityCenter`

FROM `a_user` X 
LEFT join u_profile y on x.`profileid` = y.profileid and y.isactive = 1
where x.isactive = 1 ) b on a.`requestedby` = b.userid 
where a.isactive = 1 and  status = 'Released' 
and ResponsibilityCenter = $rid and a.id in ($richie)   order by a.id desc";
// 
$qry = mysqli_query($con,$sql);

echo '  <table  class="table table-condensed table-striped" style="width:98% ;margin-left: 10px;">
               <thead style="background-color: #337ab7;color:white;">
<tr>
<th>RIS No. </th> 
<th>Purpose </th> 
<th>Requested by </th> 
<th>Date Request </th> 
<th>Remarks </th> 
<th>Status</th></tr></thead>';
while ($row = mysqli_fetch_array($qry)) {
	echo '<tr>
<td>'.$row['risno'].'</td> 
<td>'.$row['purpose'].'</td> 
<td>'.$row['Requestedby'].'</td> 
<td>'.$row['DateRequest'].'</td> 
<td>'.$row['Remarks'].'</td> 
<td>'.$row['status'].'</td></tr>';
}


?>

</table>
<hr/>
<div class="row">
	<div class="col-xs-12">
		<button class="btn btn-primary" id="rsmiyes">Yes</button>
		<button class="btn btn-danger" id="rsmino">No</button>
	</div>
</div>
