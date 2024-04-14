<?php
include('cn.php');

                $sqlsec = "SELECT id, `section` FROM `a_section` WHERE isactive =1 order by `section` ASC ";
                 $qrysec = mysqli_query($con,$sqlsec);
            while ($rowsec = mysqli_fetch_array($qrysec)) {
                  echo '<option value="'. $rowsec['id'].'">'. $rowsec['section'].'</option>' ;

                }

?>