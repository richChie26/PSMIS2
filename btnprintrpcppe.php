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
$selmyacct  = $_GET['selmyacct'];

$rid = $aarres['rid'];
$sqlacc = "SELECT `accounttitle`
,DATE_FORMAT(convert(now(),date), '%M %d %Y')  araw
 FROM `m_accouttitle` WHERE `id` = $selmyacct and `isactive` = 1";
$qryacct = mysqli_query($con,$sqlacc);
$title = mysqli_fetch_array($qryacct);
$accounttitle = $title['accounttitle'];
$araw = $title['araw'];


$sqlclus = "SELECT 
item
,(SELECT  `Fundcategory` FROM `m_fundcluster` ff WHERE ff.id = e.sourceoffund ) fund ,
`propertyno`, `description`, `Serial`, `amount`, units,
case when a.Status = '' then 
'1' else '' end pc  
FROM `t_equipmentdeliverydetails`  a
left join m_equipent  b on a.`itemid` = b.id and b.isactive =1 
left join m_accouttitle c on b.accounttitle = c.id and c.isactive =1
left join t_equipmentdeliveryheader e on a.deliverycode = e.deliverycode and e.isactive = 1  
left join m_units d on b.unitofmeasurement = d.id and d.isactive = 1
where a.isactive = 1 and `ResponsibilityCenter` = $rid
and b.accounttitle =  $selmyacct
limit 1 
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

<div class="row">
  <div class="cols-xs-8"></div>
  <div class="cols-xs-2"> <i> <span style="float:right;padding:20px;">Appendix 73</span></i></div>
</div>
<div class="row" >
   <div class="col-xs-3">
    <img src="img/Logo.bmp" 

id="imglogoheader"
>
  <!-- <div id="imglogoheader"></div> -->
</div>
   <div class="col-xs-6"><b><center>Republic of the Philippines</center></b>          
<b><center>Department of Environment and Natural Resources</center></b> 
<b><center><?php echo $ResponsibilityCenter; ?></center></b>   <br/>      
<center><h5><b>REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT, AND EQUIPMENT</b></h5> 
<br><b style="  text-transform: uppercase;"><?php
  echo $accounttitle;
?></b>
<br/> <b>As at</b> <?php echo $araw; ?>
</center>
</div>
   <div class="col-xs-2"></div>
</div><br><br>
<div class="row">
    <div class="col-xs-5">
      <b>Fund Cluster</b> : <?php echo $fund;?>
    </div> 
</div>
<div class="row">
    <div class="col-xs-11">
    <?php 
    echo '<b>For which </b><u>'. $cname . '</u> ,' ;
    echo ' <u>'. $Position . '</u> ,' ;
    echo ' <u>'. $rc . '</u> ,' ;
    echo 'is accountable, having assumed such accountability on ________________________';
    ?>
    </div>
</div>
<br/>
<table class="table table-striped printbox" style="width:100%;padding:0px;margin:0px;">
               <!-- <thead> -->
               <thead style="background-color: #337ab7;color:white;padding: 0px;">
	<tr  style="font-weight:bold;">
		<td class="printbox" rowspan="2">Article</td>
		<td class="printbox" rowspan="2">Description</td>
		<td class="printbox" rowspan="2">Property Number</td>
		<td class="printbox" rowspan="2">UoM</td>
		<td class="printbox" rowspan="2">Value Per Unit </td>
		<td class="printbox" rowspan="2">Quantity Per Property Card</td>
		<td class="printbox" rowspan="2">Quantity Per Physical Count</td>
		<td class="printbox" colspan="2" >Shortage/Overage</td>

		<td class="printbox" rowspan="2">Accountable Person</td>
		<td class="printbox" rowspan="2">Remarks</td>
	</tr>
	<tr style="font-weight:bold;">

	
		<td class="printbox">Quantity</td>
		<td class="printbox">Value</td>
	
	</tr>
</thead>
	<tbody id="tblrpci">
		
<?php
$sqldata = "SELECT 
item,

`propertyno`, `description`, `Serial`, format(`amount`,2) amount, units,
case when a.Status = '' then 
'1' else '' end pc  
FROM `t_equipmentdeliverydetails`  a
left join m_equipent  b on a.`itemid` = b.id and b.isactive =1 
left join m_accouttitle c on b.accounttitle = c.id and c.isactive =1 
left join m_units d on b.unitofmeasurement = d.id and d.isactive = 1
where a.isactive = 1 and `ResponsibilityCenter` = $rid
and b.accounttitle =  $selmyacct";


$qrydata = mysqli_query($con,$sqldata);


$sss = "";
	while ($row = mysqli_fetch_array($qrydata)) {
		if($row['amount'] == ""){
			$sss = "";
		}else{
    	$sss =	''.$row['amount'];

		}

	echo '<tr >
			<td  class="printbox" >'.$row['item'].'</td>
			<td  class="printbox" >'.$row['description'].'</td>
			<td  class="printbox" >'.$row['propertyno'].'</td>
			<td  class="printbox" >'.$row['units'].'</td>
			<td  class="printbox" style="text-align:right;">'.$sss.'</td>
			<td  class="printbox" ><center>'.$row['pc'].'</center></td>
			<td class="printbox" ></td>
			<td class="printbox" ></td>
			<td class="printbox" ></td>
			<td class="printbox" ></td><td class="printbox" ></td>
		   </tr>';
	
	}





?>




<?php

$sqldata3 = "SELECT 
format( sum(`amount`),2) amount  
FROM `t_equipmentdeliverydetails`  a
left join m_equipent  b on a.`itemid` = b.id and b.isactive =1 
left join m_accouttitle c on b.accounttitle = c.id and c.isactive =1 
left join m_units d on b.unitofmeasurement = d.id and d.isactive = 1
where a.isactive = 1 and `ResponsibilityCenter` = $rid
and b.accounttitle =  $selmyacct";

$qrydata3 = mysqli_query($con,$sqldata3);

while($xrow = mysqli_fetch_array($qrydata3) ){
	$amount = $xrow['amount'] ;
	echo '<tr style="font-weight:bold;">
	<td  class="printbox" >TOTAL</td>
	<td  class="printbox" ></td>
	<td  class="printbox" ></td>
	<td  class="printbox" ></td>
	<td  class="printbox"  style="text-align:right;"><span>&#8369;</span>'.$amount.'</td>
	<td  class="printbox" ></td>
	<td class="printbox" ></td>
	<td class="printbox" ></td>
	<td class="printbox" ></td>
	<td class="printbox" ></td><td class="printbox" ></td>
   </tr>';



}
		
		?>
<tr style="height:150px;">
<td colspan="4">
<p style="font-weight:bold;">Certified Correct by: </p>

<br>
<br>
<p>_____________________________</p>
<p> Signature Over Printed Name of</p>
<p>Inventory Committee Chair and Members</p>
</td>
<td colspan="3">

<p style="font-weight:bold;">Approved by:</p>

<br>
<br>
<p>_____________________________</p>
<p> Signature Over Printed Name of Head of</p>
<p>Agency/Entity or Authorized Representative</p>
</td>
<td colspan="3">
<p style="font-weight:bold;">Verified by:</p>
		<br>
<br>
<p>_____________________________</p>
<p> Signature Over Printed Name of COA</p>
<p>Representative</p>
</td>
</tr>		
	</tbody>
</table>
<br/>



<div class="row">
	<div class="col-xs-3">
		
	</div>
	

</div>