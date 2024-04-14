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
$propertyid = $_GET['propertyid'];
$txtproperty4 = $_GET['txtproperty4'];
$txtsimeitem4 = $_GET['txtsimeitem4'];
$txtsemidesc = $_GET['txtsemidesc'];
$txtfundcluster = $_GET['txtfundcluster'];


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
<center><h5><b>Semi-Expendable Card</b></h5> </center>
</div>
   <div class="col-xs-2"></div>
</div>

<br/>
<div class="row">
  <div class="col-xs-8"><p style="font-weight:bold;">Entity Name: <u>Penro Isabela</u></p> </div>
<div class="col-xs-3"><p style="font-weight:bold;">Fund Cluster: <u><?php echo $txtfundcluster; ?></u></p></div>
</div>
<div class="row">
  <div class="col-xs-8">SemiExpendable :<u><?php echo $txtsimeitem4; ?></u></div>
  <div class="col-xs-3">Property Number :<u><?php  echo $txtproperty4;?></u></div>
</div>



<div class="row">
  <div class="col-xs-8">Description :<u><?php echo $txtsemidesc; ?></u></div>
  <div class="col-xs-3"></div>
</div>

  <div class="row">
         <div class="col-xs-12">
           <div >
             <table  class="table table-striped" cellspacing="0" cellpadding="0">
               <!-- <thead> -->
               <thead style="background-color: #337ab7;color:white;padding: 0px;">
                <tr>

           


                    <th >Date</th>
                    <th >Reference/ PAR No.</th>
                    <th>Receipt</th>
                    <th colspan="2">Issue/Transfer/ Disposal</th>
                   
                    <th>Balance</th>
                    <th >Amount </th>
                     <th >Remarks </th>
                  
                </tr> <tr>
                  <th></th>
                  <th></th>
                  <th>Qty</th>
                  <th>Qty</th>
                   <th>Office</th>
                  
                   <th>Qty</th>
                   <th></th>
                   <th></th>
                                   </tr>
              </thead>
                <tbody id="scdetails">
                  
                  <?php
$txtproperty3 = $_GET['txtproperty4'];
$sql = "Select deliveryNumber,convert(deliverydate,date) deliverydate, Oname,
case when Tag = 'Del' or Tag = 'return'  then
 '1'
 else
  '' 
 end qtyin ,
  
case when Tag = 'PAR' or Tag = 'transfer'  then
 '1'
 else
  '' 
 end qtyout

from  ( SELECT  deliveryNumber ,deliverydate,'Del' Tag,
(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  
left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = a.createdby) Oname

FROM `t_equipmentdeliverydetails` a 
left join t_equipmentdeliveryheader b on a.`deliverycode`  = b.deliverycode and b.isactive = 1 
where a.isactive = 1  and `propertyno` = '$txtproperty3'

union all

SELECT x.PARNO,Dateissue, 'PAR' 
,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  
left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = yi.receivedby)

FROM `t_pardetails` x 
left join t_par yi on x.`parno` = yi.`parno` and yi.isactive = 1 
where `propertyno` = '$txtproperty3'

union all

SELECT  f.`rcode`,datereturn ,'return' 
,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  
left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = (SELECT yii.`receivedby`


FROM `t_pardetails` xi 
left join t_par yii on xi.`parno` = yii.`parno` and yii.isactive = 1 
where xi.`propertyno` = '$txtproperty3')) 
FROM `t_returndetails` f 
left join t_returns g on f.rcode  = g.rcode and g.isactive = 1 
where `propertyno` = '$txtproperty3' 

union all 

SELECT k.`ptrcode`,datetransfered,'transfer',(
    SELECT `ResponsibilityCenter` FROM `a_responsibilitycenter` ss WHERE ss.`id` = transfertoResposibilitycenter
    ) FROM `t_ptrdetails` j 
left join t_ptrheader k on k.`ptrcode` = j.ptrcode and k.isactive = 1
where `propertyno` = '$txtproperty3'
) chie order by deliverydate asc ";



$qry = mysqli_query($con,$sql);
while ( $row= mysqli_fetch_array($qry)) {
echo '<tr>
                  <td>'.$row['deliverydate'].'</td>
                  <td>'.$row['deliveryNumber'].'</td>
                  <td>'.$row['qtyin'].'</td>
                  <td>'.$row['qtyout'].'</td>
                   <td>'.$row['Oname'].'</td>
                  
                   <td></td>
                   <td></td> <td></td>
                                   </tr>';  
}

                  ?>
                </tbody>
             </table>
           </div>
         </div>
    </div>
