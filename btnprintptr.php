<?php
	include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$mydata = $_GET['mydata'];
    // $mydata = "2021-09-0001";
 
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

$sql = "SELECT a.`id`, `ptrcode`, `datetransfered`, `transfertype` ,b.ResponsibilityCenter, 
(SELECT f.`ResponsibilityCenter` FROM `a_responsibilitycenter` f where f.id = a.transferfrom and f.isactive = 1 ) transferfrom ,
(SELECT f.`ResponsibilityCenter` FROM `a_responsibilitycenter` f where f.id = a.transfertoResposibilitycenter and f.isactive = 1 ) transfertoResposibilitycenter ,
(SELECT (SELECT concat('[',j.`code`,'] ',`Fundcategory`) FROM `m_fundcluster` j WHERE j.isactive =1 and j.id = g.sourceoffund) FROM `t_equipmentdeliverydetails` f left join t_equipmentdeliveryheader g on f.`deliverycode` = g.deliverycode and g.isactive = 1 where f.isactive = 1 and f.`id` = ( SELECT k.`itemid` FROM `t_ptrdetails` k where k.`ptrcode` = a.ptrcode order by k.id asc limit 1 )) Fundcluster 

,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname  FROM `a_user` ff 
left join u_profile gg on ff.`profileid` = gg.profileid and gg.isactive =1 
where ff.isactive = 1 and ff.userid = a.approvedby ) Approved 



,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname  FROM `a_user` ff 
left join u_profile gg on ff.`profileid` = gg.profileid and gg.isactive =1 
where ff.isactive = 1 and ff.userid = a.createdby )  Issuedby 

,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname  FROM `a_user` ff 
left join u_profile gg on ff.`profileid` = gg.profileid and gg.isactive =1 
where ff.isactive = 1 and ff.userid = a.receivedby )  ReceivedBy 



,(SELECT Position  FROM `a_user` ff 
left join u_profile gg on ff.`profileid` = gg.profileid and gg.isactive =1 
where ff.isactive = 1 and ff.userid = a.approvedby ) approverposition  



,(SELECT  Position FROM `a_user` ff 
left join u_profile gg on ff.`profileid` = gg.profileid and gg.isactive =1 
where ff.isactive = 1 and ff.userid = a.createdby )  Issuedbyposition  

,(SELECT Position  FROM `a_user` ff 
left join u_profile gg on ff.`profileid` = gg.profileid and gg.isactive =1 
where ff.isactive = 1 and ff.userid = a.receivedby )  recieverposition  


,

case when `datereceived` = '0000-00-00' then '' else datereceived end  dateReceived  , `datetransfered`, convert(a.`creationdate`,date) DateApprove , convert(a.`creationdate`,date)  dateissued 

FROM `t_ptrheader` a
left join a_responsibilitycenter b on a.`transfertoResposibilitycenter` = b.id and b.isactive =1 
where a.isactive = 1 and a.ptrcode = '$mydata'"; 


$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);
$Fundcluster = $arr['Fundcluster'];
$datetransfered = $arr['datetransfered'];
$transfertoResposibilitycenter = $arr['transfertoResposibilitycenter'];
$transferfrom = $arr['transferfrom'];
$ptrcode = $arr['ptrcode'];
$transfertype = $arr['transfertype'];
?>
<!-- class="printheader" -->
<div class="printheader" >
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
<center><h5><b>PROPERTY TRANSFER REPORT</b></h5> </center>
</div>
   <div class="col-xs-2"></div>
</div>

<div class="row">
  <div class="col-xs-12"></div>
</div> 
				

<br/>
<div class="row">
	<div  class="col-xs-6">
		<b>Entity Name:</b>	&nbsp;&nbsp;&nbsp;&nbsp;<u><b>PENRO Isabela</b></u>			
	</div>
	<div class="col-xs-6">
	<b>Fund Cluster </b>	&nbsp;&nbsp;<u><?php echo $Fundcluster ; ?></u>
	</div>
</div>

  <!-- <div class="table-responsive"> -->
      <table class="table table-striped" style="border-style: solid;

      " border="1">
        <tr>
          <td colspan="5" width="60%">From Accountable Officer/Agency/Fund Cluster : <?php echo $transferfrom; ?> </td>
         

          <td colspan="3" width="40%">Date: <?php echo $datetransfered; ?></td>
          
        </tr>
         <tr>
          <td colspan="5"  width="60%">To Accountable Officer/Agency/Fund Cluster : <?php echo $transfertoResposibilitycenter; ?> </td>
         

          <td colspan="3" width="40%">PTR No. : <?php echo $ptrcode; ?> </td>
          
        </tr>
        <tr>
          <th colspan="8"><center><i><b><p style="float:left;"> Transfer Type: (check only one)</p></b></i></center>
          <br/>
          <?php 
            $Relocate ="";
            $Donation ="";
            $Reassignment ="";
            $others = ""; 
            if($transfertype =="DONATION" ){
              
              $Donation ="checked";
              
             }elseif($transfertype =="RELOCATE" ){
              $Relocate = "checked";
             }elseif($transfertype =="REASSIGNMENT" ){
              $Reassignment ="checked";
             }else{
              $others = $transfertype;
             }
          
          ?>
          <input type="checkbox" name="chkdonation" id="chkdonation" <?php echo $Donation; ?> > Donation  
          &nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp; 
          <input type="checkbox" name="chkrelocate" id="chkrelocate" <?php echo $Relocate; ?> > Relocate 
         
          <br/>
          <div style="margin-left:110px;">
          <input type="checkbox" name="chkreassignment"   id="chkreassignment" style="margin-left: 100px;"
          <?php echo $Reassignment; ?> 
          > Reassignment   &nbsp;&nbsp;&nbsp;&nbsp;
 
          <input type="checkbox" name="chkothers" id="chkothers"> If Others &nbsp;&nbsp; <?php echo $others; ?>
         </div>
        </th>
     
        </tr>
<tr>
          <th colspan="2" ><i><b>Date Acquired</b></i></th>
          <th ><i><b>Property Number</b></i></th>
          <th colspan="3"><i><b>Description</b></i></th>
       
         
          <th><i><b>Amount</b></i></th>
          
          <th width="13%"> <i><b>Condition</b></i></th>
      
        </tr>
  <!--     </table>
  
  <table  class="table table-striped" style="border-style: solid; margin-top: 0px; top: 0;" border="1" cellpadding="0" cellspacing="0"> -->
<?php 
$sqlitems = "SELECT f.id,f.condition ,b.*,f.reasontotransfer FROM `t_ptrdetails` f left join 
(SELECT a.id delitemid, accounttitle,item,yearoflife, concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, `propertyno`,convert(dateaquired,date) dateaquired,format(amount,2) amount FROM `t_equipmentdeliverydetails` a 
left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife` FROM `m_equipent` x 
    left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = 3
     and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 ) b on f.`propertyno` = 
     b.propertyno
where f.ptrcode = '$mydata'"; 
$qryitem = mysqli_query($con,$sqlitems);
$mynum = 0 ;
$mypage = 0;
$newmod = 0;

$mybilang = mysqli_num_rows($qryitem);

$newrows = mysqli_num_rows($qryitem);
$reasontotransfer = "";
while ($rowitem = mysqli_fetch_array($qryitem)) {
  $reasontotransfer =  $rowitem['reasontotransfer'];
$mynum = $mynum + 1 ;

 if($mynum % 8){

  echo '<tr>
          <td  colspan="2">'.$rowitem['dateaquired'].'</td>
          <td >'.$rowitem['propertyno'].'</td>
          <td  colspan="3">'.$rowitem['description'].'</td>
      
          <td >'.$rowitem['amount'].'</td>
          <td >'.$rowitem['condition'].'</td>

     
        
        </tr>';
    }else{
    ?>
    <tr>
  <td colspan="8">Reason : <?php echo $reasontotransfer;?></td>
</tr>
<tr>
  <th colspan="2"></th>
 
  <th colspan="2">Approved By:</th>
  <th colspan="2">Issued By:</th>
  <th>Received By:</th>
  <th></th>

</tr>
<tr>
  <td colspan="2">Signature:</td>

  <td colspan="2"></td>
  <td colspan="2"></td>
  <td></td>
   <td></td>

</tr>
<tr>
  <td colspan="2" >Printed Name:</td>

  <td colspan="2"><?php echo $arr['Approved'];?></td>
  <td colspan="2"><?php echo $arr['Issuedby'];?></td>
  <td ><?php echo $arr['ReceivedBy'];?></td>
   <td></td>
</tr>
<tr>
  <td colspan="2" >Designation:</td>

  <td colspan="2"><?php echo $arr['approverposition'];?></td>
  <td colspan="2"><?php echo $arr['Issuedbyposition'];?></td>
  <td><?php echo $arr['recieverposition'];?></td>
 <td></td>
</tr>
<tr>
  <td colspan="2">Date:</td>

  <td colspan="2"><?php echo $arr['DateApprove'];?></td>
  <td colspan="2"><?php echo $arr['dateissued'];?></td>
  <td><?php echo $arr['dateReceived'];?></td>
 <td></td>
</tr>
      </table>

    <?php
    $mypage = $mypage + 1 ;
    $mybilang = $mybilang - 8;
    echo '<center>Page :'.$mypage .'</center>' ;
 


    if($mybilang > 0 ){

    
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
<center><h5><b>REQUISITION AND ISSUE SLIP</b></h5> </center>
</div>
   <div class="col-xs-2"></div>
</div>

<div class="row">
  <div class="col-xs-12"></div>
</div> 
        

<br/>
<div class="row">
  <div  class="col-xs-6">
    <b>Entity Name:</b> &nbsp;&nbsp;&nbsp;&nbsp;<u><b>PENRO Isabela</b></u>     
  </div>
  <div class="col-xs-6">
  <b>Fund Cluster </b>  &nbsp;&nbsp;<u><?php echo $arr['FundCluster']; ?></u>
  </div>
</div>

  <!-- <div class="table-responsive"> -->
      <table class="table table-striped" style="border-style: solid;

      " border="1">
        <tr>
          <td colspan="5" width="60%">Division : <?php echo $arr['divsion'] ?></td>
         

          <td colspan="3" width="40%">Resposibility Center Code :<?php echo $arr['rccode'] ?></td>
          
        </tr>
         <tr>
          <td colspan="5"  width="60%">Office : <?php echo $arr['requestoffice'] ?></td>
         

          <td colspan="3" width="40%">RIS NO. :<?php echo $arr['risno'] ?></td>
          
        </tr>
        <tr>
          <th colspan="4"><center><i><b>Requisition</b></i></center></th>
          <th colspan="2"><center><i><b>Stock Available?</b></i></center></th>
          <th colspan="2"><center><i><b>Issue</b></i></center></th>
        </tr>
<tr>
          <th><i><b>Stock No.</b></i></th>
          <th><i><b>Units</b></i></th>
          <th><i><b>Description</b></i></th>
           <th><center><i><b>Quantity</b></i></center></th>
          <th><center><i><b>Yes</b></i></center></th>
          <th><center><i><b>No</b></i></center></th>
          <th><center><i><b>Quantity</b></i></center></th>
          <th><i><b>Remarks</b></i></th>
        </tr>

      <?php
    }

   
?>


<?php 
    }
}
$xc = fmod($newrows, 8);

if($xc > 0 ){
  ?>


    <tr>
  <td colspan="8">Reason  : <?php echo $reasontotransfer;?></td>
</tr>
<tr>
  <th colspan="2"></th>

  <th colspan="2">Approved By:</th>
  <th colspan="2">Issued By:</th>
  <th>Received By:</th>
  <th></th>
</tr>
<tr>
  <td colspan="2">Signature:</td>

  <td colspan="2"></td>
  <td colspan="2"></td>
  <td></td>
 <td></td>
</tr>
<tr>
  <td colspan="2" >Printed Name:</td>
 
  <td colspan="2"><?php echo $arr['Approved'];?></td>
  <td colspan="2"><?php echo $arr['Issuedby'];?></td>
  <td ><?php echo $arr['ReceivedBy'];?></td>
   <td></td>
</tr>
<tr>
  <td colspan="2" >Designation:</td>
 
  <td colspan="2"><?php echo $arr['approverposition'];?></td>
  <td colspan="2"><?php echo $arr['Issuedbyposition'];?></td>
  <td><?php echo $arr['recieverposition'];?></td>
 <td></td>
</tr>
<tr>
  <td colspan="2">Date:</td>
 
  <td colspan="2"><?php echo $arr['DateApprove'];?></td>
  <td colspan="2"><?php echo $arr['dateissued'];?></td>
  <td><?php echo $arr['dateReceived'];?></td>
 <td></td>
</tr>
      </table>

  <?php
  $mypage = $mypage + 1;
    echo '<center>Page :'.$mypage .'</center>' ;
}


?>









