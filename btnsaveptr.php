<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$txtothers =$_GET['txtothers'];
$seltypeoftransfer =$_GET['seltypeoftransfer'];
$txttransferedto =$_GET['txttransferedto'];
$dtpissued =$_GET['dtpissued'];
$selmytype = $_GET['selmytype'];

$panganay = "";

if($seltypeoftransfer == "OTHERS"){
    $panganay = $seltypeoftransfer ." (" . $txtothers.")";
}else{
   $panganay = $seltypeoftransfer ;
}
echo '<div class="row">
         <div class="col-xs-12">
         Date Transfer : <b>'.$dtpissued.'</b>

         </div>
      </div>';

 echo '<div class="row">
         <div class="col-xs-12">
         Transfer to : <b>'.$txttransferedto.'</b>

         </div>
      </div>';   
      echo '<div class="row">
         <div class="col-xs-12">
         Type of Transfer: <b>'.$panganay.'</b>

         </div>
      </div>';

    
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
              
                   
                </tr>
              </thead>
                <tbody>';
                  
              

      $sql = "SELECT a.id ,b.* FROM `t_tempptr` a left join (SELECT a.id delid , accounttitle,item,yearoflife,typeofasset, concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, `propertyno` FROM `t_equipmentdeliverydetails` a left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife`,y.typeofasset FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = $selmytype and x.isactive =1 ) b on a.`itemid` = b.id where a.isactive = 1 and ifnull(a.`Status`,'') = '') b on a.`propertyno` = b.propertyno where a.createdby = $uid and typeofasset = $selmytype

  and a.tag = $selmytype

 ";
            
$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {
  echo '    <tr>

                    <td>'.$row['accounttitle'].'</td>
                    <td>'.$row['propertyno'].'</td>
                    <td>'.$row['description'].'</td>
                  
                    <td>1</td>
                    
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
    <button class="btn btn-primary" id="btnyessaveptr">Yes</button> &nbsp;
    <button class="btn btn-danger" data-dismiss="modal">No</button>

    </div>
 </div>';
?>

