<style>

.printbox{
  border-style: solid;
  border-color: black;
  border-width: 1px;
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
    // $mydata = "RIS-0001";
 
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
$sql = "SELECT `risno`,`purpose`, date_format(`datarerequest`,'%M %d, %Y') DateRequest,b.Requestedby
    , case when ifnull(`status`,'') = '' then 
         'For Approval'
        else 
            ifnull(`status`,'')
     end status, `remarksforapproval` 'Remarks'
     
     ,(SELECT 
(SELECT concat('[',`code`,']',' ', `Fundcategory`) FROM `m_fundcluster` fu WHERE  fu.id = sourceoffund) FundCluster FROM `t_requisitiondetails` rec 
left join (
SELECT itemid,`sourceoffund` FROM `t_itemreceived` rh left join t_receivedheader rd on rh.`transcode` = rd.`transcode` and rd.isactive = 1
where rh.isactive =1  group by Itemid ,sourceoffund 
) rt on rec.itemid = rt.itemid 
      where RSIcode = a.`risno`
group by RSIcode ) FundCluster
     
     
     ,(SELECT 
concat(`fname`,' ',  substring(`mname`,1,1),'. ', `lname`) sss
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = `approvedby`) Approved
     
     ,date_format(case when ifnull((SELECT 
concat(`fname`,' ',  substring(`mname`,1,1),'. ', `lname`) sss
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = `approvedby`),'') = '' then 
        ''
        else
     date(`dateapproved`) end ,'%M %d, %Y') DateApprove,
    
    
    
    
     (SELECT 
`Position`
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = approvedby) approverposition,


     (SELECT 
concat(`fname`,' ',  substring(`mname`,1,1),'. ', `lname`) sss
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = `receivedby`) ReceivedBy
     ,date_format(case when ifnull((SELECT 
concat(`fname`,' ',  substring(`mname`,1,1),'. ', `lname`) sss
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = `receivedby`),'') = '' then 
        ''
        else
     date(`datereceived`) end,'%M %d, %Y') dateReceived
     ,
     (SELECT 
`Position`
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = receivedby) recieverposition
             ,
     (SELECT 
pr.`divsion`
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1

where au.isactive =1 and au.userid = a.requestedby) divsion 
,(SELECT 
`office`
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = a.requestedby) requestoffice
,(SELECT 
`Position`
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = a.requestedby) requestedbyposition

,(SELECT 
`Position`
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = approvedby) approverposition
,(SELECT 
rsc.`rccode`
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
left join a_responsibilitycenter rsc on pr.`ResponsibilityCenter` = rsc.id and rsc.isactive =1 
where au.isactive =1 and au.userid = a.requestedby ) rccode,

     (SELECT 
concat(`fname`,' ',  substring(`mname`,1,1),'. ', `lname`) sss
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = `issuedby`) Issuedby
     ,date_format(case when ifnull((SELECT 
concat(`fname`,' ',  substring(`mname`,1,1),'. ', `lname`) sss
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = `issuedby`),'') = '' then 
        ''
        else
     date(`dateissued`) end,'%M %d, %Y') dateissued
     ,
     (SELECT 
`Position`
FROM `a_user` au
left join u_profile pr on au.profileid = pr.profileid and pr.isactive =1 
where au.isactive =1 and au.userid = issuedby) Issuedbyposition

     FROM `t_requesitionhead` a
     
     
     
left join (SELECT `userid`,
concat(`fname`, ', ' , substring(`mname`,1,1),'.',' ',`lname`) Requestedby, `ResponsibilityCenter`

FROM `a_user` X 
           
LEFT join u_profile y on x.`profileid` = y.profileid and y.isactive = 1
where x.isactive = 1 ) b on a.`requestedby` = b.userid 


where a.isactive = 1
 and risno = '$mydata' "; 

//  echo $sql;
$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);



?>
<!-- class="printheader" -->
<div class="printheader" >

<div class="row">
  <div class="cols-xs-8"></div>
  <div class="cols-xs-2"> <i> <span style="float:right;padding:20px;">Appendix 63</span></i></div>
</div>
<div class="row" >
   <div class="col-xs-4">
    <img src="img/Logo.bmp" 

id="imglogoheader"
>
  <!-- <div id="imglogoheader"></div> -->
</div>
   <div class="col-xs-5"><b><center>Republic of the Philippines</center></b>          
<b><center>Department of Environment and Natural Resources</center></b> 
<b><center><?php echo $ResponsibilityCenter; ?></center></b><br/>         
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
		<b>Entity Name:</b>	&nbsp;&nbsp;&nbsp;&nbsp;<u><b><?php echo $ResponsibilityCenter; ?></b></u>			
	</div>
	<div class="col-xs-6">
	<b>Fund Cluster </b>	&nbsp;&nbsp;<u><?php echo $arr['FundCluster']; ?></u>
	</div>
</div>
<br/>

  <!-- <div class="table-responsive"> -->
      <table class="table printbox "  >
        <tr class="printbox">
          <td colspan="5"  class="printbox"  >Division : <?php echo $arr['divsion'] ?></td>
         

          <td colspan="3"  class="printbox" >Resposibility Center Code :<?php echo $arr['rccode'] ?></td>
          
        </tr>
         <tr>
          <td colspan="5"  class="printbox"  >Office : <?php echo $arr['requestoffice'] ?></td>
         

          <td colspan="3"  class="printbox" >RIS NO. :<?php echo $arr['risno'] ?></td>
          
        </tr>
        <tr>
          <td colspan="4" class="printbox" ><center><i><b>Requisition</b></i></center></td>
          <td colspan="2" class="printbox" ><center><i><b>Stock Available?</b></i></center></td>
          <td colspan="2" class="printbox" ><center><i><b>Issue</b></i></center></td>
        </tr>
<tr>
          <td class="printbox" ><i><b>Stock No.</b></i></td>
          <td class="printbox" ><i><b>Units</b></i></td>
          <td class="printbox" ><i><b>Description</b></i></td>
           <td class="printbox" ><center><i><b>Quantity</b></i></center></td>
          <td class="printbox" ><center><i><b>Yes</b></i></center></td>
          <td class="printbox" ><center><i><b>No</b></i></center></td>
          <td  class="printbox" ><center><i><b>Quantity</b></i></center></td>
          <td class="printbox" ><i><b>Remarks</b></i></td>
        </tr>
  <!--     </table>
  
  <table  class="table table-striped" style="border-style: solid; margin-top: 0px; top: 0;" border="1" cellpadding="0" cellspacing="0"> -->
<?php 
$sqlitems = "SELECT 

ifnull((SELECT sum(`qty`) FROM `t_itemreceived` f
WHERE f.isactive = 1 
and f.`ResponsibilityCenter` = a.`ResponsibilityCenter`
and f.`itemid` = a.`itemid`
and f.`creationdate`  <= b.dateapproved
group by `itemid`),0)
-
(

SELECT 


sum(case when det.status ='Approved' then 
    `qty`
    else 
     `approvedqty`
end )
 FROM `t_requisitiondetails` det 
left join t_requesitionhead hed  on det.`RSIcode` = hed.risno and hed.isactive = 1 

where det.`Status` in ( 'Released','Approved')
 and hed .dateapproved  <= b.dateapproved
 and det.itemid  = a.itemid 
 and det.`ResponsibilityCenter`  = a.`ResponsibilityCenter`  
 group by det.itemid ) Stocks,c.*,a.*

,case when a.status ='Approved' then 
    `qty`
    when a.status ='Released' then
     `approvedqty`
end issued ,a.id,
ifnull((

SELECT 


sum(case when det.status ='Approved' then 
    `qty`
    else 
     `approvedqty`
end )
 FROM `t_requisitiondetails` det 
left join t_requesitionhead hed  on det.`RSIcode` = hed.risno and hed.isactive = 1 

where det.`Status` in ( 'Released','Approved')
 and hed .dateapproved  <= b.dateapproved
 and det.itemid  = a.itemid 
 and det.`ResponsibilityCenter`  = a.`ResponsibilityCenter`  
 group by det.itemid ),0) labas
FROM `t_requisitiondetails` a 
left join t_requesitionhead b on a.`RSIcode` = b.risno and b.isactive =1 
left join (SELECT x.id ,`item`,`stockno`, `description`,y.units FROM `m_materials` x left join m_units y on x.`units` = y.id and y.isactive = 1 where x.isactive = 1) c on a.itemid = c.id 
where  a.`RSIcode` ='$mydata'
"; 
$qryitem = mysqli_query($con,$sqlitems);
$mynum = 0 ;
$mypage = 0;
$newmod = 0;

$mybilang = mysqli_num_rows($qryitem);

$newrows = mysqli_num_rows($qryitem);

while ($rowitem = mysqli_fetch_array($qryitem)) {
    $chek = "";
    $chek2 = "";
    if($rowitem['stockno'] >= $rowitem['qty']){
      $chek = '<span class= "glyphicon glyphicon-ok"></span>';
      $chek2 = '';
    }else{
      $chek = '';
      $chek2 = '<span class= "glyphicon glyphicon-ok"></span>';
    }
$mynum = $mynum + 1 ;

 if($mynum % 8){

  echo '<tr>
          <td width ="13%" class="printbox">'.$rowitem['stockno'].'</td>
          <td width ="9%" class="printbox">'.$rowitem['units'].'</td>
          <td width ="15%" class="printbox">'.$rowitem['description'].'</td>
           <td width ="12%" class="printbox"><center>'.$rowitem['qty'].'</center></td>
          <td width ="11%" class="printbox"><center>'.$chek.'</center></td>
          <td width ="11%" class="printbox"><center>'.$chek2.'</center></td>
          <td width ="14%" class="printbox"><center>'.$rowitem['approvedqty'].'</center></td>
          <td width ="14%" class="printbox">'.$rowitem['remarks'].'</td>
        </tr>';
    }else{
    ?>
    <tr>
  <td colspan="8">Purpose : <?php echo $arr['purpose'];?></td>
</tr>
<tr>
  <td class="printbox"></td>
  <td colspan="2" class="printbox"style="font-weight:bold;">Requested by:</td>
  <td colspan="2" class="printbox"style="font-weight:bold;">Approved By:</td>
  <td colspan="2" class="printbox"style="font-weight:bold;">Issued By:</td>
  <td class="printbox" style="font-weight:bold;">Received By:</td>

</tr>
<tr>
  <td  class="printbox" style="font-weight:bold;">Signature:</td>
  <td colspan="2" class="printbox" ></td>
  <td colspan="2" class="printbox" ></td>
  <td colspan="2" class="printbox" ></td>
  <td class="printbox" ></td>

</tr>
<tr>
  <td class="printbox" style="font-weight:bold;" >Printed Name:</td>
  <td colspan="2"class="printbox" ><?php echo $arr['Requestedby'];?></td>
  <td colspan="2"class="printbox" ><?php echo $arr['Approved'];?></td>
  <td colspan="2"class="printbox" ><?php echo $arr['Issuedby'];?></td>
  <td class="printbox" ><?php echo $arr['ReceivedBy'];?></td>

</tr>
<tr>
  <td class="printbox"  style="font-weight:bold;" >Designation:</td>
  <td colspan="2" class="printbox" ><?php echo $arr['requestedbyposition'];?></td>
  <td colspan="2" class="printbox" ><?php echo $arr['approverposition'];?></td>
  <td colspan="2" class="printbox" ><?php echo $arr['Issuedbyposition'];?></td>
  <td class="printbox" ><?php echo $arr['recieverposition'];?></td>

</tr>
<tr>
  <td  class="printbox"  style="font-weight:bold;">Date:</td>
  <td colspan="2" class="printbox" ><?php echo $arr['DateRequest'];?></td>
  <td colspan="2" class="printbox" ><?php echo $arr['DateApprove'];?></td>
  <td colspan="2" class="printbox" ><?php echo $arr['dateissued'];?></td>
  <td class="printbox" ><?php echo $arr['dateReceived'];?></td>

</tr>
      </table>

    <?php
    $mypage = $mypage + 1 ;
    $mybilang = $mybilang - 8;
    echo '<center>Page :'.$mypage .'</center>' ;
 


    if($mybilang > 0 ){

    
      ?>
      <div class="row">
  <div class="cols-xs-8"></div>
  <div class="cols-xs-2"> <i> <span style="float:right;padding:20px;">Appendix 63</span></i></div>
</div>
<div class="row" >
   <div class="col-xs-4">
    <img src="img/Logo.bmp" 

id="imglogoheader"
>
  <!-- <div id="imglogoheader"></div> -->
</div>
   <div class="col-xs-5"><b><center>Republic of the Philippines</center></b>          
<b><center>Department of Environment and Natural Resources</center></b> 
<b><center><?php echo $ResponsibilityCenter; ?></center></b><br/>         
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
    <b>Entity Name:</b> &nbsp;&nbsp;&nbsp;&nbsp;<u><b><?php echo $ResponsibilityCenter; ?></b></u>     
  </div>
  <div class="col-xs-6">
  <b>Fund Cluster </b>  &nbsp;&nbsp;<u><?php echo $arr['FundCluster']; ?></u>
  </div>
</div>

  <!-- <div class="table-responsive"> -->
      <table class="table printbox"  >
        <tr class="printbox" >
          <td colspan="5"  class="printbox"  width="60%">Division : <?php echo $arr['divsion'] ?></td>
         

          <td colspan="3" class="printbox"  width="40%">Resposibility Center Code :<?php echo $arr['rccode'] ?></td>
          
        </tr>
         <tr>
          <td colspan="5"  class="printbox"  width="60%">Office : <?php echo $arr['requestoffice'] ?></td>
         

          <td colspan="3"  class="printbox" width="40%">RIS NO. :<?php echo $arr['risno'] ?></td>
          
        </tr>
        <tr>
          <td colspan="4" class="printbox" ><center><i><b>Requisition</b></i></center></td>
          <td colspan="2" class="printbox" ><center><i><b>Stock Available?</b></i></center></td>
          <td colspan="2" class="printbox" ><center><i><b>Issue</b></i></center></td>
        </tr>
<tr>
          <td class="printbox" ><i><b>Stock No.</b></i></td>
          <td class="printbox" ><i><b>Units</b></i></td>
          <td class="printbox" ><i><b>Description</b></i></td>
           <td class="printbox" ><center><i><b>Quantity</b></i></center></td>
          <td class="printbox" ><center><i><b>Yes</b></i></center></td>
          <td class="printbox" ><center><i><b>No</b></i></center></td>
          <td class="printbox" ><center><i><b>Quantity</b></i></center></td>
          <td class="printbox" ><i><b>Remarks</b></i></td>
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
  <td colspan="8" class="printbox" >Purpose : <?php echo $arr['purpose'];?></td>
</tr>
<tr>
  <td class="printbox"></td>
  <td colspan="2" class="printbox" style="font-weight:bold;">Requested by:</td>
  <td colspan="2" class="printbox" style="font-weight:bold;">Approved By:</td>
  <td colspan="2" class="printbox" style="font-weight:bold;">Issued By:</td>
  <td class="printbox"  style="font-weight:bold;">Received By:</th>

</tr>
<tr>
  <td  class="printbox" style="font-weight:bold;">Signature:</td>
  <td colspan="2" class="printbox" ></td>
  <td colspan="2" class="printbox" ></td>
  <td colspan="2" class="printbox" ></td>
  <td class="printbox" ></td>

</tr>
<tr>
  <td class="printbox" style="font-weight:bold;" >Printed Name:</td>
  <td colspan="2"class="printbox" ><?php echo $arr['Requestedby'];?></td>
  <td colspan="2"class="printbox" ><?php echo $arr['Approved'];?></td>
  <td colspan="2"class="printbox" ><?php echo $arr['Issuedby'];?></td>
  <td class="printbox" ><?php echo $arr['ReceivedBy'];?></td>

</tr>
<tr>
  <td class="printbox"   style="font-weight:bold;">Designation:</td>
  <td colspan="2" class="printbox" ><?php echo $arr['requestedbyposition'];?></td>
  <td colspan="2" class="printbox" ><?php echo $arr['approverposition'];?></td>
  <td colspan="2" class="printbox" ><?php echo $arr['Issuedbyposition'];?></td>
  <td class="printbox" ><?php echo $arr['recieverposition'];?></td>

</tr>
<tr>
  <td  class="printbox"  style="font-weight:bold;">Date:</td>
  <td colspan="2" class="printbox" ><?php echo $arr['DateRequest'];?></td>
  <td colspan="2" class="printbox" ><?php echo $arr['DateApprove'];?></td>
  <td colspan="2" class="printbox" ><?php echo $arr['dateissued'];?></td>
  <td class="printbox" ><?php echo $arr['dateReceived'];?></td>

</tr>
      </table>

    <?php
    $mypage = $mypage + 1 ;
    $mybilang = $mybilang - 8;
    echo '<center>Page :'.$mypage .'</center>' ;
 
     
}


?>







</div>

