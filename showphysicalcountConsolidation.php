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

    echo '<br/>
    <div class="row">
    <div class="col-xs-12">
    <button class="btn btn-primary" style="float:right" id="btnsavephisical">Submit</button>
        </div></div>
<br>
<div class="row">
  <div class="col-xs-12">
    <table class = "table">
      <tr style="background-color: #337ab7;color:white;text-align:center;">

       
       <td></td>
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
   
   where c.`createdBy` = $uid  and datereport = '$dtpReportDate' and ifnull(c.code,'') != ''";
    

    $sqlbb = mysqli_query($con,$sqldataa);
    while($row = mysqli_fetch_array($sqlbb)){
        $id =$row['id'];
        echo '<tr id="row'.$id.'">
        <td>
        <input name="selector[]" id="ad_Checkbox1" class="ads_Checkbox" 
									type="checkbox" value="'.$row['id'].'" />
        </td>
        <td style="text-align:center;">'.$row['item'].'</td>
        <td style="text-align:center;">'.$row['description'].'</td>
        <td style="text-align:center;">'.$row['stockno'].'</td>
        <td style="text-align:center;">'.$row['units'].'</td>
        <td style="text-align:right;"><span >'.$row['ave'].'</span></td>
        <td style="text-align:center;"><span id="lblpercard'.$id.'"> '.$row['Total'].'</span></td>
        <td style="text-align:center;">  <span size="5"  >'.$row['qty'].'</span>   </td>
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


