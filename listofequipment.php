
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
    $mnuasset = $_GET['mnuasset'];
    $yourppe = "";
    if($mnuasset == 2){
     $yourppe ="Semi Expendables";
    }elseif ($mnuasset) {
    $yourppe  = "Property Plant and Equipment";
    }
$sql = "Select * from (SELECT a.id ,

`item`,
b.accounttitle
,typeofassets, asset,yearoflife
FROM `m_equipent` a 

left join (SELECT x.id ,`accounttitle`, typeofassets ,y.id asset  FROM `m_accouttitle` x 
left join m_assets y on x.`typeofasset` = y.id and y.isactive = 1 
where x.isactive = 1 ) b on a.`accounttitle` = b.id 
where a.isactive = 1 ) ss
where asset = $mnuasset
"; 

$qry = mysqli_query($con,$sql);

echo '

<div class= "row"> <div class="col-xs-12"><table id="example"  style="width:100%"   class ="display">
                <thead style="background-color: #337ab7;color:white;"> <tr>
		<th>Account Title</th>
    <th>Item Name</th>
		<th>Estimated Useful Life:</th>

		<th>Units</th>
		</tr></thead><tbody id="listofmats">
		';

while($row = mysqli_fetch_array($qry)){
	echo '<tr class= "itemroweq" id="'.$row['id'].'|'.$row['accounttitle'].'|'.$row['item'].'|'.$row['yearoflife'].'" >
        <td>'.$row['accounttitle'].'</td>
			  <td>'.$row['item'].'</td>
			  <td>'.$row['yearoflife'].'</td>
			  <td>Piece</td>
	</tr>';
}
echo '</tbody></table></div></div>';		
?>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>