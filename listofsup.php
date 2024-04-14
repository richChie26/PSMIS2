<head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>


<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$sql = "SELECT `id`, `Suppliername`,
`Address`, `tin`, `contactNo`, `contactperson`, `contactpersonPosition`
 FROM `m_supplier` WHERE `isactive` = 1 order by `Suppliername` "; 

$qry = mysqli_query($con,$sql);

echo '

<div class= "row"> 
    <div class="col-xs-12"><table id="example"  style="width:100%"   class ="display">
    <thead style="background-color: #337ab7;color:white;"> <tr>
            <th>Supplier</th>
            <th>Contact Person</th>
            <th>Contact Number</th>
            <th>Position</th>
	</tr></thead><tbody id="listofsups">';
while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemrowsupplier" id="'.$row['id'].'|'.$row['Suppliername'].'" >
			  <td>'.$row['Suppliername'].'</td>
			  <td>'.$row['contactperson'].'</td>
              <td>'.$row['contactNo'].'</td>
              <td>'.$row['contactpersonPosition'].'</td>
	        </tr>';
}
echo '</tbody></table></div></div>';		
?>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>