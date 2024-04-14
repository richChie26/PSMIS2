<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $mnuasset = $_GET['mnutitle'];
   $txtsearchmyname = $_GET['txtsearchmyname'];


$sql = "SELECT a.`id`, a.`itemname` , a.`accounttitle` accounttitleid ,b.accounttitle  FROM `m_itemname` a 
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 

WHERE a.`isactive` = 1 
and a.`accounttitle` = $mnuasset
and a.itemname like '%".$txtsearchmyname."%'
order by a.`itemname` ASC 
"; 

$qry = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($qry)){
  echo '<tr class= "itemrowname" id="'.$row['id'].'|'.$row['itemname'] .'|'.$row['accounttitle'] .'" >
        <td>'.$row['accounttitle'].'</td>
       
        <td>'.ucwords(strtolower($row['itemname'])).'</td>
       
  </tr>';
}

?>