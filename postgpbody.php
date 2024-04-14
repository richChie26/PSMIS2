<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$sql = "SELECT `itemno`, `item`,c.accounttitle reclassfrom , d.accounttitle reclassTo , `dateReclass` FROM `t_reclass` a 
left join m_equipent b on a.`itemid`  = b.id and b.isactive =1 
left join m_accouttitle c on a.`reclassfrom` = c.id and c.isactive =1 
left join m_accouttitle d on a.`reclassTo` = d.id and d.isactive =1
";
$qry = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($qry)){
    echo "<tr>";
    echo "<td>" . $row['itemno'] . "</td>" ;
    echo "<td>" . $row['item'] . "</td>" ;
    echo "<td>" . $row['reclassfrom'] . "</td>" ;
    echo "<td>" . $row['reclassTo'] . "</td>" ;
    echo "<td>" . $row['dateReclass'] . "</td>" ;
    echo "</tr>";
}

?>