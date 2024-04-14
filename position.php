             <?php

include('cn.php');
    $sqlposition = "SELECT `id`, `position` FROM `a_position` WHERE `isactive` = 1 
order by `position` ASC";
  $qryposition = mysqli_query($con,$sqlposition);


          while ($rowpos = mysqli_fetch_array($qryposition)) {
                  echo '<option value="'. $rowpos['position'].'">'. $rowpos['position'].'</option>' ;

                }

              ?>