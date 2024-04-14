<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$sqlres = "SELECT 
(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter)
rid ,
(select r.`ResponsibilityCenter` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
$qryres = mysqli_query($con,$sqlres);
$arr = mysqli_fetch_array($qryres);
$Responsibility  = $arr['Responsibility'];
 $rid  = $arr['rid'];

$itemname = $_GET['itemname22'];
$desc = $_GET['desc'];
$stock = $_GET['stock'];
$unit = $_GET['unit'];
$cost = $_GET['cost'];
$bal = $_GET['bal'];
$dtpReportDate = $_GET['dtpReportDate'];
$itemid = $_GET['itemid'];


$selsource1 = $_GET['selsource'];


$sqlpppp = "SELECT `id` FROM `m_fundcluster` WHERE `Fundcategory` ='$selsource1' and isactive = 1 ";
$qrypppp = mysqli_query($con,$sqlpppp);
$selsource = 0 ;
while($rro = mysqli_fetch_array($qrypppp)){
    $selsource = $rro['id'];
}
$sqlkkk = "Select itemname from t_temprpci where 
rpcidate ='$dtpReportDate' and 
itemid =$itemid  and 
resposibilityid = $rid and 
createdby =$uid 
";
$myqry = mysqli_query($con,$sqlkkk);



$sqlchk ="select * from (select *, 0  tag

,ifnull((SELECT `itemid` FROM `t_tempvaldel`  where `itemid`= xx.id and  `resid` =  $rid  and  `userid`  =  $uid ),0) newtags


from (SELECT `item`, `stockno`,b.units, `description` , 
(SELECT  format(ave,2) amount FROM `t_itemreceived` xc left join t_receivedheader cx on xc.transcode =
 cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1 and xc.`ResponsibilityCenter` = 
 $rid and xc.`itemid` = a.id and cx.datereceived <= '$dtpReportDate' 
 order by cx.id desc  limit 1
 ) cost, ( ifnull(
     (SELECT sum(`qty`) FROM `t_itemreceived` xc left join t_receivedheader cx on 
     xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1 and xc.`ResponsibilityCenter` = $rid and 
     xc.`itemid` = a.id and convert( cx.datereceived,date) <= convert('$dtpReportDate',date) ) ,0) - 
     ifnull((SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s left join 
     t_requesitionhead xs on s.rsicode = xs.risno WHERE s.`itemid` = a.id and convert(dateapproved,date) 
     <= convert('$dtpReportDate',date) and s.status = 'Approved' and s.`ResponsibilityCenter` = $rid) ,0) ) qtyres 
     ,a.id FROM `m_materials` a left join m_units b on a.`units` = b.id and b.isactive = 1 where a.isactive = 1 and 
     `titleid` = 1 ) xx where ifnull(cost,0) != 0
union all 
SELECT `itemname`,itemno, unit,  `description` ,  `cost`, `qty`, `itemid`


 ,ifnull((select id from (SELECT `item`, `stockno`,b.units, `description` ,
  (SELECT format(`ave`,2) amount FROM `t_itemreceived` xc left join t_receivedheader cx 
  on xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1 and xc.`ResponsibilityCenter` = $rid 
  and xc.`itemid` = a.id and cx.datereceived <= '$dtpReportDate' 
  order by cx.id desc  limit 1
  ) cost,
   ( ifnull( (SELECT sum(`qty`) FROM `t_itemreceived` xc left join t_receivedheader cx on 
   xc.transcode = cx.transcode and cx.isactive = 1 WHERE xc.isactive = 1 and xc.`ResponsibilityCenter` = $rid 
   and xc.`itemid` = a.id and convert( cx.datereceived,date) <= convert('$dtpReportDate',date) ) ,0) - 
   ifnull((SELECT sum(`approvedqty`) FROM `t_requisitiondetails` s 
   left join t_requesitionhead xs on s.rsicode = xs.risno WHERE s.`itemid` = a.id 
   and convert(dateapproved,date) <= convert('$dtpReportDate',date) and s.status = 'Approved' and s.`ResponsibilityCenter` = $rid
   ) ,0) ) qtyres ,a.id FROM `m_materials` a left join m_units b on a.`units` = 
   b.id and b.isactive = 1 where a.isactive = 1 and `titleid` = 1 ) xx where ifnull(cost,0) != 0  and id = ff.`itemid`),0)

,ifnull((SELECT `itemid` FROM `t_tempvaldel`  where `itemid`= ff.itemid and  `resid` =  $rid  and  `userid`  =  $uid ),0)
FROM `t_temprpci` ff  WHERE `resposibilityid` = $rid  and  `createdby` =  $uid 
) ss where  newtags = 0 and id = $itemid";


$myqry2 = mysqli_query($con,$sqlchk);
if((mysqli_num_rows($myqry) == 0) and (mysqli_num_rows($myqry2) == 0)){
    $sqlinsertsss = "insert into  `t_temprpci`(`rpcidate`, `itemid`, 
    `itemname`, `description`, `unit`, `cost`, `qty`, `resposibilityid`, `createdby`, `itemno`)
    values(
    '$dtpReportDate',
    $itemid,
    '$itemname','$desc','$unit',$cost,$bal,$rid ,$uid,'$stock')
    ";
    
    
    
    
    //  echo $sqlinsertsss;
    mysqli_query($con,$sqlinsertsss);


    $sqldisplay = "select * from (select *

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
    
    // echo $sqldisplay;
     $nysqry = mysqli_query($con,$sqldisplay);
    // echo $sqldisplay;
     while($row = mysqli_fetch_array($nysqry)){
    
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
    $rowcol = $row['tag'];
    $col ="";
    if($rowcol != 0 ){
       $col ='highlight'; 
    }else{
        $col ="";
    }
    
    echo '<tr class="'.$col.'" id="row'.$id.'">
            <td>'.$row['item'] .'</td>
            <td>'.$row['description'].'</td>
            <td>'.$row['stockno'].'</td>
            <td>'.$row['units'].'</td>
            <td><span id="lblmycost'.$id.'">'.$row['cost'].'</span></td>
            <td><span id="lblpercard'.$id.'"> '.$row['qtyres'].'</span></td>
            <td>  <input type="number" size="5"  class="txtbpccount" id="lblcount'.$id.'|'.$id.'|'. $row['qtyres'].'|'. $row['cost'].'"/>  </td>
            <td> <span class="lblcount'.$id.'"></span>  </td>
            <td><span class="lblave'.$id.'"></span></td>
            <td> <input type="text" size="5"  class="txtremarks" id="lblremarks'.$id.'|'.$id.'"/> </td>
            <td><center><a href="#" class ="btnremovesel" id="btn'.$id.'|'.$id.'"><span style="color:red;" class="glyphicon glyphicon-minus"></span></a></center></td>
           </tr>';
    
     }



}else{

    echo "1";
}
// echo $itemname;



 ?>

