<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$mnuasset = 3;
$seltype = "Receiving (Transfer From)";


$sql = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    $Responsibility = $arr['Responsibility'];
    ?>


<input type="hidden" name="myhiddentag" id="myhiddentag" value="3">
<div class="panel panel-primary" id="supplannel">
   <div class="panel-heading">List of Transfered Property Plants and Equipment</div>
  <div class="panel-body" >
    <!-- ============== -->
 <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;Property Plants and Equipment  Transfered</a></li>
    <li><a data-toggle="tab" href="#menu1" id="tabptrres">List of Received Property Plants and Equipment</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <br/>

<br/>
      <div class="row">
         <div class="col-xs-12">
           <div >
          <?php 
            $sqltoreceive = "SELECT 
a.`id`, `ptrcode`, `datetransfered`, `transfertype` ,b.ResponsibilityCenter
FROM `t_ptrheader` a 
left join a_responsibilitycenter b on a.`transferfrom` = b.id and b.isactive =1 

where a.isactive = 1 
and a.transfertoResposibilitycenter = $Responsibility
and a.tag = 3 
and ifnull(a.status,'') = ''
order by a.id desc ";
    $qrytoreceived = mysqli_query($con,$sqltoreceive);
          ?>
             <table  class="table table-striped" id="tblrichie">
               <thead style="background-color: #337ab7;color:white;">
                <tr>
                  <th>PTR Code</th>
                  <th>Date of Transfer</th>
                  
                  <th>Transferred From</th>
                  <th>Type of Transfer</th>
                   
                </tr>
              </thead>
                <tbody>
                  <?php 
                    while ($myrow = mysqli_fetch_array($qrytoreceived)) {
                      echo '<tr data-toggle="collapse" data-target="#'. $myrow['ptrcode'] .'" class="accordion-toggle">
<td>'.$myrow['ptrcode'].'</td>
<td>'.$myrow['datetransfered'].'</td>

<td>'.$myrow['ResponsibilityCenter'].'</td>
<td>'.$myrow['transfertype'].'</td>
                   
                </tr>';

$PARNO = $myrow['ptrcode'];
$sqllist = "SELECT f.id ,b.*,f.reasontotransfer FROM `t_ptrdetails` 
f left join (SELECT a.id delitemid, accounttitle,item,yearoflife,
 concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, 
 `propertyno` FROM `t_equipmentdeliverydetails` a 
 left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife` 
 FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 
 where y.typeofasset = 3 and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 ) b 
 on f.`propertyno` = b.propertyno
where f.ptrcode = '$PARNO'  and tag = 3 and ifnull(f.status,'') = ''
";


$qrylist = mysqli_query($con,$sqllist); 
?>
    <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $myrow['ptrcode'] ;?>"> 
              <table class="table table-striped">
                      <thead>
                        <tr class="info">
                           
                            <th>Account Title</th>
                            <th>Property No.</th>
                            <th>Description</th>
                              <th>Reason for Transfer</th>
                              <th><center>Receive</center></th>
                      
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $myrow['PARNO']; ?>">
                        <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {
                           echo '<tr>
                            <td>'.$newrow['accounttitle'].'</td>
                            <td>'.$newrow['propertyno'].'</td>
                            <td>'.$newrow['description'].'</td>
                                  <td>'.$newrow['reasontotransfer'].'</td>
                            <td><button class="btn btn-primary btnacceptreceived" 
                              id = "'.$newrow['id'].'|'. $newrow['propertyno'].
                               '|'.$newrow['description'].'|'.$newrow['reasontotransfer'].
                               '|'.$myrow['ResponsibilityCenter'].


                               '"
                            >
                              <span class ="glyphicon glyphicon-thumbs-up"> </span> &nbsp;Receive</button></td>
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
      <div id= "tabptrdetails"></div>

    </div>
   
 
  </div>
    <!-- ====================== -->
  </div></div>


