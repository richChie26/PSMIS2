<?php
include('cn.php');
  $sqlunits = "SELECT `id`, `units` FROM `m_units` WHERE `isactive` = 1 order by `units` Asc";

    $qryunits = mysqli_query($con,$sqlunits);

      while($row = mysqli_fetch_array($qry)){
                  echo '<option value ="'. $row['id'].'" >'. $row['accounttitle'].'</option>'; 
              } 	
?>