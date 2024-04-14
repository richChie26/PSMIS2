<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
     $uid = $_SESSION["uid"] ;
    $mnuasset = $_GET['mnuasset'];
    $txtppe = $_GET['txtppe'];
    $yourppe = "";
    if($mnuasset == 2){
     $yourppe ="Semi Expendables";
    }elseif ($mnuasset) {
    $yourppe  = "Property Plant and Equipment";
    }
$sql = "Select * from (SELECT a.id ,

`item`,
b.accounttitle
,typeofassets, asset,yearoflife
FROM `m_equipent` a 

left join (SELECT x.id ,`accounttitle`, typeofassets ,y.id asset  FROM `m_accouttitle` x 
left join m_assets y on x.`typeofasset` = y.id and y.isactive = 1 
where x.isactive = 1 ) b on a.`accounttitle` = b.id 
where a.isactive = 1 ) ss
where asset = $mnuasset
and item like '%".$txtppe."%'
"; 


$qry = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($qry)){
  echo '<tr class= "itemroweq" id="'.$row['id'].'|'.$row['accounttitle'].'|'.$row['item'].'|'.$row['yearoflife'].'" >
        <td>'.$row['accounttitle'].'</td>
        <td>'.$row['item'].'</td>
        <td>'.$row['yearoflife'].'</td>
        <td>Piece</td>
  </tr>';
}
echo '</tbody></table></div></div>';  
?>