
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

$sqlres = "SELECT 

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
$arrres = mysqli_fetch_array($qryres);

$Responsibility = $arrres['Responsibility'];


$sql = " SELECT b.`userid`,a.completename,Section,position FROM 
 
 vwprofile a 
 left join  `a_user` b on a.`profileid`  = b.`profileid` and b.isactive =1 

where 
ifnull(b.userid ,0) != 0 and Resposibilitycenter = '$Responsibility'";
$qry = mysqli_query($con,$sql);


   
echo '

<div class= "row"> <div class="col-xs-12"><table class ="table table-striped display"  id="example2" >
                <thead style="background-color: #337ab7;color:white;"> <tr>
		<th>Name</th>
    <th>Section</th>
		<th>Position</th>
	
		</tr></thead><tbody id="listofmats">
		';

while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "employeerow" id="'.$row['userid'].'|'.$row['Completename'].'" >
        <td>'.$row['Completename'].'</td>
			  <td>'.$row['Section'].'</td>
			  <td>'.$row['Position'].'</td>
		
	</tr>';
}
echo '</tbody></table></div></div>';		
?>
<script>
    $(document).ready(function () {
        $('#example2').DataTable();
    });
</script>