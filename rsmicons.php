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
  <div class="cols-xs-12">
<table style="width: 50%;margin-left: 15px;"> <tr><td>
      <div class="form-group">
          <select style="width:90%;display: none;" id="selrsmi"class="form-control">
              <option value="1">Select Option</option>
              <option value="2">RSMI Code</option>
              <option value="3">Date</option>
              <option value="4" style="display: none;">Responsibility Center</option>
           </select>
        </div></td><td>
     <div class="form-group">
          <input type="text" name="txtsearchnewrsmi" id="txtsearchnewrsmi" class="form-control" placeholder="Search" style="width: 90%;display: none;">
        </div></td>
        <td style="padding: 0px;margin: 0px;"><button id="btnsearchrsmi" class="btn btn-primary" style="display: none;">Search</button></td><td ></td><td></td>  
      </tr></table>
<button class="btn btn-primary" style="float: right;margin-right: 15px;" id ="btnsubmitrsmiconts">Submit</button>
 <br/>
      <br/>
     <table  class="table table-condensed table-striped" style="width:98% ;margin-left: 10px;">
               <thead style="background-color: #337ab7;color:white;">
<th>RSMI Code </th> 
<th>Date </th> 
<th>Responsibility Center </th> 
                    <th></th>
               </thead>
         <tbody id="rsmidetailsss">
          <?php
        $sql = "SELECT `rsmicode`, `rsmiDate`
          ,(SELECT `ResponsibilityCenter` FROM `a_responsibilitycenter` f  WHERE  f.isactive = 1  and f.`id`  = a.ResponsibilityCenter) ResponsibilityCenter
         FROM `t_rsmi` a  WHERE a.`isactive` = 1 and newrsmicode = ''  order by id desc ";


  $qry = mysqli_query($con,$sql);
$forprint = "";
while ($row = mysqli_fetch_array($qry)) {


$forprint = '<a href="#" class="btnprintrsmi" id="ptr'. '|'. $row['rsmicode'] .'"><span class="glyphicon glyphicon-print" style="color:#337ab7;"></span></a>';



  echo '<tr >
   
      <td data-toggle="collapse" data-target="#'. $row['rsmicode'] .'" class="accordion-toggle">'.$row['rsmicode'].'</td>
      
      <td data-toggle="collapse" data-target="#'. $row['rsmicode'] .'" class="accordion-toggle">'.$row['rsmiDate'].'</td>

      <td data-toggle="collapse" data-target="#'. $row['rsmicode'] .'" class="accordion-toggle">'.$row['ResponsibilityCenter'] .'</td>
      

     
       <td><center>'.$forprint.'</center></td>
        </tr>';


$risno = $row['rsmicode'];
$sqllist = "SELECT a.id,`risno`,`purpose`, substring(`datarerequest`,1,10) DateRequest,b.Requestedby
    , case when ifnull(`status`,'') = '' then 
         'For Approval'
        else 
            ifnull(`status`,'')
     end status, `remarksforapproval` 'Remarks'
     ,ResponsibilityCenter
     FROM `t_requesitionhead` a
left join (SELECT `userid`,
concat(`fname`, ', ' , substring(`mname`,1,1),'.',' ',`lname`) Requestedby, z.`ResponsibilityCenter`

FROM `a_user` X 
LEFT join u_profile y on x.`profileid` = y.profileid and y.isactive = 1
left join a_responsibilitycenter z on y.ResponsibilityCenter = z.id and z.isactive =1 
where x.isactive = 1 ) b on a.`requestedby` = b.userid 
where a.isactive = 1 and   a.id in (SELECT `rsiid` FROM `t_rsmidetails` WHERE `codes` = '$risno')
  order by a.id desc 

 ";



$qrylist = mysqli_query($con,$sqllist);
?>


  <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $row['rsmicode'] ;?>"> 
              <table class="table table-striped" style="margin-left: 30px;">
                      <thead>
                        <tr class="info">
                           
   
                     <th> RIS No</th>
                    <th>Purpose.</th>
                    <th>Requested By</th>
                    <th>Date Request</th>
                    <th>Remarks</th> 
                    <th>Responsibility Center</th>
                    
                      
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['risno']; ?>">
 <?php 
  while ($newrow = mysqli_fetch_array($qrylist))
{
 echo '<tr>

<td>'.$newrow['risno'].'</td>
<td>'.$newrow['purpose'].'</td>
  <td>'.$newrow['Requestedby'].'</td>
<td>'.$newrow['DateRequest'].'</td>
<td>'.$newrow['Remarks'].'</td>
<td>' .$newrow['ResponsibilityCenter'].'</td>
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