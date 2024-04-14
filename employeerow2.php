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
$eidko = $_GET['eidko'];

// echo $eidko;
$sqleidko = "select * from (select *
,case when ifnull(Stat,'') = ''  then 
	Acperson
    else
    rec
end Person 

,case when ifnull(Stat,'') = ''  then 
 date_format(	dateaquired ,'%m-%d-%Y')
    else
    date_format( Dateissue,'%m-%d-%Y')
end dateacq 

,case when ifnull(Stat,'') = ''  then 
	''
    else
    par
end par2

from 


(

select

*,
(select x.status from vwissueandreturn x where x.propertyno = a.propertyno order by x.creationdate  desc limit 1 )
Stat,
(select x.acperson from vwissueandreturn x where x.propertyno = a.propertyno order by x.creationdate  desc limit 1 )

rec
,
(select x.Remarks  from vwissueandreturn x where x.propertyno = a.propertyno order by x.creationdate  desc limit 1 )

remarks2
    ,
(select x.Dateissue   from vwissueandreturn x where x.propertyno = a.propertyno order by x.creationdate  desc limit 1 ) Dateissue
    ,
(select x.parno   from vwissueandreturn x where x.propertyno = a.propertyno order by x.creationdate  desc limit 1 )
    par
	
from vwitemDetails a  ) y ) xy where Person like '%$eidko%' ";

 $qryidko = mysqli_query($con,$sqleidko);

// echo $sqleidko;


$sqlx = "select a.* from a_groupsetup a 
left join a_group b on a.groupid = b.id and b.isactive =1 
where a.isactive = 1 and a.userid = $uid"; 

$qryx = mysqli_query($con,$sqlx);
$arrx = mysqli_fetch_array($qryx);
$groupid = $arrx['groupid'];
?>
<table class="table table-striped">
	<tr>
		<th>Date <br/> </th>
		<th>Quantity</th>
		<th>Unit</th>
		<th>Article</th>
		<th>Description</th>
		<th>Property Number</th>
		<th>PAR Number</th>
		<th>Unit Price</th>
		<th>Fund Source</th>
		<th>Remarks</th>
		
		<?php 
			if($groupid == 1 ){
				echo '<th>Action</th>';
			}
		?>

	</tr>
	<?php
	while ($row = mysqli_fetch_array($qryidko)) {
		
	
echo '<tr>
		<td>'.$row['dateacq'].'</td>
		<td>1</td>
		<td>'.$row['units'].'</td>
		<td>'.$row['item'].'</td>
		<td>'.$row['description'].'</td>
		<td>'.$row['propertyno'].'</td>
		<td>'.$row['par2'].'</td>
		<td>'.$row['amount'].'</td>
		<td>'.$row['Fundcategory'].'</td> 
		<td></td>';
		if($groupid == 1 ){
			echo '<td>
			<table>
			<tr>
				<td>
				<a href="#" id="edit|edit|'.$row['propertyno'].'" class="btneditp"> <span class="btn glyphicon glyphicon-edit"></span></a>
				</td><td>
				<a href="#" id="del|del|'.$row['propertyno'].'"  class="btndelp" style="color:red" > <span class="btn glyphicon glyphicon-minus"></span></a>
				</td>	
				</tr></table>
			</td>';
			
		}
	
	echo '</tr>';
}
	?>
</table>
