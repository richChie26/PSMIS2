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

$sql = 'SELECT id, 
`Groupnane`, `Description`
FROM `a_group` WHERE isactive = 1 
order by `Groupnane` ASC';

	$qry = mysqli_query($con,$sql);


    ?>
<div class= "row"> <div class="col-xs-12">
            <table id="example"  class ="table table-striped">
                <thead style="background-color: #337ab7;color:white;">
                    <tr>
                        <th >Group Name</th>
                        <th >Description</th>
              
                        <th style="text-align:center">Edit</th>
                        <th style="text-align:center">Delete</th>
                    </tr>
                </thead>
                <tbody>
    <?php
while($row = mysqli_fetch_array($qry)){
    $id = $row['id'];
    $Groupnane = $row['Groupnane'];
    $Description = $row['Description'];
  
   


    echo '<tr id= "'. $id .'"><td>'. $Groupnane . '</td>'.
    '<td>'. $Description .'</td>'.
 
   
     '<td><center><a href="#" class="btneditgroup" id="'.$id.'"><span style="color:#337ab7;" class="glyphicon glyphicon-edit"  ></span></a></center></td>'.
     '<td><center><a href="#" class="btnremovegroup" id="'.$id.'|'.$Groupnane. '"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td>'.
     '</tr>';

}

// Encoding array in JSON format
// echo json_encode($return_arr);
     mysqli_close($con);
?>


</tbody>
            </table></div> 

    </div>
    <script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>