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
$tag = $_GET['tag'];
$sql = "SELECT `id`, `menucode`, `menuname` FROM `a_menu` WHERE isactive = 1 and `Tag`  = '$tag' "; 

$qry = mysqli_query($con,$sql);

echo '

<div class= "row"> 
    <div class="col-xs-12"><table id="example"  style="width:100%"   class ="display">
    <thead style="background-color: #337ab7;color:white;"> <tr>
            <th>Menu Code</th>
            <th>Menu Name</th>
   
	</tr></thead><tbody id="listofmnus">';
while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemrowmnus" id="'.$row['id'].'|'.$row['menucode'].'|'.$row['menuname'].'" >
			  <td>'.$row['menucode'].'</td>
			  <td>'.$row['menuname'].'</td>
             
	        </tr>';
}
echo '</tbody></table></div></div>';		
?>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>