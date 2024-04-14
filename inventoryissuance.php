<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$sqlres = "SELECT 

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
$arrres = mysqli_fetch_array($qryres);

$Responsibility = $arrres['Responsibility'];



    $sql ="SELECT a.id,`risno`,`purpose`, substring(`datarerequest`,1,10) DateRequest,b.Requestedby,
ResposibilityCenter ResponsibilityCenter,Position, Section,remarksforapproval
FROM `t_requesitionhead` a
left join (SELECT `userid`,
Completename Requestedby, `ResposibilityCenter`,Position, Section

FROM `a_user` X 
LEFT join vwprofile  y on x.`profileid` = y.profileid 
           
where x.isactive = 1 ) b on a.`requestedby` = b.userid 
where a.isactive = 1 and ifnull(status,'') = 'Approved' 
and ResposibilityCenter = '$Responsibility'

order by a.id desc ";

    $qry = mysqli_query($con,$sql);




?>


    <br/>

 <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;Inventory to Issue</a></li>
    <li><a data-toggle="tab" href="#menu1" id="newinvettab">List of Inventory Issued</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <br/>

<br/>
    <div class="row">
         <div class="col-xs-12">
           <div >
             <table  class="table table-condensed table-striped">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

                    <th>RIS No.</th>
                    <th>Purpose</th>
                     <th>Date Request</th>
                    <th>Requested By</th>
                    <th>Receive By</th>
                    <th>Resposibility Center</th>
                     <th>Section</th>
                      <th>Position</th>
                   <th>Remarks</th> 
                  
                  
                </tr>
              </thead>
                <tbody>
                     <?php

                    while($row = mysqli_fetch_array($qry)){
                  ?><tr >
                    <td data-toggle="collapse" data-target="#<?php echo $row['risno'] ;?>" class="accordion-toggle"><?php echo $row['risno'] ;?></td>
                    <td ><?php echo $row['purpose'] ;?></td>
                    <td data-toggle="collapse" data-target="#<?php echo $row['risno'] ;?>" class="accordion-toggle"><?php echo $row['DateRequest'] ;?></td>
                    <td data-toggle="collapse" data-target="#<?php echo $row['risno'] ;?>" class="accordion-toggle"><?php echo $row['Requestedby'] ;?></td> 
                    <td ><div class="form-group">
                       <input type="hidden" name="<?php echo $row['risno']. $row['risno'] .$row['risno']. $row['risno']  ;?>" 
                       id = "<?php echo $row['risno']. $row['risno'] .$row['risno']. $row['risno']  ;?>">
                           <input type="text" class="form-control txtreceivedby"
                              name="<?php echo $row['risno']. $row['risno']  ;?>" 
                              id="<?php echo $row['risno']. $row['risno']   ;?>"
                            readonly="true"
                           >

                    </div></td>
                    <td data-toggle="collapse" data-target="#<?php echo $row['risno'] ;?>" class="accordion-toggle"><?php echo $row['ResponsibilityCenter'] ;?></td>
                    <td data-toggle="collapse" data-target="#<?php echo $row['risno'] ;?>" class="accordion-toggle"><?php echo $row['Section'] ;?></td>
                    <td data-toggle="collapse" data-target="#<?php echo $row['risno'] ;?>" class="accordion-toggle"><?php echo $row['Position'] ;?></td>
                     <td data-toggle="collapse" data-target="#<?php echo $row['risno'] ;?>" class="accordion-toggle">
                        <?php echo $row['remarksforapproval'] ;?>
                    </td>
                 
                      

                  </tr>


     
<?php
$risno = $row['risno'];
  $sqllist = "SELECT a.id,
accounttitle,stockno,item itemname,
description,`qty`,
 (SELECT 
 
sum(`qty`) Received



FROM `t_itemreceived` k 
where k.`itemid` = a.itemid and k.`ResponsibilityCenter` = a.ResponsibilityCenter 
and k.isactive = 1 )    
 - (SELECT ifnull(
case when `Status` = 'Pending' then 
  sum(ifnull(`qty`,0))
   when  `Status` = 'Approved' then
   sum( ifnull(`approvedqty`,0))
end,0) issued

FROM `t_requisitiondetails` x WHERE  x.`itemid` = a.itemid   and x. `ResponsibilityCenter` = a.ResponsibilityCenter
and `Status` in ('Approved') ) Available

,units
FROM `t_requisitiondetails` a 
left join (SELECT 
x.id,z.accounttitle,
itemname,`stockno`,`description`
,za.units ,x.item
FROM `m_materials` x 
left join m_itemname y on x.item = y.id and y.isactive = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.`units` = za.id and za.isactive = 1  
where x.isactive = 1 ) b on a.`itemid` = b.id 
where `RSIcode` = '$risno' and ifnull(a.Status,'') = 'Pending'";

  $qrylist = mysqli_query($con,$sqllist);


  

?>

    <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $row['risno'] ;?>"> 
              <table class="table table-striped">
                      <thead>
                        <tr class="info">
                           <th>Stoc No.</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Units</th>
                            <th>Qty</th>
                            <th>Available</th>
                            <th>Approve Qty</th>
                             <th>Release</th>
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['risno']; ?>">
                        <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {
                           echo '<tr class= "itemrow" id="'.$newrow['id'].'|'.$newrow['stockno'].'|'.$newrow['itemname'].'|'.$newrow['description'].'|'.$newrow['units'] .'" >
        <td>'.$newrow['stockno'].'</td>
        <td>'.$newrow['itemname'].'</td>
        <td>'.$newrow['description'].'</td>
        <td>'.$newrow['units'].'</td>
        <td>'.$newrow['qty'].' 
        <input type="hidden" value ="'.$newrow['qty'].'" id="txtmyqty'.$newrow['id'].'" name = "txtmyqty'.$newrow['id'].'"></td>
        <td>'.$newrow['Available'].'</td>
        <td><div class="form-group"><input class="form-control" type="number" id="txtapproveqty'.$newrow['id'].'" name="txtapproveqty" size="1" > </div></td>
        <td > <button class="btn btn-primary btnreleaseitem" id="'.$newrow['id'].'|'.$row['risno'].'|'.$row['risno'].$row['risno'].$row['risno'].$row['risno'].'|'.$newrow['Available'].'" style=" padding-right: : 15px;margin-right: :15px;"><span class="glyphicon glyphicon-thumbs-up">&nbsp;Release</span></button></td>
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
    </div>

     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "tabsemi"></div>

    </div>
   
 
  </div>