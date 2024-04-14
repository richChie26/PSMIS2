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
  $cost =$_GET['cost'];
  $optcount = $_GET['optcount'];
  $dtpReportDate = $_GET['dtpReportDate'];
  $selPhysical = $_GET['selPhysical'];

  $itemid = $_GET['itemid'];
  $selsource1 = $_GET['selsource'];


  $sqlpppp = "SELECT `id` FROM `m_fundcluster` WHERE `Fundcategory` ='$selsource1' and isactive = 1 ";
  $qrypppp = mysqli_query($con,$sqlpppp);
  $selsource = 0 ;
  while($rro = mysqli_fetch_array($qrypppp)){
      $selsource = $rro['id'];
  }

$sqlll = "SELECT `item`, `description`,date_format ('$dtpReportDate', '%M %d, %Y') dtpReportDate FROM `m_materials` where isactive = 1 and `id` = $itemid";
$qrylll = mysqli_query($con,$sqlll);

$itemname ="";
$itemdesc ="";
$itedtpReportDate = "";
while($row = mysqli_fetch_array($qrylll)){
    $itemname = $row['item'];
    $itemdesc = $row['description'];
    $itedtpReportDate = $row['dtpReportDate'];
}



echo '<center><h3>Breakdown of Inventory item Balances</h3>';
echo  'As of ' . $itedtpReportDate.'<br/><br/>';
echo  '<span style="font-size:18px;">'. $itemname  .' '. $itemdesc .'</span><br/><br/></center>';





  $sqldata = " 
select * from (
  SELECT a.id,a.`ResponsibilityCenter`
  ,( ifnull( (SELECT sum(`qty`) FROM `t_itemreceived` xc left join t_receivedheader cx on 
  xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1   and xc.ResponsibilityCenter = a.id 
  and xc.`itemid` = $itemid and convert( cx.datereceived,date) <= convert('$dtpReportDate',date) ) ,0) - 
  ifnull((SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s 
  left join t_requesitionhead xs on s.rsicode = xs.risno WHERE s.`itemid` = $itemid and s.ResponsibilityCenter = a.id 
  and convert(dateapproved,date) <= convert('$dtpReportDate',date) and s.status = 'Approved'
   
  ) ,0) ) qty
 ,ifnull(`qty`,'') qty2 , ifnull(`shorttage`,'') shorttage ,

(select  sum( ( ifnull( (SELECT sum(`qty`) FROM `t_itemreceived` xc left join t_receivedheader cx on 
 xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1   and xc.ResponsibilityCenter = a.id 
 and xc.`itemid` = $itemid and convert( cx.datereceived,date) <= convert('$dtpReportDate',date) ) ,0) - 
 ifnull((SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s 
 left join t_requesitionhead xs on s.rsicode = xs.risno WHERE s.`itemid` = $itemid and s.ResponsibilityCenter = a.id 
 and convert(dateapproved,date) <= convert('$dtpReportDate',date) and s.status = 'Approved'
  
 ) ,0) ) )    FROM `a_responsibilitycenter` a  WHERE a.isactive =1 
 and a.responsibilitycenter != 'Others' )
 
  
  
 totqty,(
  select  sum(shorttage) shorttage from  t_tempitemcount where createdBy = $uid and  itemid = $itemid ) totshort

  FROM `a_responsibilitycenter` a 
  
  left join t_tempitemcount b on a.id = b.rid and  
  datereport = '$dtpReportDate' and  
  itemid = $itemid
  WHERE a.isactive =1 
  and a.responsibilitycenter != 'Others'
   


union all 

SELECT 1000,'Total'
  ,sum( ( ifnull( (SELECT sum(`qty`) FROM `t_itemreceived` xc left join t_receivedheader cx on 
  xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1   and xc.ResponsibilityCenter = a.id 
  and xc.`itemid` = $itemid and convert( cx.datereceived,date) <= convert('$dtpReportDate',date) ) ,0) - 
  ifnull((SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s 
  left join t_requesitionhead xs on s.rsicode = xs.risno WHERE s.`itemid` = $itemid and s.ResponsibilityCenter = a.id 
  and convert(dateapproved,date) <= convert('$dtpReportDate',date) and s.status = 'Approved'
   
  ) ,0) ) ), (
  select sum(qty) qty   from  t_tempitemcount where createdBy = $uid and  itemid = $itemid )
  ,
  (
    select  sum(shorttage) shorttage from  t_tempitemcount where createdBy = $uid and  itemid = $itemid )
  ,'',''
  FROM `a_responsibilitycenter` a 
  
  
  WHERE a.isactive =1 
  and a.responsibilitycenter != 'Others'  ) sssss order by id ASC 
  

  ";



// echo $sqldata;
   $qrydata = mysqli_query($con,$sqldata);
  
  echo '<table class="table">'.
    '<tr style="text-align:center;font-weight:bold;background-color: #337ab7;color:white;"><td>Office</td>
    <td>Balance Per Card</td>
    <td>On hand per count</td>
    <td>Shortage/Overage</td>
    <td>Remarks</td>
    </tr>';
   while($row = mysqli_fetch_array($qrydata)){
    $total = $row['ResponsibilityCenter']; 
    $shorttage = $row['shorttage'];
    $qty2 = $row['qty2'];
    if($total == 'Total'){
   echo '<tr style="font-weight:bold;">' 
    .'<td>'.$row['ResponsibilityCenter'].'</td>'
    .'<td><center>'.$row['qty'].'</center></td>'
    .'<td> <span id="txtmytotals"  style="text-align:center">'.$qty2.'</span></td>'
    .'<td  style ="text-align:center"> <span id="txtmytotalsover" >  '.$shorttage.'</span></td>'
    .'<td></td>'
    .'</tr>';
    }else {

      $icon = "";
      if($qty2 != ""){
        $icon = '><span class=" 	glyphicon glyphicon-trash  form-control-feedback" 
        style="float:right;color:red " ></span>';
      }
   echo '<tr  >' 
    .'<td>'.$row['ResponsibilityCenter'].'</td>'
    .'<td><center>'.$row['qty'].'</center></td>'
    .'<td>
    <div class="form-group">
    <div class="form-group has-feedback">
    
    <input type="number"
      style="text-align:center"
    class=" form-control txtpcountrow" id="txtmynums'.$row['id'].'|'.$row['qty'].'|'.$row['id'].'|'.$itemid.'|'.$cost.'|'.$row['totqty'].'"
     name="txtmynums'.$row['id'].'|'.$row['qty'].'|'.$row['id'].'|'.$itemid.'" value="'.$qty2.'" /> 
 
     
     
    </div>
    </div>
     </td>'
        .'<td> <center><span class="strover" id="str'.$row['id'].'">&nbsp; '.$shorttage.'</span></center></td>'
    .'<td><input type="text" 
      class ="txtikaw"
    id="rtxtremarks'.$row['id'].'|'.$row['id'].'|'.$row['qty'].'|'.$itemid.'" name="rtxtremarks"></td>'
    .'</tr>';
    }
 

        }


echo '</table>';
?>


