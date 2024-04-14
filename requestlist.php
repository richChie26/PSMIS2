<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$txtpurpose = $_GET['txtpurpose'];

$dtpdate =  strtotime($_GET['dtpdate']);
$formatted_date = date("F d, Y ", $dtpdate);

    $sql = "SELECT a.id ,b.accounttitle, stockno , `itemname`,  `description`, a.qty, `units` FROM `t_temprec` a
left join (SELECT  x.id, z.accounttitle, stockno ,item itemname,  `description`, y.`units` FROM `m_materials` x 
left join m_accouttitle z on x.`titleid` = z.id  and z.isactive = 1 
left join m_units y on x.`units` = y.id and y.isactive  = 1
left join m_itemname za on x.item = za.id and za.isactive =1            
           
where x.isactive = 1) b on a.itemid = b.id 
where `createdby` = $uid ";
echo '
<center><h3>Inventory Requested</h3></center><br/>';
echo '<div class="row">
<div class="col-xs-2">  
      <span style="font-weight:bold">Date  Requested: </span>
</div>
<div class="col-xs-9">' . $formatted_date .'</div>
</div>';

echo '<div class="row">
<div class="col-xs-2"> <span style="font-weight:bold">Purpose:</span></div>
  <div class="col-xs-9">' . $txtpurpose .'</div>
  </div><br/>';

echo '<div class="row">
<div class="col-xs-12"><table  class="table table-striped" >';

echo ' <thead style="background-color: #337ab7;color:white;">
        <tr>
          <th>Stock No</th>
          <th>Item</th>
          <th>Description</th>
          <th>Qty</th>
          <th>Units</th>
        </tr></thead>
        ';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
		echo ' <tr> <td>'. $row['stockno'].'</td>
                <td>'. $row['itemname'].'</td>
                
                <td>'. $row['description'].'</td>
                 <td>'. $row['qty'].'</td>
                <td>'. $row['units'].'</td>
               
                

     
                </tr>';


	}
  echo '</table>
<button class="btn btn-primary" id="btnyesreq">Yes</button>
<button class="btn btn-danger" id="btnnoreq">No</button>
  </div></div>';
?>