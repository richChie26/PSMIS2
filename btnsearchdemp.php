<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $txtsearchoflist = $_GET['txtsearchoflist'];

    $sql = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat( `fname`,' ', substring(`mname`,1,1),'. ' , `lname`) Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    $Responsibility = $arr['Responsibility'];
 

$sqlppe = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat( `fname`,' ', substring(`mname`,1,1),'. ' , `lname`) Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic
,sec.Section ,rc.ResponsibilityCenter,up.Position 
FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1
left join a_responsibilitycenter rc on up.`ResponsibilityCenter` = rc.id and rc.isactive = 1 
left join a_section sec on up.section = sec.id and sec.isactive = 1 

where au.isactive = 1 

and concat( `fname`,' ', substring(`mname`,1,1),'. ' , `lname`) like '%".$txtsearchoflist."%'
"; 


$qrypee = mysqli_query($con,$sqlppe);

echo '

		';

while($row = mysqli_fetch_array($qrypee)){
	echo '<tr class= "itemappover" id="'.$row['userid'].'|'.$row['username'].'|'.$row['Completename'].'|'.$row['Position'].'" >
        <td>'.$row['username'].'</td>
			  <td>'.$row['Completename'].'</td>
			  <td>'.$row['Position'].'</td>
		
	</tr>';
}
	
?>
