<head>


<style>


      .printbox{
      border-style: solid;
      border-color: black;
      border-width: 1px;
      }
      @media print {
      

        #imglogoheader{
          list-style-image: url(img/Logo.bmp);
        }
      }

</style>
</head>

<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$rid = $aarres['rid'];
$eidko = $_GET['eidko'];
$txtempnameindex = $_GET['txtempnameindex'];
$sqleidko = "
select * from (select *
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
from vwitemDetails a  ) y ) xy where Person like '%$eidko%'

";

 $qryidko = mysqli_query($con,$sqleidko);



?>

<div class="row" >
   <div class="col-xs-3" >

    <img src="img/Logo.bmp"  
	style="width: 80px;
      height: 80px;
	  margin-left:0px;
	  padding-left:0px;"

>
  <!-- <div id="imglogoheader"></div> -->
</div>
   <div class="col-xs-6"><b><center>Republic of the Philippines</center></b>         
<b><center>Department of Environment and Natural Resources</center></b> 
<b><center><?php echo $ResponsibilityCenter; ?></center></b><br/>         
<center><h5><b>INDIVIDUAL EMPLOYEE PROPERTY INDEX</b></h5> </center>
	<center><?php 
		$sqldate = "select  date_format(now(),'%M %d, %Y ') mydate";
		$qrymydate = mysqli_query($con,$sqldate);

		$arrmydate = mysqli_fetch_array($qrymydate);
		$newdate = $arrmydate['mydate'];
		
		echo 'As of ' . $newdate;
?></center>

</div>
   <div class="col-xs-2"></div>
</div><br/>
<div class="row">
	<div class="3" style="  text-transform: uppercase;">
		
	<b style="margin-left:18px;">Accountable Officer:</b> <?php echo $txtempnameindex; ?>
	</div>
</div>
<br/>
<table  class="table table-striped printbox" style="width:100%;padding:0px;margin:0px;">
               <!-- <thead> -->
               <thead style="background-color: #337ab7;color:white;padding: 0px;">
               
	<tr>
		<td class="printbox"> <b>  Date  </b>  </td>
		<td class="printbox"> <b>  Qty </b>  </td>
		<td class="printbox"> <b>  Unit </b>  </td>
		<td class="printbox"> <b>  Article </b>  </td>
		<td class="printbox"> <b>  Description </b>  </td>
		<td class="printbox"> <b>  Property No </b>  </td>
		<td class="printbox"> <b>  PAR No </b>  </td>
		<td class="printbox"> <b>  Unit Price </b>  </td>
		<td class="printbox"> <b>  Fund Source </b>  </td>
		<td class="printbox"> <b>  Remarks </b>  </td>
	</tr>
</thead>
	<?php
	while ($row = mysqli_fetch_array($qryidko)) {
		
	
		echo '<tr>
		<td class="printbox">'.$row['dateacq'].'</td>
		<td class="printbox" style="text-align:center;">1</td>
		<td class="printbox">'.$row['units'].'</td>
		<td class="printbox">'.$row['item'].'</td>
		<td class="printbox">'.$row['description'].'</td>
		<td class="printbox">'.$row['propertyno'].'</td>
		<td class="printbox">'.$row['par2'].'</td>
		<td class="printbox" style="text-align:right;">'.$row['amount'].'</td>
		<td class="printbox">'.$row['Fundcategory'].'</td>
		<td class="printbox"></td>
	</tr>';
}
	?>
</table>
