<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$mydata  = $_GET['arr'];
$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename,a.Position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$positon = $aarres['Position'];
$completename  = $aarres['completename'];
$rid = $aarres['rid'];

$sqlko = "
SELECT a.`rcode`, date_format( `datereturn`, '%M %d, %Y ') datereturn, `lastpar`, a.`tag`,
 cname returnby,office ,b.ResponsibilityCenter,section ,c.propertyno 
,c.remarks
,eu.description ,mu.units, format(eu.amount,2) Amount,c.condition
FROM `t_returns` a  

left join t_returndetails c on a.rcode = c.rcode 

left join t_equipmentdeliverydetails eu  on  c.propertyno = eu.propertyno and eu.isactive =1 
LEFT join m_equipent me on eu.itemid = me.id and me.isactive = 1 
left join m_units mu on me.unitofmeasurement = mu.id and mu.isactive =1 


left join 
(SELECT userid
,z.ResponsibilityCenter,xy.section,
concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname,office

FROM `a_user`  x
left join u_profile y on x.`profileid`=  y.`profileid` and y.isactive =1 
left join a_responsibilitycenter z on y.ResponsibilityCenter = z.id and z.isactive =1  
left join a_section xy  on y.section = xy.id and xy.isactive =1 

) b on a.returnby = b.userid 


where a.rcode = '$mydata'";
$qryko = mysqli_query($con,$sqlko);
$arrko = mysqli_fetch_array($qryko);
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
<b><center><?php echo $ResponsibilityCenter; ?></center></b>         <br>
<center><h5><b>CREDIT MEMO ON PROPERTY ACCOUNTABILITY</b></h5> 

<br/> 
</center>
  </div>


</div>
<div class ="row">
  <div class="col-xs-6">
    <b>Property Number.:</b> <?php echo $arrko['propertyno'] ;?>

  </div>
  <div class="col-xs-5"><div style="float:right"><b> Date Returned :</b>  <?php echo $arrko['datereturn'] ;?></div> </div>
</div>
<div class ="row">
  <div class="col-xs-4">
    <b>Credit Memo No.: </b><?php echo  $arrko['rcode']; ?>

  </div>
 
</div> <br/>
<div class ="row">
  <div class="col-xs-11">
    I hereby certify that <b><u>  <?php echo  $arrko['returnby']; ?> </u></b>  of <b><u>  <?php echo $arrko['ResponsibilityCenter'] . " "; ?> </u></b> has been relieved of Property/Accountability mentioned below. 
    <table style="border: black solid 1px; " class="table " border="1">
      <tr >
        <th style="border: 1px solid black;" >QTY</th>
        <th style="border: 1px solid black;" >UNIT</th>
        <th style="border: 1px solid black;" >DESCRIPTION</th>
        <th style="border: 1px solid black;" >PROPERTY NO.</th>
        <th style="border: 1px solid black;" >AMOUNT</th>
        
      </tr>
      <tr style="height:280px; border: black solid 1px; ">
       
      <td style="border: 1px solid black;">1</td>
        <td style="border: 1px solid black;"> <?php  
        
        $sql1 = "
        SELECT a.`rcode`, `datereturn`, `lastpar`, a.`tag`, cname returnby,office ,b.ResponsibilityCenter,section ,c.propertyno 
        
        ,eu.description ,mu.units, format(eu.amount,2) Amount
        FROM `t_returns` a  
        
        left join t_returndetails c on a.rcode = c.rcode 
        
        left join t_equipmentdeliverydetails eu  on  c.propertyno = eu.propertyno and eu.isactive =1 
        LEFT join m_equipent me on eu.itemid = me.id and me.isactive = 1 
        left join m_units mu on me.unitofmeasurement = mu.id and mu.isactive =1 
        
        
        left join 
        (SELECT userid
        ,z.ResponsibilityCenter,xy.section,
        concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname,office
        
        FROM `a_user`  x
        left join u_profile y on x.`profileid`=  y.`profileid` and y.isactive =1 
        left join a_responsibilitycenter z on y.ResponsibilityCenter = z.id and z.isactive =1  
        left join a_section xy  on y.section = xy.id and xy.isactive =1 
        
        ) b on a.returnby = b.userid 
        
        
        where a.rcode = '$mydata'";
        $qry1 = mysqli_query($con,$sql1); 
        while($row = mysqli_fetch_array($qry1)){

echo $row['units'];

}
?>

</td>
        <td style="border: 1px solid black;" > <?php  
        
        $sql2 = "
        SELECT a.`rcode`, `datereturn`, `lastpar`, a.`tag`, cname returnby,office ,b.ResponsibilityCenter,section ,c.propertyno 
        
        ,
        
        
        concat(
          `description`,', ' ,  Serial ,', ', chasisnumber   )  description  ,mu.units, format(eu.amount,2) Amount
        FROM `t_returns` a  
        
        left join t_returndetails c on a.rcode = c.rcode 
        
        left join t_equipmentdeliverydetails eu  on  c.propertyno = eu.propertyno and eu.isactive =1 
        LEFT join m_equipent me on eu.itemid = me.id and me.isactive = 1 
        left join m_units mu on me.unitofmeasurement = mu.id and mu.isactive =1 
        
        
        left join 
        (SELECT userid
        ,z.ResponsibilityCenter,xy.section,
        concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname,office
        
        FROM `a_user`  x
        left join u_profile y on x.`profileid`=  y.`profileid` and y.isactive =1 
        left join a_responsibilitycenter z on y.ResponsibilityCenter = z.id and z.isactive =1  
        left join a_section xy  on y.section = xy.id and xy.isactive =1 
        
        ) b on a.returnby = b.userid 
        
        
        where a.rcode = '$mydata'";
        $qry2 = mysqli_query($con,$sql2); 
        while($row = mysqli_fetch_array($qry2)){

echo $row['description'];

}
?>

</td>
        <td style="border: 1px solid black;">   <?php  
        
        $sql1 = "
        SELECT a.`rcode`, `datereturn`, `lastpar`, a.`tag`, cname returnby,office ,b.ResponsibilityCenter,section ,c.propertyno 
        
        ,eu.description ,mu.units, format(eu.amount,2) Amount
        FROM `t_returns` a  
        
        left join t_returndetails c on a.rcode = c.rcode 
        
        left join t_equipmentdeliverydetails eu  on  c.propertyno = eu.propertyno and eu.isactive =1 
        LEFT join m_equipent me on eu.itemid = me.id and me.isactive = 1 
        left join m_units mu on me.unitofmeasurement = mu.id and mu.isactive =1 
        
        
        left join 
        (SELECT userid
        ,z.ResponsibilityCenter,xy.section,
        concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname,office
        
        FROM `a_user`  x
        left join u_profile y on x.`profileid`=  y.`profileid` and y.isactive =1 
        left join a_responsibilitycenter z on y.ResponsibilityCenter = z.id and z.isactive =1  
        left join a_section xy  on y.section = xy.id and xy.isactive =1 
        
        ) b on a.returnby = b.userid 
        
        
        where a.rcode = '$mydata'";
        $qry1 = mysqli_query($con,$sql1); 
        while($row = mysqli_fetch_array($qry1)){

echo $row['propertyno'];

}
?></td>
        <td style="border: 1px solid black;" > 
        <?php  
        
        $sql1 = "
        SELECT a.`rcode`, `datereturn`, `lastpar`, a.`tag`, cname returnby,office ,b.ResponsibilityCenter,section ,c.propertyno 
        
        ,eu.description ,mu.units, format(eu.amount,2) Amount
        FROM `t_returns` a  
        
        left join t_returndetails c on a.rcode = c.rcode 
        
        left join t_equipmentdeliverydetails eu  on  c.propertyno = eu.propertyno and eu.isactive =1 
        LEFT join m_equipent me on eu.itemid = me.id and me.isactive = 1 
        left join m_units mu on me.unitofmeasurement = mu.id and mu.isactive =1 
        
        
        left join 
        (SELECT userid
        ,z.ResponsibilityCenter,xy.section,
        concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname,office
        
        FROM `a_user`  x
        left join u_profile y on x.`profileid`=  y.`profileid` and y.isactive =1 
        left join a_responsibilitycenter z on y.ResponsibilityCenter = z.id and z.isactive =1  
        left join a_section xy  on y.section = xy.id and xy.isactive =1 
        
        ) b on a.returnby = b.userid 
        
        
        where a.rcode = '$mydata'";
        $qry1 = mysqli_query($con,$sql1); 
        while($row = mysqli_fetch_array($qry1)){

echo $row['Amount'];

}
?>


        </td>
      
      </tr>
      <tr>
        <td colspan="5" style="border: 1px solid black;">
      <div class="row" >
      <div class="col-xs-4"><b> TOTAL</b></div>
      <div class="col-xs-8">
        <div style="float:right;">
        <b>
        <?php 
        
        $sqlkoo = " SELECT a.`rcode`, `datereturn`, `lastpar`, a.`tag`, cname returnby,office ,b.ResponsibilityCenter,section ,c.propertyno 
        
        ,eu.description ,mu.units, format( sum(eu.amount),2) Amount
        FROM `t_returns` a  
        
        left join t_returndetails c on a.rcode = c.rcode 
        
        left join t_equipmentdeliverydetails eu  on  c.propertyno = eu.propertyno and eu.isactive =1 
        LEFT join m_equipent me on eu.itemid = me.id and me.isactive = 1 
        left join m_units mu on me.unitofmeasurement = mu.id and mu.isactive =1 
        
        
        left join 
        (SELECT userid
        ,z.ResponsibilityCenter,xy.section,
        concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname,office
        
        FROM `a_user`  x
        left join u_profile y on x.`profileid`=  y.`profileid` and y.isactive =1 
        left join a_responsibilitycenter z on y.ResponsibilityCenter = z.id and z.isactive =1  
        left join a_section xy  on y.section = xy.id and xy.isactive =1 
        
        ) b on a.returnby = b.userid 
           where a.rcode = '$mydata'";
           $qrykooooo = mysqli_query($con,$sqlkoo);

           while($newrow = mysqli_fetch_array($qrykooooo)){

            echo '<p style="float:right;">'. $newrow['Amount'] .'</p>';
           }
        ?>
        </b>
        </div>
  </div>
</div> 
        </td>
      </tr>
    <tr style=" border-top: 1px solid black;">
    <td colspan="3" style=" border-right: 1px solid black;"> 
    <table width="100%"> <tr> 
    <td  ><b>CONDITION </b> &nbsp;&nbsp; <?php       echo $arrko['condition'];    ?> 
    <br/>
  </td>
    </tr>
    <tr> 
    <td style=" border-top: 1px solid black;" ><b>REMARKS  </b> &nbsp;&nbsp;&nbsp;&nbsp; <?php       echo $arrko['remarks'];    ?> 
  

  </td>
    </tr>
  </table>  
    <hr style=" border-top: 1px solid black;"/>
      <table>
        <tr><td>Index By </td><td>______________________</td></tr>
        <tr><td>Checked By </td><td>______________________</td></tr>
        <tr><td>Received By </td><td>______________________</td></tr>

      </table>
      <br/>
      Original Copy: Accountable Personnel <br/>
      Duplicate Copy: Property Custodian Section File<br/>
      Triplicate Copy: Accountable Persons's File Folder<br/>
      Fourth Copy: Disposal Committee(For userviceable property only)


     </td>
  
  
    
    <td colspan="2"><br/><br/><br/><br/><br/><br/> <i>Certified Correct:</i>
  
  
    <br/><br/> <?php 
    $sqlsig = " SELECT a.`rcode`, `datereturn`, `lastpar`, a.`tag`, position ,cname returnby,office ,b.ResponsibilityCenter,section ,c.propertyno 
        
    ,eu.description ,mu.units, format( sum(eu.amount),2) Amount
    FROM `t_returns` a  
    
    left join t_returndetails c on a.rcode = c.rcode 
    
    left join t_equipmentdeliverydetails eu  on  c.propertyno = eu.propertyno and eu.isactive =1 
    LEFT join m_equipent me on eu.itemid = me.id and me.isactive = 1 
    left join m_units mu on me.unitofmeasurement = mu.id and mu.isactive =1 
    
    
    left join 
    (SELECT userid
    ,z.ResponsibilityCenter,xy.section,position,
    concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname,office
    
    FROM `a_user`  x
    left join u_profile y on x.`profileid`=  y.`profileid` and y.isactive =1 
    left join a_responsibilitycenter z on y.ResponsibilityCenter = z.id and z.isactive =1  
    left join a_section xy  on y.section = xy.id and xy.isactive =1 
    
    ) b on a.createdby = b.userid 
       where a.rcode = '$mydata'";
$qryret = mysqli_query($con,$sqlsig);

$arrsig = mysqli_fetch_array($qryret);

echo $arrsig['returnby'] . '<br/>'; 
echo $arrsig['position']; 

    ?>
  </td>
  </tr>  
    </table>
  </div>

</div>


