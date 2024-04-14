<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$tag = $_GET['tag'];



$sqlres = "SELECT `ResponsibilityCenter` FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";

$qryrestto = mysqli_query($con,$sqlres);

$arrrestko = mysqli_fetch_array($qryrestto);
$resspo = $arrrestko['ResponsibilityCenter'];

$sql ="SELECT 
a.`id`, `ptrcode`, `datetransfered`, `transfertype` ,b.ResponsibilityCenter
FROM `t_ptrheader` a 
left join a_responsibilitycenter b on a.`transferfrom` = b.id and b.isactive =1 

where a.isactive = 1 
and a. transfertoResposibilitycenter = $resspo
and a.tag = $tag
and a.status ='Received'
order by a.id desc 
";
// echo $sql;

  $qry = mysqli_query($con,$sql);

?>
<br/>
<div class="row">
  <div class="cols-xs-12">
     <table  class="table table-condensed table-striped">
               <thead style="background-color: #337ab7;color:white;">
                  <th>PTR Code</th>
                  <th>Date Transfer</th>
                  
                  <th>Transfered from</th>
                  <th>Type of Transfer</th>
                  <th>Print Preview</th>
               </thead>
         <tbody>
          <?php
            while ($row= mysqli_fetch_array($qry)) {
              echo '<tr class="accordion-toggle">
                  <td data-toggle="collapse" data-target="#'. $row['ptrcode'] .'" > '.$row['ptrcode'].'</td>
                          <td data-toggle="collapse" data-target="#'. $row['ptrcode'] .'" >'.$row['datetransfered'].'</td>
                        
                          <td data-toggle="collapse" data-target="#'. $row['ptrcode'] .'" >'.$row['ResponsibilityCenter'].'</td>
                          <td data-toggle="collapse" data-target="#'. $row['ptrcode'] .'" >'.$row['transfertype'].'</td>
                           <td><button class="btn btn-primary btnprintreceive" > <span class="glyphicon glyphicon-print"></span></button></td> 

                           </tr>';
            
                    
$PARNO = $row['ptrcode'];
$sqllist = "SELECT distinct f.id ,b.*,f.reasontotransfer FROM `t_ptrdetails` f left join (SELECT a.id delitemid, accounttitle,item,yearoflife, concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, `propertyno` FROM `t_equipmentdeliverydetails` a left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife` FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = $tag and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 ) b on f.`propertyno` = b.propertyno
where f.ptrcode = '$PARNO' 
";
 // echo $sqllist;

$qrylist = mysqli_query($con,$sqllist); 
                      ?>      
    <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $row['ptrcode'] ;?>"> 
              <table class="table table-striped">
                      <thead>
                        <tr class="info">
                           
                            <th>Account Title</th>
                            <th>Property No.</th>
                            <th>Description</th>
                              <th>Reason for Transfer</th>
                              <th>Estimated Usefull life</th>
                      
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['PARNO']; ?>">
                        <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {
                           echo '<tr>
                            <td>'.$newrow['accounttitle'].'</td>
                            <td>'.$newrow['propertyno'].'</td>
                            <td>'.$newrow['description'].'</td>
                                  <td>'.$newrow['reasontotransfer'].'</td>
                            <td>'.$newrow['yearoflife'].'</td>
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