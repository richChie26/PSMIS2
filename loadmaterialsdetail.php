<?php

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $btnid = $_GET['btnid'];


                        $sql1 = 'SELECT 
              a.id ,
              b.accounttitle,
              d.itemname  item, `stockno`, `description`
              ,c.units

              ,

              `titleid`,a.`units` unitsid,reorderpoint,d.id itemid 
              FROM `m_materials` a 
              left join m_accouttitle b on a.`titleid` = b.id and b.isactive =1 
              left join m_units c on a.`units` = c.id and c.isactive = 1 
              left join m_itemname d on a.itemid = d.id and d.isactive = 1 
              where a.isactive = 1  and titleid = '.$btnid.'
                  order by `description` Asc


    ';
 
$qry1 = mysqli_query($con,$sql1);
  while($row = mysqli_fetch_array($qry1)){
    echo ' <tr> <td>'. $row['accounttitle'].'</td>
                <td>'. $row['stockno'].'</td>
                <td>'. $row['item'].'</td>
                <td>'. $row['description'].'</td>
                <td>'. $row['units'].'</td>
                 <td>'. $row['reorderpoint'].'</td>
              

     <td><center><a href="#" class="btnmatedit" id="
     '.$row['id']. '|'
     .$row['titleid'].'|'
     .$row['item'].'|'
     .$row['stockno'].'|'
     .$row['description'].'|'
     .$row['unitsid'].'|'
     .$row['reorderpoint'].'|'
     .$row['itemid'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="bntmatremove" id="'.$row['id'].'|'.$row['description'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


  }

                    ?>
