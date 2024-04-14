<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$selrsmi = $_GET['selrsmi'];
$txtsearchnewrsmi = $_GET['txtsearchnewrsmi'];
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
    ?>





 
     
          <?php
          $sql = "";

if($selrsmi == "2"){
$sql = "SELECT `rsmicode`, `rsmiDate` FROM `t_rsmi` WHERE `isactive` = 1 and
`rsmicode` like '%".$txtsearchnewrsmi."%' and  
 `ResponsibilityCenter` =  $rid order by id desc ";
}else if($selrsmi == "3"){
 $sql = "SELECT `rsmicode`, `rsmiDate` FROM `t_rsmi` WHERE `isactive` = 1 and
convert(`rsmiDate`,date) = convert('$txtsearchnewrsmi',date) and  
 `ResponsibilityCenter` =  $rid order by id desc "; 
}
        


  $qry = mysqli_query($con,$sql);
$forprint = "";
while ($row = mysqli_fetch_array($qry)) {


$forprint = '<a href="#" class="btnprintrsmi" id="ptr'. '|'. $row['rsmicode'] .'"><span class="glyphicon glyphicon-print" style="color:#337ab7;"></span></a>';



  echo '<tr >
   
      <td data-toggle="collapse" data-target="#'. $row['rsmicode'] .'" class="accordion-toggle">'.$row['rsmicode'].'</td>
      
      <td data-toggle="collapse" data-target="#'. $row['rsmicode'] .'" class="accordion-toggle">'.$row['rsmiDate'].'</td>

      <td data-toggle="collapse" data-target="#'. $row['rsmicode'] .'" class="accordion-toggle">'.$Responsibility .'</td>
      

     
       <td><center>'.$forprint.'</center></td>
        </tr>';


$risno = $row['rsmicode'];
$sqllist = "
SELECT  `approvedqty`,`risno`, `purpose`,c.`status`, item,
stockno,
units,
amount 
,e.`rsmicode`, `rsmiDate`,rccode ,r.ResponsibilityCenter,(amount * approvedqty) cost
 FROM `t_requisitiondetails` a
left join (SELECT f.`id`, `item`, `stockno`, h.units , 
(SELECT `amount` FROM `t_itemreceived` s where s.isactive =1 and `ResponsibilityCenter` = $rid 
  and s.`itemid` = f.id order by s.id desc limit 1 ) amount FROM 
`m_materials` f 
left join m_itemname g on f.`item` = g.itemname and g.isactive =1
left join m_units h on f.`units` = h.id and h.isactive = 1) b on a.`itemid` = b.id 
left join t_requesitionhead c on a.`RSIcode` = c.risno and c.isactive = 1 
left join t_rsmidetails d on d.rsiid = c.id 
left join t_rsmi e on d.codes = e.rsmicode
left join a_responsibilitycenter r on e.ResponsibilityCenter = r.id and r.isactive = 1 
where a.`ResponsibilityCenter` = $rid 
and ifnull(e.rsmicode,'') != ''  and ifnull(e.rsmicode,'') = '$risno'
union all 

SELECT  '','Total', '','', '',
'',
'',
 ''
,'', '','' ,r.ResponsibilityCenter ,sum(amount * approvedqty)
 FROM `t_requisitiondetails` a
left join (SELECT f.`id`, `item`, `stockno`, h.units , 
(SELECT `amount` FROM `t_itemreceived` s where s.isactive =1 and `ResponsibilityCenter` = $rid 
  and s.`itemid` = f.id order by s.id desc limit 1 ) amount FROM 
`m_materials` f 
left join m_itemname g on f.`item` = g.itemname and g.isactive =1
left join m_units h on f.`units` = h.id and h.isactive = 1) b on a.`itemid` = b.id 
left join t_requesitionhead c on a.`RSIcode` = c.risno and c.isactive = 1 
left join t_rsmidetails d on d.rsiid = c.id 
left join t_rsmi e on d.codes = e.rsmicode
left join a_responsibilitycenter r on e.ResponsibilityCenter = r.id and r.isactive = 1 
where a.`ResponsibilityCenter` = $rid 
and ifnull(e.rsmicode,'') != ''  and ifnull(e.rsmicode,'') = '$risno'

 ";


$qrylist = mysqli_query($con,$sqllist);
?>


  <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $row['rsmicode'] ;?>"> 
              <table class="table table-striped">
                      <thead>
                        <tr class="info">
                           
                
                     <th> RIS No</th>
                    <th>Stock No.</th>
                    <th>Item</th>
                    <th>Units</th>
                    <th>Quantity Issued</th> 
                    <th>Cost</th>
                    <th>Amount</th>
                      
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['risno']; ?>">
                        <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {
$sss = "<span>&#8369;</span> &nbsp;";
if($newrow['risno'] == "Total"){
$sss = "";
}else{
  $sss = "<span>&#8369;</span> &nbsp;";
}


                           echo '<tr>
                            <td>'.ucwords(strtolower($newrow['risno'])).'</td>
                            <td>'.$newrow['stockno'].'</td>
                            <td>'.ucwords(strtolower($newrow['item'])).'</td>
                              <td>'.ucwords(strtolower($newrow['units'])).'</td>
                            <td>'.$newrow['approvedqty'].'</td>
                                   <td>'.$sss .$newrow['amount'].'</td>
                    
                            <td><span>&#8369;</span> &nbsp;'.$newrow['cost'].'</td>
                           </tr>';

                          }
                        ?>
                    
                           
                      </tbody>
                </table>
              
              </div> 
          </td>
        </tr>
<?php
}

          ?>
      

