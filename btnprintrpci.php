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
$sqlacc = "SELECT `accounttitle` FROM `m_accouttitle` WHERE `id` = $selmyacct and `isactive` = 1";

$sqldata = "SELECT `item`, `stockno`,b.units, `description`
,(SELECT Fundcategory FROM `t_itemreceived`xx 
left join t_receivedheader yy on xx.`transcode`  = yy.`transcode` and yy.isactive = 1
left join m_fundcluster zz on yy.sourceoffund = zz.id and zz.isactive = 1 
where xx.isactive  =1
and xx.`itemid` = a.id 
and xx.`ResponsibilityCenter` = $rid
limit 1 ) fund,
convert(now(),date) araw
   FROM `m_materials` a 
left join m_units b on a.`units` = b.id and b.isactive = 1 
where a.isactive = 1 and `titleid` = $selmyacct";


$qrydata = mysqli_query($con,$sqldata);
$ardd = mysqli_fetch_array($qrydata);
$fund = $ardd['fund'];
$qryacct = mysqli_query($con,$sqlacc);
$title = mysqli_fetch_array($qryacct);
$accounttitle = $title['accounttitle'];
$araw = $ardd['araw'];

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
<center><h5><b>REPORT ON THE PHYSICAL COUNT OF INVENTORIES</b></h5> 
<br><u><?php
  echo $accounttitle;
?></u>
<br/> <b>As at</b> <u><?php echo $araw; ?></u>
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
    echo 'is accountable, having assumed such accountability on';
    ?>
    </div>
</div>
<table class="table table-stripped">
  <tr>
    <td>Article</td>
    <td>Description</td>
    <td>Stock No.</td>
    <td>Unit of Measurement</td>
    <td>Unit Cost</td>
    <td>Balance Per Card</td>
    <td>On Hand Per Count</td>
    <td>Shortage/Overage</td>
    <td></td>
    <td>Remarks</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Quantity</td>
    <td>Quantity</td>
    <td>Quantity</td>
    <td>Value</td>
    <td></td>
  </tr>
  <tbody id="tblrpci">
    
<?php
$sqldataq = "SELECT `item`, `stockno`,b.units, `description`
,(SELECT `amount` FROM `t_itemreceived` xc  WHERE xc.isactive = 1 
and xc.`ResponsibilityCenter` = $rid
and xc.`itemid` = a.id  
limit 1 ) cost,
((SELECT sum(`qty`) FROM `t_itemreceived` xc  WHERE xc.isactive = 1 
and xc.`ResponsibilityCenter` = $rid
and xc.`itemid` = a.id  
limit 1 ) - 
(SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s WHERE s.`itemid` = a.id 
and s.`ResponsibilityCenter` = $rid) )qtyres
   FROM `m_materials` a 
left join m_units b on a.`units` = b.id and b.isactive = 1 
where a.isactive = 1 and `titleid` = $selmyacct";


$qrydataq = mysqli_query($con,$sqldataq);
  $sss = "";
  while ($row = mysqli_fetch_array($qrydataq)) {
    if($row['cost'] == ""){
      $sss = "";
    }else{
      $sss =  '<span>&#8369;</span>'.$row['cost'];

    }
  echo '<tr>
      <td>'.$row['item'].'</td>
      <td>'.$row['description'].'</td>
      <td>'.$row['stockno'].'</td>
      <td>'.$row['units'].'</td>
      <td>'.$sss.'</td>
      <td>'.$row['qtyres'].'</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
       </tr>';
  
  }

  ?>

  </tbody>
</table>

