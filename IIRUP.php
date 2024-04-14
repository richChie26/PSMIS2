<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename,a.Position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$positon = $aarres['Position'];
$completename  = $aarres['completename'];
$rid = $aarres['rid'];
$sqlacc = "SELECT `accounttitle`
,convert(now(),date) araw
 FROM `m_accouttitle` WHERE  `isactive` = 1";
$qryacct = mysqli_query($con,$sqlacc);
$title = mysqli_fetch_array($qryacct);

$araw = $title['araw'];


$sqlclus = "SELECT item ,(SELECT `Fundcategory` FROM `m_fundcluster` ff WHERE ff.id = e.sourceoffund ) fund , a.`propertyno`, `description`, `Serial`, `amount`, units FROM 
`t_returndetails` a 
left join t_equipmentdeliverydetails f on a.propertyno = f.propertyno
left join m_equipent b on f.`itemid` = b.id and b.isactive =1
left join m_accouttitle c on b.accounttitle = c.id and c.isactive =1
left join t_equipmentdeliveryheader e on f.deliverycode = e.deliverycode and e.isactive = 1 
left join m_units d on b.unitofmeasurement = d.id and d.isactive = 1
where a.condition = 'Unserviceable' 
and f.ResponsibilityCenter = $rid


";

$qrycls = mysqli_query($con,$sqlclus);
$arrcls = mysqli_fetch_array($qrycls);
$fund = $arrcls['fund'];
$sqlprof = "SELECT userid, 
 concat(`fname`, substring(`mname`,1,1),'. ', `lname`) cname,
`Position`,c.ResponsibilityCenter rc
FROM `a_user` a
left join u_profile b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on b.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive =1 
and a.userid = $uid
";

$qrypro = mysqli_query($con,$sqlprof);
$arrpro = mysqli_fetch_array($qrypro);
$cname = $arrpro['cname'];
$Position = $arrpro['Position'];
$rc = $arrpro['rc'];
?>
<div class="row" >
   <div class="col-xs-3">
    <img src="img/Logo.bmp" 

id="imglogoheader"
>
  <!-- <div id="imglogoheader"></div> -->
</div>
   <div class="col-xs-5"><b><center>Republic of the Philippines</center></b><br/>          
<b><center>Department of Environment and Natural Resources</center></b> 
<b><center><?php echo $ResponsibilityCenter; ?></center></b>         
<center><h5><b>INVENTORY AND INSPECTION REPORT OF UNSERVICEABLE PROPERTY</b></h5> 

<br/> <b>As at</b> <u><?php echo $araw; ?></u>
</center>
</div>
   <div class="col-xs-2"></div>
</div><br><br>
<div class="row">
    <div class="col-xs-5">
      <b>Entity Name </b> : <?php echo $ResponsibilityCenter ;?>
    </div>
     <div class="col-xs-5">
      <b>Fund Cluster</b> : <?php echo $fund;?>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-xs-3">
    <?php 
    echo '<u>'.$completename .'</u><br/>';

    echo '(Name of Accountable Officer)';
   	

    ?>
    </div>
      <div class="col-xs-3">
    <?php 
    echo '<u>'.$positon.'</u><br/>';

    echo '(Designation)';
   		
$completename
    ?>
    </div>
      <div class="col-xs-3">
    <?php 
   		echo '___________<br/>';
echo '(Station)';
    ?>
    </div>
</div>

<div class="row">
	<div class="col-xs-12">
		<table class="table table-striped" width="100%">
			<tr>
				<th colspan="10" ><center>INVENTORY</center></th>
				<th colspan="8"><center>INSPECTION and DISPOSAL</center></th>
			</tr>
			<tr>
				<th colspan="10"></th>
			
				<th colspan="5"><center>DISPOSAL</center></th>
				<th></th>
				<th colspan="2">RECORD OF SALES</th>
			</tr>	
			<tr>
				<th>Date Acquired</th>
				<th>Particulars/
				Articles</th>
				<th>Property No.</th>
				<th>Qty</th>
				<th>Unit Cost</th>
				<th>Total Cost</th>
				<th>Accumulated 
Depreciation
</th>
				<th>Accumulated
Impairment Losses
</th>
				<th>Carrying 
Amount</th>
				<th>Remarks</th>
				<th>Sale</th>
				<th>Transfer</th>
				<th>Destruction</th>
				<th>Other (Specify)</th>
				<th>Total</th>
				<th>Appraised Value</th>
				<th>OR No.</th>
				<th>Amount</th>
			
			</tr>


			<?php

$sqlnew =  "SELECT item ,(SELECT `Fundcategory` FROM `m_fundcluster` ff WHERE ff.id = e.sourceoffund ) fund , a.`propertyno`, `description`, `Serial`, `amount`,convert(f.dateaquired,date) dateaquired, units,deliveryNumber
,a.condition
 FROM 
`t_returndetails` a 
left join t_equipmentdeliverydetails f on a.propertyno = f.propertyno

left join m_equipent b on f.`itemid` = b.id and b.isactive =1
left join m_accouttitle c on b.accounttitle = c.id and c.isactive =1
left join t_equipmentdeliveryheader e on f.deliverycode = e.deliverycode and e.isactive = 1 
left join m_units d on b.unitofmeasurement = d.id and d.isactive = 1
where a.condition = 'Unserviceable' 
and f.ResponsibilityCenter = $rid
"; 

$newqry = mysqli_query($con,$sqlnew);
while ($rowssss = mysqli_fetch_array($newqry)) {
	echo '<tr>
				<td>'.$rowssss['dateaquired'].'</td>
				<td>'.$rowssss['item'].'</td>
				<td>'.$rowssss['propertyno'].'</td>
				<td>1</td>
				<td>'.$rowssss['amount'].'</td>
				<td>'.$rowssss['amount'].'</td>
				<td>
</td>
				<td>
</td>
				<td></td>
				<td>'.$rowssss['condition'].'</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>'.$rowssss['deliveryNumber'].'</td>
				<td>'.$rowssss['amount'].'</td>
			
			</tr>';
}
			?>
			<tr>
				<td colspan="8">
 I HEREBY request inspection and disposition,<br> pursuant to Section  79 of PD 1445, of the property enumerated above.
				</td>
				<td colspan="7">
	
		
		 I CERTIFY that I have inspected each<br> and every 
article enumerated <br/>in this report, and that the 
disposition made thereof <br/> was, in my judgment, the 
best for the public interest.  			
	

				</td>
			<td colspan="3"> 
			 I CERTIFY that I have witnessed the disposition of<br/> the articles enumerated on this report this <br/>____day of _____________, _____.
			</td>	
			</tr>

		</table>
	</div>
	
</div>