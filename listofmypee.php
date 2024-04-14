<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;




echo '<div class="row">
         <div class="col-xs-12">
           <div >
            <br/>
             <table  class="table table-striped" id="richietable">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                    <th> Account Title</th>
                     <th>Property Number</th>
                    <th>Description</th>
          
                    
                  
                    <th>Quantity</th> 
                  
                  
                      <th>Remove</th> 
                   
                </tr>
              </thead>
                <tbody>';
                	
              

      $sql = "SELECT f.id ,b.* FROM `t_temppar` f 
left join (SELECT a.id, b.accounttitle,item,yearoflife, concat(item, ', ',`description`,', ', `Serial`) description, `propertyno`,typeofasset FROM `t_equipmentdeliverydetails` a left join
 (SELECT x.id , y.`accounttitle`, `item`,`yearoflife`,y.typeofasset FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = 2 and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 and  ifnull(a.`Status`,'') = '')  b on f.`propertyno` = b.propertyno
where f.createdby = $uid  and typeofasset = 2 

 ";
            
$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {
  echo '    <tr>

                    <td>'.$row['accounttitle'].'</td>
                    <td>'.$row['propertyno'].'</td>
                    <td>'.$row['description'].'</td>
                   
                    <td>1</td>
                    <td><center><a href="#" class="btnremovemyppedetails" id="'.$row['id'].'|'.$row['description'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> 
                </tr>';
}



echo "                </tbody>
             </table>
           </div>
         </div>
    </div>";


 echo '<div class="row">
 		<div class="col-xs-12">
 			<div class="alert alert-info"><strong>Confirmation!</strong> 
 		Do you want to save this transaction.</div>

 		</div>
 </div>';

 echo '<div class="row">
 	
 		<div class="col-xs-4">
 		<button class="btn btn-primary" id="btnyestosavemysemippe">Yes</button>
 		<button class="btn btn-danger" data-dismiss="modal">No</button>

 		</div>
 </div>';
?>

