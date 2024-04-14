<?php
include('cn.php');
  $sqlrc = "SELECT id,`ResponsibilityCenter` FROM `a_responsibilitycenter` WHERE `isactive` = 1 
order by `ResponsibilityCenter` ASC";
  $qryrc = mysqli_query($con,$sqlrc);
            while ($rowrc = mysqli_fetch_array($qryrc)) {
                  echo '<option value="'. $rowrc['id'].'">'. $rowrc['ResponsibilityCenter'].'</option>' ;

                }

              ?>