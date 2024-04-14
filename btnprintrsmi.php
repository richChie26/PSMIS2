<style>

.printbox{
  border-style: solid;
  border-color: black;
  border-width: 1px;
}
.rightleft {
  border-left :1px solid;
  border-right :1px solid;
}
.mytop{
  border-top :1px solid;
}

.myalign{
  text-align:center;
  margin:10px;
}
.myalign span{
  text-align:center;
  margin:10px;
  font-weight:bold;
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
 
$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename,a.position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$completename = $aarres['completename'];
$position = $aarres['position'];
$sql = "SELECT `rsmicode`, date_format(`rsmiDate`,'%M %d, %Y')  rsmiDate
,(SELECT 
(Select Fundcategory  from m_fundcluster ff where ff.id = y.sourceoffund )

FROM `t_itemreceived` x 
left join t_receivedheader y on  x.`transcode` = y.`transcode` and y.isactive =1 
where `ResponsibilityCenter`  = ResponsibilityCenter  limit 1 )  FundCluster
 FROM `t_rsmi` WHERE `isactive` = 1 and rsmicode = '$mydata' "; 

$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);

$sqlkkk = "SELECT 

`RSIcode`
,c.`item`,`stockno`
,`approvedqty`
,rccode,d.units
,e.id 
FROM `t_requisitiondetails` a 
left join a_responsibilitycenter b on a.`ResponsibilityCenter` = b.id and b.isactive = 1 
left join m_materials c on a.`itemid` = c.id and c.isactive = 1 
left join m_units d on c.units = d.id  and d.isactive = 1 
left join t_requesitionhead e on a.`RSIcode` = e.risno and e.isactive =1 
left join t_rsmidetails f on e.id = f.rsiid 
where f.codes = '$mydata'";
$qrykkk = mysqli_query($con,$sqlkkk);
?>
<!-- class="printheader" -->
<div class="printheader" >
<div class="row">
  <div class="cols-xs-8"></div>
  <div class="cols-xs-2"> <i> <span style="float:right;padding:20px;">Appendix 64</span></i></div>
</div>
<div class="row" >
   <div class="col-xs-4">
    <img src="img/Logo.bmp"  width="80"
    height="80"
    
id="imglogoheader"
>
  <!-- <div id="imglogoheader"></div> -->
</div>
   <div class="col-xs-5"><b><center>Republic of the Philippines</center></b>          
<b><center>Department of Environment and Natural Resources</center></b> 
<b><center><?php echo $ResponsibilityCenter; ?></center></b><br/>         
<center><h5><b>REPORT OF SUPPLIES AND MATERIALS ISSUED</b></h5> </center>
</div>
   <div class="col-xs-2"></div>
</div>

<div class="row">
  <div class="col-xs-12"></div>
</div> 
				

<br/>
<div class="row">
	<div  class="col-xs-8">
	<b>Entity Name:</b>	&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $ResponsibilityCenter; ?></u>			
	</div>
	<div class="col-xs-4">
	<span style="margin-left:30px;"><b>Serial No.: </b>	&nbsp;&nbsp;<u><?php echo $mydata;  ?></u></span>
	</div>
</div>
<div class="row">
<div class="col-xs-8">
  <b>Fund Cluster: </b>  &nbsp;&nbsp;&nbsp;<u><?php echo $arr['FundCluster']; ?></u>
  </div>

  <div  class="col-xs-4">
 	<span style="margin-left:30px;">   <b>Date: </b><?php echo $arr['rsmiDate']; ?>    </span>
  </div>
  
</div>
</div><br/>
<div class="row">
  <div class="col-xs-12">
    <table class=" printbox mytop" width="100%">
      <tr class="printbox">
        
       
              
      <td class="printbox myalign" colspan="6">To be filled up by the Supply and Property Division/Unit</td>
        <td class="printbox myalign" colspan="2">To be filled up by the Accounting Division/Unit</td>
     
      </tr>
      <tr>
          <td class="printbox myalign"><span>RSI No.</span></td>
          <td class="printbox myalign"><span>Responsibility Center Code</span></td>
          <td class="printbox myalign"><span>Stock No.</span</td>
          <td class="printbox myalign"><span>Item</span</td>
          <td class="printbox myalign"><span>Unit</span</td>
          <td class="printbox myalign"><span>Quantity Issued</span</td>
          <td class="printbox myalign"><span>Unit Cost</span</td>
          <td class="printbox myalign"><span>Amount</span</td>
      </tr>

      <?php
      while ($row = mysqli_fetch_array($qrykkk)) {
       echo '<tr>
          <td class ="rightleft myalign">'.$row['RSIcode'].'</td>
          <td class ="rightleft myalign">'.$row['rccode'].'</td>
          <td class ="rightleft myalign">'.$row['stockno'].'</td>
           <td class ="rightleft myalign">'.$row['item'].'</td>
           <td class ="rightleft myalign">'.$row['units'].'</td>
          <td class ="rightleft myalign">'.$row['approvedqty'].'</td>

          
          <td class ="rightleft"></td>
          <td class ="rightleft"></td>
      </tr>';
      }
    
  
      ?>
  <tr style="height: 20px;">
      <td class="rightleft"></td>
      <td class="rightleft"></td>
      <td class="rightleft"></td>
       <td class="rightleft"></td>
       <td class="rightleft"></td>
      <td class="rightleft"></td>

      
      <td class="rightleft"></td>
      <td class="rightleft"></td>
  </tr>
        <tr>
          <td class="rightleft" ></td>
          <td class="printbox mytop myalign" colspan="2"><center><span>Recapitulation:</span></center></td>
          <td class="rightleft"></td>
          <td class="rightleft"></td>
          <td colspan="3" class="printbox myalign"><center><span>Recapitulation:</span></center></td>
        </tr>
        <tr>
            <th width="10%" class="rightleft"></td>
            <th  class="printbox myalign" ><span>Stock No.</span></td>
            <th class="printbox myalign" ><span>Quantity</span></td>
            <th class="rightleft"  width="10%"></td>
            <th  class="rightleft" width="10%"></td>  
            <th class="printbox myalign" ><span>Unit Cost</span></td>
            <th class="printbox myalign" ><span>Total Cost</span></td>
            <th class="printbox myalign" ><span>UACS Object Code</span></td>
        </tr>

        <?php
        $sqlsum = "SELECT 

stockno
,sum(`approvedqty`) qty 

FROM `t_requisitiondetails` a 
left join a_responsibilitycenter b on a.`ResponsibilityCenter` = b.id and b.isactive = 1 
left join m_materials c on a.`itemid` = c.id and c.isactive = 1 
left join m_units d on c.units = d.id  and d.isactive = 1 
left join t_requesitionhead e on a.`RSIcode` = e.risno and e.isactive =1 
left join t_rsmidetails f on e.id = f.rsiid 
where f.codes = '$mydata'
group by stockno
";
$qrysum = mysqli_query($con,$sqlsum);
while ($rowsum = mysqli_fetch_array($qrysum)) {
    echo '<tr>
            <td class="rightleft myalign" width="10%"></td>
            <td class="rightleft myalign">'.$rowsum['stockno'].'</td>
            <td class="rightleft myalign">'.$rowsum['qty'].'</td>
            <td class="rightleft myalign" width="10%"></td>
            <td class="rightleft myalign" width="10%"></td>  
            <td class="rightleft myalign" ></td>
            <td class="rightleft myalign"></td>
            <td class="rightleft myalign"></td>
        </tr>';
}

$sqlprep = "
Select  completename,position from t_rsmi x 
left join 
    (SELECT 
userid,
upper(concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname)) completename,a.position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 ) ff on x.createdby = ff.userid 
where rsmicode = '$mydata'";
  $qryprep = mysqli_query($con,$sqlprep);
  $arrprep = mysqli_fetch_array($qryprep);
  $arrname = $arrprep['completename'];
  $arrpos = $arrprep['position'];
   
echo '<tr>
      <td colspan="4" class="printbox" >
       <center> <span style="margin-left:10px;margin-top:0px; position:fix;">
        I hereby certify the correctness of the above information.<br/><br/><br/>
        
               <span> __________<u>'.$arrname.'</u>_____________</span><br/>
                    '.$arrpos.'
        </span> </center>
      </td>
      <td colspan="4" class="printbox" ><br/><p style="margin-left:10px;margin-top:0px; position:fix;">Posted by:</p><br/><br/>
      <table>
          <tr>
          <td style="width:70%"><center>____________________________</center></td>
          <td  style="width:30%"><center>__________________</center></td>
          </tr>
          <tr>
          <td><center>Signature over Printed Name of <br/>Designated Accounting Staff</center></td><td><center>Date</center></td>
          </tr>
      </table>
          </td>
      </tr>'
        ?>

    </table>
  </div>
</div>

