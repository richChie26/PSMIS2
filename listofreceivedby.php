
<head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $mnuasset = $_GET['mnuasset'];

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

  ifnull(`userid`,up.profileid) userid,
`username`,
concat( `fname`,' ', substring(`mname`,1,1),'. ' , `lname`) Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic
,sec.Section ,rc.ResponsibilityCenter,up.Position 
FROM  u_profile up 
left join   `a_user` au on up.profileid =  au.`profileid`  and up.isactive = 1
left join a_responsibilitycenter rc on up.`ResponsibilityCenter` = rc.id and rc.isactive = 1 
left join a_section sec on up.section = sec.id and sec.isactive = 1 

where au.isactive = 1 and up.ResponsibilityCenter = $Responsibility
"; 


$qrypee = mysqli_query($con,$sqlppe);

echo '

<div class= "row"> <div class="col-xs-12"><table id="example"  style="width:100%"   class ="display">
                <thead style="background-color: #337ab7;color:white;"> <tr>
		<th>User Name</th>
    <th>Complete name</th>
		<th>Position</th>

		
		</tr></thead><tbody id="listofmats">
		';

while($row = mysqli_fetch_array($qrypee)){
	echo '<tr class= "itemlistiof" id="'.$row['userid'].'|'.$row['username'].'|'.$row['Completename'].'|'.$row['Position'].'" >
        <td>'.$row['username'].'</td>
			  <td>'.$row['Completename'].'</td>
			  <td>'.$row['Position'].'</td>
		
	</tr>';
}
echo '</tbody></table></div></div>';		
?>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>