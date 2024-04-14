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

$sql = "SELECT 
`id`, `code`, `FinancingSource`, `Authorization`, `Fundcategory`
FROM `m_fundcluster` WHERE `isactive` = 1 order by code ASC "; 

$qry = mysqli_query($con,$sql);

echo '

<div class= "row"> <div class="col-xs-12"><table id="example"  style="width:100%"   class ="display">
                <thead style="background-color: #337ab7;color:white;"> <tr>
		<th>Code</th>
		<th>Financing Source</th>
		<th>Authorization</th>
		<th>Fund Category</th>
		</tr></thead><tbody id="listofmats">
		';

while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemrowfund" id="'.$row['id'].'|'.$row['Fundcategory'].'" >
			  <td>'.$row['code'].'</td>
			  <td>'.$row['FinancingSource'].'</td>
			  <td>'.$row['Authorization'].'</td>
			  <td>'.$row['Fundcategory'].'</td>
	</tr>';
}
echo '</tbody></table></div></div>';		
?>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>