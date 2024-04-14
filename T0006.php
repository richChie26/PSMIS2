<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sqlres = "

select 

c.ResponsibilityCenter
from a_user a 
left join u_profile b on a.profileid = b.profileid and b.isactive =1 
left join a_responsibilitycenter c on  b.ResponsibilityCenter = c.id and c.isactive =1 
where  a.isactive =1 and ifnull(c.ResponsibilityCenter,'') != ''

and a.userid = $uid";


$qryres = mysqli_query($con,$sqlres);
$arrres = mysqli_fetch_array($qryres);
$res = $arrres['ResponsibilityCenter'];

    $sql =" Select * from (SELECT a.id,`risno`,`purpose`, substring(`datarerequest`,1,10) DateRequest,b.Requestedby,
ResposibilityCenter ResponsibilityCenter,Position, Section
FROM `t_requesitionhead` a
left join (SELECT `userid`,
Completename Requestedby, `ResposibilityCenter`,Position, Section

FROM `a_user` X 
LEFT join vwprofile  y on x.`profileid` = y.profileid 
           
where x.isactive = 1 ) b on a.`requestedby` = b.userid 
where a.isactive = 1 and ifnull(status,'') = '') a where ResponsibilityCenter = '$res'";

    $qry = mysqli_query($con,$sql);




?>
    <div class="row">
         <div class="col-xs-12">
           <div class="table-responsive">
             <table  class="table table-striped">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

                    <th>RIS No.</th>
                    <th>Purpose</th>
                     <th>Date Request</th>
                    <th>Requested By</th>
                    <th>Resposibility Center</th>
                     <th>Section</th>
                      <th>Position</th>
                   <th>Remarks</th> 
                    <th>View Details</th> 
                     <th>Approve</th> 
                      <th>Disapprove</th> 
                </tr>
              </thead>
                <tbody>
                     <?php

                    while($row = mysqli_fetch_array($qry)){
                  ?><tr>
                    <td><?php echo $row['risno'] ;?></td>
                    <td><?php echo $row['purpose'] ;?></td>
                    <td><?php echo $row['DateRequest'] ;?></td>
                    <td><?php echo $row['Requestedby'] ;?></td> 
               
                    <td><?php echo $row['ResponsibilityCenter'] ;?></td>
                    <td><?php echo $row['Section'] ;?></td>
                    <td><?php echo $row['Position'] ;?></td>
                     <td><div class="form-group">
                      <input type="text" class="form-control yourtxtremarks" name="txtremarks" id="txtremarks<?php echo $row['id']; ?>">
                        </div>
                    </td>
                    <td><a href="#" class="btnviewris" id = "<?php echo $row['risno'] .'|'. $row['purpose'].'|'. $row['Requestedby'] .'|'. $row['DateRequest'] ;?>" >View Details</a></td>
                      <td><center><img src="img/icons8_thumbs_up_32px_1.png" class ="btnapprovemyris" id= "<?php echo $row['id'] .'|'. $row['purpose'].'|'. $row['Requestedby'] .'|'. $row['DateRequest'] .'|'. $row['risno'] ;?>" style="color: blue;"></span></center></td>
                      <td><center>


                        <img src="img/icons8_thumbs_down_32px_2.png" class ="btndisapprovemyris" id= "<?php echo $row['id'] .'|'. $row['purpose'].'|'. $row['Requestedby'] .'|'. $row['DateRequest']  .'|'. $row['risno'] ;?>" style="color:red;"></center></td>

                  </tr> 
                    <?php 
                      }
                    ?>
                </tbody>
             </table>
           </div>
         </div>
    </div>