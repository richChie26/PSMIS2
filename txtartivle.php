
<head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
    <style>
  <thead style="background-color: #337ab7;color:white;"> 
</style>

<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $mnuasset = $_GET['mnuasset'];
   

// echo $mnuasset;
$sql = "
Select * from 
(SELECT a.`id`, a.`itemname` , a.`accounttitle` accounttitleid ,b.accounttitle 
,case when typeofasset = 2 then 
ifnull( (
    
    SELECT `itemno` FROM `m_equipent` x 
      left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive =1 
        WHERE x.isactive = 1  and y.typeofasset = 2   and x.item = a.itemname limit 1 
    ) ,'N/A')

    when typeofasset = 3 then 
    ifnull(  (
    
      SELECT `itemno` FROM `m_equipent` x 
        left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive =1 
          WHERE x.isactive = 1  and y.typeofasset = 3   and x.item = a.itemname limit 1 
      ),'N/A')
     end   mycols
 FROM `m_itemname` a 
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 

WHERE a.`isactive` = 1  



and a.`accounttitle` = $mnuasset ) a 

order by itemname ASC 
"; 


//  echo $sql;
$qry = mysqli_query($con,$sql);

echo '
<div class="row">
   <div class="col-xs-8">
       

      
        
        </div>
         <div class="col-xs-1">
        
        </div> 
</div>
<div class= "row"> <div class="col-xs-12"><table  class="display" style="width:100%;">
                <thead style="background-color: #337ab7;color:white;"> <tr>
    <th>Account Title</th>
  
    <th>Item Name</th>
  
    </tr></thead><tbody id="listofmyname">
    ';

while($row = mysqli_fetch_array($qry)){
  echo '<tr class= "itemrowname" id="'.$row['id'].'|'.$row['itemname'] .'|'.$row['accounttitle'] .'" >
        <td>'.$row['accounttitle'].'</td>
       
        <td>'.ucwords(strtolower($row['itemname'])).'</td>
       
  </tr>';
}
echo '</tbody></table></div></div>';    
?>
<script>
	$(document).ready(function () {
    $('table.display').DataTable();
});
</script>