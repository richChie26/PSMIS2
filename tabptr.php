<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$tag = $_GET['tag'];

$sql ="SELECT 
a.`id`, `ptrcode`, `datetransfered`, `transfertype` ,b.ResponsibilityCenter
FROM `t_ptrheader` a 
left join a_responsibilitycenter b on a.`transfertoResposibilitycenter` = b.id and b.isactive =1 

where a.isactive = 1 
and a.`createdby` = $uid
and a.tag = $tag
order by a.id desc 
";


	$qry = mysqli_query($con,$sql);

?>
<br/>
<div class="row">
	<div class="cols-xs-12">
		 <table  class="table table-condensed table-striped">
               <thead style="background-color: #337ab7;color:white;">
               		<th>PTR Code</th>
               		<th>Date Transfer</th>
               		
               		<th>Transfered To</th>
               		<th>Type of Transfer</th>
                   <th></th>
               </thead>
			   <tbody>
          
					<?php
						while ($row= mysqli_fetch_array($qry)) {
              $PARNO = $row['ptrcode'];
              echo '<tr >
									<td data-toggle="collapse" data-target="#'. $row['ptrcode'] .'" class="accordion-toggle">'.$row['ptrcode'].'</td>
				               		<td data-toggle="collapse" data-target="#'. $row['ptrcode'] .'" class="accordion-toggle">'.$row['datetransfered'].'</td>
				               	
				               		<td data-toggle="collapse" data-target="#'. $row['ptrcode'] .'" class="accordion-toggle">'.$row['ResponsibilityCenter'].'</td>
				               		<td data-toggle="collapse" data-target="#'. $row['ptrcode'] .'" class="accordion-toggle">'.$row['transfertype'].'</td>
                 
                           <td> <button class="btnmyprint btn btn-primary"
                           id = "1|'.$PARNO.'"
                           
                           ><span class="glyphicon glyphicon-print"></span></button> </td>
                           
                           </tr>';
						
               			

$sqllist = "SELECT distinct f.id ,b.*,f.reasontotransfer FROM `t_ptrdetails` f left join (SELECT a.id delitemid, accounttitle,item,yearoflife, concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, `propertyno` FROM `t_equipmentdeliverydetails` a left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife` FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = $tag and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 ) b on f.`propertyno` = b.propertyno
where f.ptrcode = '$PARNO' 
";


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
                              <th>Usefull life</th>
                      <th></th>
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