
<style>
  
  .printbox{

      border: 1px solid black;
      }
  .tblm{
    width:100%;
    padding: 30px;
  }
</style>
<?php
	include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$mydata = $_GET['mydata'];
    // $mydata = "2021-07-0001";
    $tag = $_GET['tag'];
$sqlres = "SELECT a.`ResponsibilityCenter`,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
,Position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$completename = $aarres['completename'];
$Position  = $aarres['Position'];
$sql = "SELECT ifnull(Suppliername,orgin) Suppliername,`deliverycode`,
date_format(`deliverydate`,'%M %d, %Y') deliverydate, `PONumber`, 
case when ifnull(PONumber,'') = '' then '' else 
  date_format(`PODATE`,'%M %d, %Y') 
end  PoDate, `deliveryNumber`,`FinancingSource`,code, `Fundcategory`
FROM `t_equipmentdeliveryheader` a 
left join m_supplier b on a.`supplierid` = b.id  and b.isactive =1 
left join m_fundcluster c on a.`sourceoffund` = c.id and c.isactive = 1 
where a.isactive = 1 
and a.deliverycode = '$mydata'";


$sqldata = "SELECT 
concat(fname,' ', substring(mname, 1,1),'. ', lname) completename
,Position
FROM `t_equipmentdeliveryheader` x
 
left join a_user  a on x.`createdby` = a.userid and a.isactive = 1
left join `u_profile`  b on a.`profileid` = b.`profileid` and b.isactive = 1 
where x.isactive = 1 and x.`deliverycode` = '$mydata'";

$qrysl = mysqli_query($con,$sqldata);
$rri = mysqli_fetch_array($qrysl);
$cname =  $rri['completename'];
$pos = $rri['Position'];

$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);
$titles = "";
$text ="";

if($tag == 2){
  $titles ="NOTICE OF DELIVERY";
  $text = "Semi-Expendable Property";
}else if($tag == 3){
$titles ="NOTICE OF DELIVERY";
$text = "Property, Plant, and Equipment (PPE)";
}
?>
<div class="row" >
   <div class="col-xs-3">
    <img src="img/Logo.bmp" 

id="imglogoheader"
>
  <!-- <div id="imglogoheader"></div> -->
</div>
   <div class="col-xs-5"><b><center>Republic of the Philippines</center></b>          
    <b><center>Department of Environment and Natural Resources</center></b>
    <b><center><?php echo $ResponsibilityCenter; ?></center></b>    <br/>      
    <center><h5><b><?php echo $titles; ?></b></h5> </center>
    <center><h5><b><?php echo $text; ?></b></h5> </center><br/>
</div>
   <div class="col-xs-2"></div>
</div>
<div class="row">
	<div  class="col-xs-8">
		<b>Fund Source:</b>	&nbsp;&nbsp;&nbsp;&nbsp;[<?php echo $arr['code']; ?>] - <?php echo $arr['Fundcategory']; ?>			
	</div>
	<div class="col-xs-4">
	<b>Delivery Batch No:</b>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mydata; ?>
	</div>
</div>

<div class="row">
	<div  class="col-xs-8">
		<b> Supplier :</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;  <?php echo $arr['Suppliername']; ?>
	<br/><b>PO Number :</b>  &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $arr['PONumber']; ?>
	<br/><b>PO Date :</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;  <?php echo $arr['PoDate']; ?>
	
	</div>
	<div class="col-xs-4">
   
		<b>Delivery Receipt No.:</b> &nbsp; <?php echo $arr['deliveryNumber']; ?>
		<br/><b>Delivery Date :</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php echo $arr['deliverydate']; ?>

	</div>
</div>



<div class="row">
         <div class="col-xs-12">
         



             <table  style="border: black solid 1px; " class="table " border="1" id="richietable">
             
                <tr class="printbox">

           

                     <th class="printbox"> Account Title</th>
                    <th class="printbox">Property No.</th>
                    <th class="printbox">Item</th>
                    <th class="printbox">Description</th>
                    <th class="printbox">Qty</th> 
                    <th class="printbox">UoM</th>
                    <th class="printbox">Amount</th>
                   
                </tr>
             
                <tbody>



                    <?php
                        $sqldet = "SELECT  b.accounttitle,item,yearoflife, 

case when asset = 2 then 
concat(`description`,', ', `Serial`)
when asset = 3 then 
concat(`description`,', ', `Serial`,', ',`chasisnumber`)
end  description,units, `propertyno`,format(`amount`,2) amount FROM `t_equipmentdeliverydetails` a left join (SELECT x.id , y.typeofasset asset ,y.`accounttitle`, `item`,`yearoflife` ,z.units FROM `m_equipent` x 
left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1
left join m_units z on x.unitofmeasurement = z.id and z.isactive = 1 
 where y.typeofasset = $tag and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 and a.deliverycode = '$mydata' and b.asset = $tag


union all 
SELECT 'Total', '','','', 

'', '',format(sum(`amount`),2) FROM `t_equipmentdeliverydetails` a left join (SELECT x.id , y.typeofasset asset ,y.`accounttitle`, `item`,`yearoflife` FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = $tag and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 and a.deliverycode = '$mydata' and b.asset = $tag";



                    
                    $qrydet = mysqli_query($con,$sqldet);

while ( $rowdet = mysqli_fetch_array($qrydet)) {
    $myrow = "";
    $yoursum = "";
     $myclass = ""; 
      $totals ="";

        if($rowdet['accounttitle'] == "Total"){
            $myrow =  '<span  style=" font-weight:bold">' . $rowdet['accounttitle'] . '</span>' ;
            $yoursum = "";
            $myclass = "style= 'border: black solid 1px; font-weight:bold' ";
            $totals = "<span>&#8369;</span>";
        }else{
         $myrow =$rowdet['accounttitle'] ;
        $yoursum = "1";
        $myclass = "style= 'border: black solid 1px;'";
        $totals ="";
        }



        echo 
                   ' <tr><td class="printbox">'.$myrow .'</td>
                    <td '.$myclass.'>'.$rowdet['propertyno'] .'</td>
                    <td '.$myclass.'>'.$rowdet['item'] .'</td>
                    <td '.$myclass.'>'.$rowdet['description'] .'</td>
                    <td '.$myclass.'>'.$yoursum.'</td>
                    <td '.$myclass.'>'.$rowdet['units'] .'</td> 
                    <td '.$myclass.' style="text-align:right"> ' . $totals   .$rowdet['amount'] .'</td>
                   </tr>'; 
}

                    ?>


                </tbody></table></div></div>
              <br/><br/><br/><div class="row">
              	<div class="col-xs-9"></div>
				<div class="col-xs-3"><b>Certified by:</b>
						<br/><br/>
						<b><u><?php echo $cname; ?></u></b>
						<br/><?php echo $pos;  ?>
				</div>
              </div>


                 

         
