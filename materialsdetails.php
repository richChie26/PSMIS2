<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;



  $btnid = $_GET['btnid'];
$tag = $_GET['tag'];

if($tag == 1 ){
    $sql = 'SELECT 


a.id ,
b.accounttitle,
a.item, `stockno`, `description`
,c.units

,

`titleid`,a.`units` unitsid,reorderpoint,d.id itemid 
FROM `m_materials` a 
left join m_accouttitle b on a.`titleid` = b.id and b.isactive =1 
left join m_units c on a.`units` = c.id and c.isactive = 1 
left join m_itemname d on a.item = d.id and d.isactive = 1 
where a.isactive = 1  and titleid = '.$btnid.'
    order by `description` Asc

    ';


$qry = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($qry)){
     echo ' <tr> <td>'.ucwords(strtolower( $row['accounttitle'])).'</td>
                <td>'.$row['stockno'].'</td>
                <td>'.ucwords(strtolower( $row['item'])).'</td>
                <td>'.ucwords(strtolower( $row['description'])).'</td>
                <td>'.ucwords(strtolower( $row['units'])).'</td>
                 <td>'.ucwords(strtolower( $row['reorderpoint'])).'</td>
              

     <td><center><a href="#" class="btnmatedit" id="
     '.$row['id']. '|'
     .$row['titleid'].'|'
     .ucwords(strtolower($row['item'])).'|'
     .$row['stockno'].'|'
     .$row['description'].'|'
     .$row['unitsid'].'|'
     .$row['reorderpoint'].'|'
     .$row['itemid'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="bntmatremove" id="'.$row['id'].'|'.$row['description'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';



    }
}else{
      $sqlll = "SELECT a.id,
                    b.accounttitle,
                    `item`, `accountcode`, `yearoflife`
                      ,a.`accounttitle` aid , c.units ,unitofmeasurement
                    FROM `m_equipent` a 
                    left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
                    left join m_units c on a.unitofmeasurement  = c.id and c.isactive =1 
                    where a.isactive = 1
                    and a.`accounttitle` = $btnid ";
                    $qrylll = mysqli_query($con,$sqlll);
                    while($rowll = mysqli_fetch_array($qrylll)){
                        echo '
                         <tr>
                              <td>'.$rowll['accounttitle'].'</td>
                              <td>'.$rowll['item'].'</td>
                         <td>'.$rowll['units'].'</td>
                              <td>'.$rowll['yearoflife'].'</td>
                              <td><center><a href="#" class="btneditccc" id="
     '.$rowll['id']. '|'
     .$rowll['accounttitle'].'|'
     .ucwords(strtolower($rowll['item'])).'|'
     .$rowll['unitofmeasurement'].'|'
     .$rowll['yearoflife'].'|'
     .$rowll['aid'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                              <td><center>
<a href="#" class="btnremovemyppe" id="'.$rowll['id']. '|'    .ucwords(strtolower($rowll['item'])).'">
<span style="color:red;" class="glyphicon glyphicon-minus"></span></a></center>
                              </td> 
                          </tr>

                        ';
                    }
}

?>

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>