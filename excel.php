<?php
  include 'cn.php';




  $sql="select * from vwitemDetails";


  $qry= mysqli_query($con,$sql);
  $chie = array();

  while( $rows = mysqli_fetch_assoc($qry) ) {
    $chie[] = $rows;
  }

  $filename = "phpflow_data_export_".date('Ymd') . ".xls";     
  header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
ExportFile($chie);


function ExportFile($records) {
    $heading = false;
      if(!empty($records))
        foreach($records as $row) {
        if(!$heading) {
          // display field/column names as a first row
          echo implode("\t", array_keys($row)) . "\n";
          $heading = true;
        }
        echo implode("\t", array_values($row)) . "\n";
        }
      exit;
  }

?>