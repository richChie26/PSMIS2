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
$completename = $aarres['completename'];
$editbtnid = $_GET['editbtnid'];
$txtEntity = $_GET['txtEntity'];
$txtfundcluster = $_GET['txtfundcluster'];
$txtproperty3 = $_GET['txtproperty3'];
$txtsimeitem3 = $_GET['txtsimeitem3'];
$txtsemidesc = $_GET['txtsemidesc'];


?>
<div class="row">
  <div class="cols-xs-8"></div>
  <div class="cols-xs-2"> <i> <span style="float:right;padding:20px;">Appendix 69</span></i></div>
</div>
<div class="row" >
   <div class="col-xs-3">
    <img src="img/Logo.bmp" id="imglogoheader">
  <!-- <div id="imglogoheader"></div> -->
  </div>
   <div class="col-xs-5"><b><center>Republic of the Philippines</center></b>        
      <b><center>Department of Environment and Natural Resources</center></b> 
      <b><center><?php echo $ResponsibilityCenter; ?></center></b>    <br/>     
      <center><h5><b>PROPERTY CARD</b></h5> </center>
    </div>
  
</div>

<br/>
<div class="row">
  <div class="col-xs-6"><p><b>Entity Name:</b> <u>PENRO Isabela</u></p> </div>
<div class="col-xs-6"><p> <b>Fund Cluster: </b><u><?php echo $txtfundcluster; ?></u></p></div>
</div>


  <div class="row ">
         <div class="col-xs-12">
          
             <table  class="table table-striped printbox" style="width:100%;padding:0px;margin:0px;">
               <!-- <thead> -->
               <thead style="background-color: #337ab7;color:white;padding: 0px;">
               
               <tr >

           


<td  class="printbox" colspan="5">Property, Plant and Equipment :<u><?php echo $txtsimeitem3; ?></u></td>




<td  colspan="3">Property Number :<u><?php  echo $txtproperty3;?></u></td>


</tr>


<tr >

           


<td  class="printbox" colspan="5">Description :<u><?php echo $txtsemidesc; ?></u></td>
<td class="printbox" colspan="3"></td>

</tr>
               
               
               <tr style="text-align:center;font-weight: bold;" >

           


                    <td rowspan="2"  class="printbox">Date</td>
                    <td rowspan="2"    class="printbox">Reference</td>
                    <td class="printbox">Receipt</td>
                    <td  class="printbox"colspan="2">Issue/Transfer/ Disposal</td>
                   
                    <td class="printbox">Balance</td>
                    <td  rowspan="2"   class="printbox" >Amount </td>
                     <td rowspan="2"   class="printbox" >Remarks </td>
                  
                </tr>
                 <tr style="text-align:center;font-weight: bold;">
                  <!-- <td class="printbox"></td> -->
                  <!-- <td class="printbox"></td> -->
                  <td class="printbox">Qty</td>
                  <td class="printbox">Qty</td>
                   <td class="printbox">Office</td>
                  
                   <td class="printbox">Qty</td>
                   <!-- <td class="printbox"></td>
                   <td class="printbox"></td> -->
                                   </tr>
              </thead>
                <tbody id="scdetails" >
                  
                  <?php
$txtproperty3 = $_GET['txtproperty3'];
$sql = "
select * from ( Select deliveryNumber,
 creationdate dd 
 , date_format(deliverydate, '%m-%d-%Y')  deliverydate, 
  Oname,
  Remarks
,format( (SELECT f.`amount` FROM `t_equipmentdeliverydetails` f  
WHERE f.isactive = 1 and f.`propertyno` = '$txtproperty3' ),2) amount,
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
,case when Tag = 'Del' then
 '1'
when Tag = 'PAR' then
'2'
when Tag = 'return' then 
'3'
when Tag = 'transfer' then   
'4'
end newtag
from  ( SELECT  concat('DR - ',deliveryNumber) deliveryNumber ,deliverydate,'Del' Tag, 'Serviceable' Remarks  ,
(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  
left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = a.createdby) Oname
 ,a.creationdate
FROM `t_equipmentdeliverydetails` a 
left join t_equipmentdeliveryheader b on a.`deliverycode`  = b.deliverycode and b.isactive = 1 
where a.isactive = 1  and `propertyno` = '$txtproperty3'

union all

SELECT  concat('PAR - ', x.PARNO),Dateissue, 'PAR' ,'Serviceable'
,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  

left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = yi.receivedby )
,yi.creationdate
FROM `t_pardetails` x 
left join t_par yi on x.`parno` = yi.`parno` and yi.isactive = 1 
where `propertyno` = '$txtproperty3'
and x.tag = 0
union all

SELECT  concat(
     case when f.condition  = 'For Disposal' or f.condition  = 'For Repair'  or f.condition  = 'Serviceable' then 
     'CM - '
     else 'IIRUP - ' end 
    , f.`rcode`),datereturn ,'return'  ,concat( f.condition,  ' - ', f.remarks )
,(SELECT concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`)  FROM `u_profile` t  
left join a_user y on t.`profileid` = y.`profileid` and y.isactive =1 
where y.isactive = 1 and y.userid = (SELECT yii.`createdby`


FROM `t_pardetails` xi 
left join t_par yii on xi.`parno` = yii.`parno` and yii.isactive = 1 
where xi.`propertyno` = '$txtproperty3'
and xi.tag = 0 order by xi.id desc limit 1 
))  ,g.creationdate
FROM `t_returndetails` f 
left join t_returns g on f.rcode  = g.rcode and g.isactive = 1 
where `propertyno` = '$txtproperty3' 

union all 

SELECT concat('PTR - ', k.`ptrcode`),datetransfered,'transfer' ,j.condition ,(
    SELECT `ResponsibilityCenter` FROM `a_responsibilitycenter` ss WHERE ss.`id` = transfertoResposibilitycenter
    ) 
    ,k.creationdate
    FROM `t_ptrdetails` j 
left join t_ptrheader k on k.`ptrcode` = j.ptrcode and k.isactive = 1
where `propertyno` = '$txtproperty3'
) chie 

union all 
select 
'',
convert(dateReclass,date) ,
dateReclass,
clientname,
remarks,
amount,
qone,
qtwo,
''
from t_reclass where `propertyno` = '$txtproperty3'
) nuez  order by dd ASC
";


//  echo $sql;
$qry = mysqli_query($con,$sql);
while ( $row= mysqli_fetch_array($qry)) {
echo '<tr class="printbox">
                  <td class="printbox">'.$row['deliverydate'].'</td>
                  <td class="printbox">'.$row['deliveryNumber'].'</td>
                  <td class="printbox">'.$row['qtyin'].'</td>
                  <td class="printbox">'.$row['qtyout'].'</td>
                   <td class="printbox">'.$row['Oname'].'</td>
                  
                   <td class="printbox">'.$row['qtyin'].'</td>
                   <td class="printbox">
                   '.$row['amount'].'
                   </td> <td class="printbox"></td>
                                   </tr>';  
}

                  ?>
                </tbody>
             </table>
       
         </div>
    </div>
