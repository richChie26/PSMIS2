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

$mydata = $_GET['mydata'];
$sqlres = "SELECT a.`ResponsibilityCenter`,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$completename = $aarres['completename'];
$sql = "SELECT Suppliername,`transcode`,
date_format(`datereceived`, '%M %d, %Y')  datereceived, `Pono`, date_format(`PODATE`, '%M %d, %Y') PoDate, `receiptno`,`FinancingSource`, `Fundcategory`
FROM `t_receivedheader` a 
left join m_supplier b on a.`supplierid` = b.id  and b.isactive =1 
left join m_fundcluster c on a.`sourceoffund` = c.id and c.isactive = 1 
where a.isactive = 1 
and a.transcode = '$mydata'"; 
$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);

$sqlprof = "SELECT * FROM `a_agencyprofile` WHERE 1";
$qryprof = mysqli_query($con,$sqlprof);


$arrprof =  mysqli_fetch_array($qryprof );

$AgencyHeader = $arrprof ["AgencyHeader"];
?>

<div class="row" >
   <div class="col-xs-4">
    <img src="img/Logo.bmp" id="imglogoheader">
  <!-- <div id="imglogoheader"></div> -->
  </div>
   <div class="col-xs-5"><b><center>Republic of the Philippines</center></b>     
      
   <b><center><?php echo $AgencyHeader;   ?></center></b> 
      <!-- <b><center>Department of Environment and Natural Resources</center></b>  -->
      <b><center><?php echo $ResponsibilityCenter; ?></center></b>    <br/>     
      <center><h5><b>NOTICE OF DELIVERY</b></h5> </center>
    </div>
  
</div>

<br/>
<div class="row">
	<div  class="col-xs-8">
		<b>Fund Source:</b>	&nbsp;&nbsp;&nbsp;&nbsp;<u>[<?php echo $arr['FinancingSource']; ?>] - <?php echo $arr['Fundcategory']; ?></u>			
	</div>
	<div class="col-xs-4">
	<b>Delivery Batch No:</b>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $mydata; ?></u>
	</div>
</div>

<div class="row">
	<div  class="col-xs-8">
		<b> Supplier :</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;  <?php echo $arr['Suppliername']; ?>
	<br/><b>P.O. Number :</b>  &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $arr['Pono']; ?>
	<br/><b>P.O. Date :</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;  <?php echo $arr['PoDate']; ?>
	
	</div>
	<div class="col-xs-4">
		<b>Delivery Receipt No.:</b> &nbsp;&nbsp; <?php echo $arr['receiptno']; ?>
		<br/><b>Delivery Date :</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  <?php echo $arr['datereceived']; ?>

	</div>
</div>

<br/>

<div class="row">
         <div class="col-xs-12">
         
            <br/>
             <table   id="richietable" width="100%">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                     <th class="printbox"><span style="margin:5px;"> Account Title</span></th>
                    <th class="printbox"><span style="margin:5px;">Stock No.</span></th>
                    <th class="printbox"><span style="margin:5px;">Item</span></th>
                    <th class="printbox"><span style="margin:5px;">Description</span></th>
                    <th class="printbox"><center>Qty</center></th> 
                    <th class="printbox"><center>Unit</center></th>
                    <th class="printbox"><center>Amount</center></th>
                   
                </tr>
              </thead>
                <tbody>



                    <?php
                        $sqldet = "SELECT 

accounttitle, stockno,itemname ,description, `qty`,Units,amount, format((`amount`* qty),2) totalAmount

FROM `t_itemreceived` a 
left join (SELECT x.id,z.accounttitle, `stockno`,x.item itemname,`description`,za.units FROM `m_materials` x 

left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.units = za.id and za.isactive = 1 
where x.isactive = 1 ) b on a.itemid = b.id

where `transcode` = '$mydata' and a.isactive = 1 
union all 
SELECT 

 'Total', '','' ,'', '','','', format(SUM((`amount`* qty)),2) totalAmount

FROM `t_itemreceived` a 
left join (SELECT x.id,z.accounttitle, `stockno`,itemname,`description`,za.units FROM `m_materials` x 
left join m_itemname y on x.`item` = y.id and y.isactive  = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.units = za.id and za.isactive = 1 
where x.isactive = 1 ) b on a.itemid = b.id
where `transcode` = '$mydata' and a.isactive = 1 ";
                    
                    $qrydet = mysqli_query($con,$sqldet);

while ( $rowdet = mysqli_fetch_array($qrydet)) {
    $myrow = "";
    $mytotal ="";
        if($rowdet['accounttitle'] == "Total"){
            $myrow =  '<span class= "colorred" style="font-weight:bold"> ' . $rowdet['accounttitle'] . '</span>' ;

          $mytotal ='<span>&#8369;</span> '.$rowdet['totalAmount'] ;
        }else{
         $myrow =$rowdet['accounttitle'] ;
         $mytotal = $rowdet['totalAmount'] ;
        }



        echo 
                   ' <tr cell> <td class="printbox" ><span style="margin:5px;">'.$myrow .'</span></td>
                    <td class="printbox" ><span style="margin:5px;">'.$rowdet['stockno'] .'</span></td>
                    <td class="printbox" ><span style="margin:5px;">'.$rowdet['itemname'] .'</span></td>
                    <td class="printbox" ><span style="margin:5px;">'.$rowdet['description'] .'</span></td>
                    <td class="printbox" ><center>'.$rowdet['qty'] .'</center></td>
                    <td class="printbox" ><center>'.$rowdet['units'] .'</center></td> 
                    <td class="printbox" style="text-align:right;font-weight:bold;">' .$mytotal.'</td>
                   </tr>'; 
}

                    ?>


                </tbody></table></div></div>
              <br/><br/><br/><div class="row">
              	<div class="col-xs-9"></div>
				<div class="col-xs-3"><b>Certified by:</b>
						<br/><br/>
						<b><u><?php echo $completename; ?></u></b>
						<br/>Property Custodian
				</div>
              </div>


                 

         
