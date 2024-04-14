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
    ?>


<div class="row">
  <div class="cols-xs-11">
    <button class="btn btn-primary" style="float: right;margin-right: 20px;margin-bottom: 10px;" id="btnsaversmi2">Submit</button>
  </div>
</div>
<div class="row">
  <div class="cols-xs-12">
    
     <table  class="table table-condensed table-striped" style="width:98% ;margin-left: 10px;">
               <thead style="background-color: #337ab7;color:white;">
<th>Select</th>
<th>RIS No. </th> 
<th>Purpose </th> 
<th>Requested by </th> 
<th>Date Request </th> 
<th>Remarks </th> 
<th>Status</th> 
                    <th></th>
               </thead>
         <tbody>
          <?php
        $sql = "SELECT a.id,`risno`,`purpose`, date_format(`datarerequest`,'%m-%d-%Y') DateRequest,b.Requestedby
    , case when ifnull(`status`,'') = '' then 
         'For Approval'
        else 
            ifnull(`status`,'')
     end status, `remarksforapproval` 'Remarks'
     ,ResponsibilityCenter
     FROM `t_requesitionhead` a
left join (SELECT `userid`,
concat(`fname`, ', ' , substring(`mname`,1,1),'.',' ',`lname`) Requestedby, `ResponsibilityCenter`

FROM `a_user` X 
LEFT join u_profile y on x.`profileid` = y.profileid and y.isactive = 1
where x.isactive = 1 ) b on a.`requestedby` = b.userid 
where a.isactive = 1 and  status = 'Released' 
and ResponsibilityCenter = $rid   order by a.id desc ";

// echo $sql;
  $qry = mysqli_query($con,$sql);
$forprint = "";
while ($row = mysqli_fetch_array($qry)) {

if($row['status'] ==  'Released'){
$forprint = '<a href="#" class="btnprintris" id="ptr'. '|'. $row['risno'] .'"><span class="glyphicon glyphicon-print" style="color:#337ab7;display:none;"></span></a>';
}else{
  $forprint = "";
}


  echo '<tr >
      <td>
      <input name="selector[]" id="ad_Checkbox12" class="ads_Checkbox2" type="checkbox" value="'.$row['id'].'" />
      </td>
      <td data-toggle="collapse" data-target="#'. $row['risno'] .'" class="accordion-toggle">'.$row['risno'].'</td>
      
      <td data-toggle="collapse" data-target="#'. $row['risno'] .'" class="accordion-toggle">'.$row['purpose'].'</td>

      <td data-toggle="collapse" data-target="#'. $row['risno'] .'" class="accordion-toggle">'.$row['Requestedby'].'</td>
      
      <td data-toggle="collapse" data-target="#'. $row['risno'] .'" class="accordion-toggle">'.$row['DateRequest'].'</td>

      <td data-toggle="collapse" data-target="#'. $row['risno'] .'" class="accordion-toggle">'.$row['Remarks'].'</td>

      <td data-toggle="collapse" data-target="#'. $row['risno'] .'" class="accordion-toggle">'.$row['status'].'</td>
       <td><center>'.$forprint.'</center></td>
        </tr>';


$risno = $row['risno'];
$sqllist = "SELECT 
accounttitle,stockno,itemname,
description,approvedqty `qty`,units
FROM `t_requisitiondetails` a 
left join (SELECT 
x.id,z.accounttitle,
item itemname,`stockno`,`description`
,za.units
FROM `m_materials` x 
left join m_itemname y on x.item = y.id and y.isactive = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.`units` = za.id and za.isactive = 1  
where x.isactive = 1 ) b on a.`itemid` = b.id 
where `RSIcode` = '$risno'";
$qrylist = mysqli_query($con,$sqllist);
?>


  <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $row['risno'] ;?>"> 
              <table class="table table-striped">
                      <thead>
                        <tr class="info">
                           
                
                     <th> Account Title</th>
                    <th>Stock No.</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Qty</th> 
                    <th>Units</th>
                      
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['risno']; ?>">
                        <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {
                           echo '<tr>
                            <td>'.ucwords(strtolower($newrow['accounttitle'])).'</td>
                            <td>'.$newrow['stockno'].'</td>
                            <td>'.ucwords(strtolower($newrow['itemname'])).'</td>
                              <td>'.ucwords(strtolower($newrow['description'])).'</td>
                            <td>'.$newrow['qty'].'</td>
                          
                            <td>'.$newrow['units'].'</td>
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
         </tbody>
      </table>
  </div>

</div>    