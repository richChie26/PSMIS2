<style>

.printbox{
  border-style: solid;
  border-color: black;
  border-width: 1px;
}

@media print {
    a[href]:after {
        content: none !important;
    }
}
</style>

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
$completename = $aarres['completename'];
$editbtnid = $_GET['editbtnid'];
$txtstocknosc = $_GET['txtstocknosc'];
$txtitemsc = $_GET['txtitemsc'];
$txtdescription3 = $_GET['txtdescription3'];
$txtunits = $_GET['txtunits'];
$txtreorder = $_GET['txtreorder'];
$rid = $aarres['rid'];
$sqlfund = "SELECT Fundcategory  FROM `t_itemreceived`  a 
left join t_receivedheader b on a.`transcode` = b.transcode and b.isactive = 1 
left join m_fundcluster c on b.sourceoffund = c.id and c.isactive = 1 
where a.isactive = 1
and `ResponsibilityCenter` = $rid and a.itemid = $editbtnid 
";

$qryfund = mysqli_query($con,$sqlfund);
$arrfund = mysqli_fetch_array($qryfund);
$Fundcategory = $arrfund['Fundcategory'];
?>
<div class="row">
  <div class="cols-xs-8"></div>
  <div class="cols-xs-2"> <i> <span style="float:right;padding:20px;">Appendix 58</span></i></div>
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
<b><center><?php echo $ResponsibilityCenter; ?></center></b>     <br/>    
<center><h5><b>STOCK CARD</b></h5> </center>
</div>
   <div class="col-xs-2"></div>
</div>

<br/>
<div class="row">
  <div class="col-xs-6 "><span style="font-weight:bold;">Entity Name:</span> <u><?php echo $ResponsibilityCenter; ?></u> </div>
  <div class="col-xs-6"><span style="font-weight:bold; " >Fund Cluster:</span> <u><?php echo $Fundcategory; ?></u></div>

</div>
<br/>

      <div class="row">
         <div class="col-xs-12">
           <div >
             <table  class="table table-striped" cellspacing="0" cellpadding="0">
               <!-- <tdead> -->
             
              
               <thead style="background-color: #337ab7;color:white;padding: 0px;">
                
               <tr class="printbox">
                    <td colspan="5"  class="printbox"> Item Name: <?php echo  $txtitemsc; ?></td>
                    <td colspan="2" class="printbox">Stock No: <?php echo $txtstocknosc ; ?></td>
                </tr><tr><td colspan="5" class="printbox">Description: <?php echo $txtdescription3; ?></td>
                    <td colspan="2" class="printbox">Re-order Point: <?php echo $txtreorder; ?></td>
                </tr><tr>
                    <td colspan="5" class="printbox">Unit of Measurement: <?php echo $txtunits ; ?></td>
                    <td colspan="2" class="printbox"></td>
              </tr>
               
               <tr style="font-weight:bold;">


                    <td  class="printbox" rowspan="2"><center>Date</center></td>
                    <td  class="printbox" rowspan="2"><center>Reference</center></td>
                    <td class="printbox" ><center>Receipt</center></td>
                    <td  class="printbox" colspan="2"><center>Issue</center></td>
                   
                    <td class="printbox" ><center>Balance</center></td>
                    <td class="printbox"  rowspan="2" ><center>No. of Days to Consume</center></td>
                  
                </tr> <tr>
                  
                  
                  <td class="printbox" ><center>Qty</center></td>
                  <td class="printbox" ><center>Qty</center></td>
                   <td class="printbox" ><center>Office<c/enter></td>
                  
                   <td class="printbox" ><center>Qty</center></td>
                   
                                   </tr>
              </thead>
                <tbody id="scdetails">
                  <?php
$sql3 = "Select * from (SELECT   concat('DR-',b.receiptno) receiptno, date_format(b.`datereceived`, '%m-%d-%Y') cd, 1 tag, `qty` rqty, '' iss ,

format(`bal`,0) bal ,a.creationdate   FROM `t_itemreceived`  a
  left join t_receivedheader b on a.transcode = b.transcode and b.isactive = 1          
               WHERE 
`itemid`  = $editbtnid  and  `ResponsibilityCenter`  = $rid
union all 

SELECT   x.`RSIcode`,date_format(dateissued, '%m-%d-%Y') ,2, '', approvedqty,format(bal,0) ,dateapproved  FROM `t_requisitiondetails` x
left join t_requesitionhead y on x.`RSIcode` = y.risno
where y.isactive = 1 and x.status !='Pending'
and `itemid` = $editbtnid and  `ResponsibilityCenter` = $rid
) a order by creationdate ASC
";


$qry3 = mysqli_query($con,$sql3);
while ( $row= mysqli_fetch_array($qry3)) {
echo '<tr>
                  <td class="printbox"><center>'.$row['cd'].'</center></td>
                  <td class="printbox">'.$row['receiptno'].'</td>
                  <td class="printbox"><center>'.$row['rqty'].'</center></td>
                  <td class="printbox"><center>'.$row['iss'].'</center></td>
                   <td class="printbox"></td>
                   <td class="printbox"><center>'.$row['bal'].'</center></td>
                  
                  
                   <td class="printbox"></td>
                                   </tr>';  
}



                  ?>

                </tbody>
             </table>
           </div>
         </div>
    </div>

    <!-- <div class="row">
        <div class="col-xs-3">
            Prepared By: 
            <br/>
        
        </div>
    </div> -->