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

$rid = $aarres['rid'];

$optcount = $_GET['optcount'];

$dtpReportDate = $_GET['dtpReportDate'];

$selPhysical = $_GET['selPhysical'];
$selsource1 = $_GET['selsource'];


$sqlpppp = "SELECT `id` FROM `m_fundcluster` WHERE `Fundcategory` ='$selsource1' and isactive = 1 ";
$qrypppp = mysqli_query($con,$sqlpppp);
$selsource = 0 ;
while($rro = mysqli_fetch_array($qrypppp)){
    $selsource = $rro['id'];
}



if($selPhysical  = 1 ){

    $sqldata = " select * from (select *

    ,case when (SELECT count(id) FROM `a_responsibilitycenter` WHERE `isactive` = 1 
    and `ResponsibilityCenter` != 'Others')  = 
    (select  count(f.itemid)   from  t_tempitemcount f where f.createdBy = $uid and  f.itemid = ss.id and 
    convert(datereport,date) = convert('$dtpReportDate',date) ) then 
     'Pass'
     else 'Failed'
    end Pass

     ,format( 
    
        
             
        ifnull((
            select sum(f.shorttage) qty   from  t_tempitemcount f where f.createdBy = $uid and  f.itemid = ss.id  
            and 
            convert(datereport,date) = convert('$dtpReportDate',date) 
        ),'')  * 
            cost 
        
        ,2) netotave
     ,ifnull((
        select sum(f.qty) qty   from  t_tempitemcount f where f.createdBy = $uid and  f.itemid = ss.id  and 
        convert(datereport,date) = convert('$dtpReportDate',date)  ),'') totcount
    
    ,ifnull((
        select  sum(shorttage) shorttage from  t_tempitemcount   f where f.createdBy = $uid and  itemid = ss.id 
        and 
        convert(datereport,date) = convert('$dtpReportDate',date) ),'') totaves
    
    from (select *, 0  tag

    ,ifnull((SELECT `itemid` FROM `t_tempvaldel`  where `itemid`= xx.id   and  `userid`  =  $uid ),0) newtags
    
   
    from (SELECT `item`, `stockno`,b.units, `description` , 
    
    (SELECT  format(`ave`,2) amount FROM `t_itemreceived` xc left join t_receivedheader cx on xc.transcode =
     cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1 and 
     fundSource =   $selsource
     and xc.`itemid` = a.id and cx.datereceived <= '$dtpReportDate' 
     order by cx.id desc  limit 1 )
     
     
     cost,
   
     
     ( ifnull(
         (SELECT sum(`qty`) FROM `t_itemreceived` xc left join t_receivedheader cx on 
         xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1  and 
         xc.`itemid` = a.id and convert( cx.datereceived,date) <= convert('$dtpReportDate',date) ) ,0) - 
         ifnull((SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s left join 
         t_requesitionhead xs on s.rsicode = xs.risno WHERE s.`itemid` = a.id and convert(dateapproved,date) 
         <= convert('$dtpReportDate',date) and s.status = 'Approved' ) ,0) ) qtyres 
         ,a.id FROM 
         `m_materials` a left join m_units b on a.`units` = b.id and b.isactive = 1 where a.isactive = 1 and 
         `titleid` = 1 ) xx where ifnull(cost,0) != 0

    union all 
    SELECT `itemname`,itemno, unit,  `description` ,  `cost`, `qty`, `itemid`
    
    
     ,ifnull((select id from (SELECT `item`, `stockno`,b.units, `description` ,
      (SELECT format(`ave`,2) amount FROM `t_itemreceived` xc left join t_receivedheader cx 
      on xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1 and 
      fundSource =   $selsource 
      and xc.`itemid` = a.id and cx.datereceived <= '$dtpReportDate'
      order by cx.id desc  limit 1
      ) cost,

 
       ( ifnull( (SELECT sum(`qty`) FROM `t_itemreceived` xc left join t_receivedheader cx on 
       xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1  
       and xc.`itemid` = a.id and convert( cx.datereceived,date) <= convert('$dtpReportDate',date) ) ,0) - 
       ifnull((SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s 
       left join t_requesitionhead xs on s.rsicode = xs.risno WHERE s.`itemid` = a.id 
       and convert(dateapproved,date) <= convert('$dtpReportDate',date) and s.status = 'Approved'
        
       ) ,0) ) qtyres ,a.id FROM `m_materials` a left join m_units b on a.`units` = 
       b.id and b.isactive = 1 where a.isactive = 1 and `titleid` = 1 
       ) xx where ifnull(cost,0) != 0  and id = ff.`itemid`),0)
    
    ,ifnull((SELECT `itemid` FROM `t_tempvaldel`  where `itemid`= ff.itemid   and  `userid`  =  $uid ),0)
    FROM `t_temprpci` ff  WHERE `resposibilityid` = $rid  and  `createdby` =  $uid 
    ) ss where  newtags = 0 ) xxxx where Pass ='Failed'
     order by cost DESC ";
    //   echo $sqldata ;
$qrydata = mysqli_query($con,$sqldata);
//    echo $sqldata ;
echo '<div class="table-responsive"><table class="table table-stripped responsive">
<tr style="background-color: #337ab7;color:white;text-align:center;">
    <td>Article</td>
    <td>Description</td>
    <td>Stock No.</td>
    <td>Unit of Measurement</td>
    <td>Unit Cost</td>
    <td>Balance Per Card</td>
    <td>On Hand Per Count</td>
    <td>Shortage/Overage</td>
    <td></td>
    <td><center>Remarks</center></td>
    <td></td>
</tr>
<tr  style="background-color: #337ab7;color:white;text-align:center;">
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
    <td><center>Delete</center></td>
</tr>
<tbody id="tblrpci">';
while ($row = mysqli_fetch_array($qrydata)) {
    $id = $row['id'];

    $qtyres = $row['qtyres'];
    if($row['cost'] == ""){
        $sss = "";
    }else{
    $sss =	$row['cost'];
    // '<span>&#8369;</span>'
    }
$sqlglue = "SELECT itemid FROM `t_temprpcdetail` WHERE `itemid` = $id and `resid` =$rid and `createdBy` = $uid  ";

$qrytemps = mysqli_query($con,$sqlglue);
if(mysqli_num_rows($qrytemps)==0){
$sqlclimb = "insert into  `t_temprpcdetail`(`itemid`, `resid`, `createdBy`, `cost`, `bal`, `rpcidate`)
values($id,$rid,$uid,$sss,$qtyres,'$dtpReportDate')
";
mysqli_query($con,$sqlclimb);
}


echo '<tr id="row'.$id.'">
        <td style="text-align:center;">'.$row['item'].'</td>
        <td style="text-align:center;">'.$row['description'].'</td>
        <td style="text-align:center;">'.$row['stockno'].'</td>
        <td style="text-align:center;">'.$row['units'].'</td>
        <td style="text-align:right;"><span id="lblmycost'.$id.'">'.$sss.'</span></td>
        <td style="text-align:center;"><span id="lblpercard'.$id.'"> '.$row['qtyres'].'</span></td>
        <td>  <input type="number" size="5" style="text-align:center" value="'.$row['totcount'].'" class="txtbpccount" id="lblcount'.$id.'|'.$id.'|'. $row['qtyres'].'|'. $row['cost'].'"/>  </td>
        <td style="text-align:center;"> <span class="lblcount'.$id.'"> '.$row['totaves'].' </span>  </td>
        <td style="text-align:center;"><span class="lblave'.$id.'">'.$row['netotave'].'</span></td>
        <td> <input type="text" size="5"  class="txtremarks" id="lblremarks'.$id.'|'.$id.'"/> </td>
        <td style="text-align:center;"><center><a href="#" class ="btnremovesel" id="btn'.$id.'|'.$id.'"><span style="color:red;" class="glyphicon glyphicon-minus"></span></a></center></td>
        </tr>';

}

echo '</tbody>
</table>
</div><br />
<div class="row">
  <div class="col-xs-6">
    <button class="btn btn-primary" id="btnaddrow">Add Item</button>
  </div>
  <div class="col-xs-6">
    <button class="btn btn-primary" id="btnsaverppc" style="float:right;">Submit</button>
  </div>
</div>
<br>
<div class="row">
  <div class="col-xs-12">
    <table class = "table">
      <tr style="background-color: #337ab7;color:white;text-align:center;">

       
       
        <td>Article</td>
        <td>Description</td>
        <td>Stock No.</td>
        <td>Unit of Measurement</td>
        <td>Unit Cost</td>
        <td>Balance Per Card</td>
        <td>On Hand Per Count</td>
        <td>Shortage/Overage</td>
        <td></td>
        <td>
          <center>Remarks</center>
        </td>

      </tr>
      
      <tr  style="background-color: #337ab7;color:white;text-align:center;">
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
      ';
      
    $sqldataa ="
    SELECT c.`itemid` id, ResponsibilityCenter,`item`,stockno, b.units,  a.`description` ,
    `datereport`,sum(`qty`) qty , sum(`shorttage`) shorttage, `Total`, format(sum(`shorttage`) *  `ave`,2) totalave,ave
  FROM 
  t_tempitemcount c 
  left join `m_materials` a on c.`itemid`  = a.id 
  
  left join m_units b on a.`units` = 
         b.id and b.isactive = 1
   left join a_responsibilitycenter d on c.`rid` = d.id and d.isactive =1 
   
   where c.`createdBy` = $uid  and datereport = '$dtpReportDate' and ifnull(c.code,'') = ''";
    

    $sqlbb = mysqli_query($con,$sqldataa);
    while($row = mysqli_fetch_array($sqlbb)){
        $id =$row['id'];
        echo '<tr id="row'.$id.'">
        <td style="text-align:center;">'.$row['item'].'</td>
        <td style="text-align:center;">'.$row['description'].'</td>
        <td style="text-align:center;">'.$row['stockno'].'</td>
        <td style="text-align:center;">'.$row['units'].'</td>
        <td style="text-align:right;"><span >'.$row['ave'].'</span></td>
        <td style="text-align:center;"><span id="lblpercard'.$id.'"> '.$row['Total'].'</span></td>
        <td>  <input type="number" size="5" style="text-align:center" value="'.$row['qty'].'" class="txtbpccount" id="lblcount'.$id.'|'.$id.'|'. $row['Total'].'|'. $row['ave'].'"/>  </td>
        <td style="text-align:center;"> <span class="lblcount'.$id.'"> '.$row['shorttage'].' </span>  </td>
        <td style="text-align:center;"><span class="lblave'.$id.'">'.$row['totalave'].'</span></td>
        <td> <input type="text" size="5"  style="display:none" class="txtremarks" id="lblremarks'.$id.'|'.$id.'"/> </td>
       
        </tr>';

    }
   echo    '</table>
  </div>
</div>
';

}elseif($selPhysical  = 2 )
{

}elseif($selPhysical  = 3 ){

}
?>


