
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

$sql = 'SELECT `id`, `menucode`, `menuname`, `link`,tag  FROM `a_menu` WHERE isactive = 1  order by `menucode`  Asc';

	$qry = mysqli_query($con,$sql);


    ?>
<div class= "row"> <div class="col-xs-12">
            <table id="userTable"  class ="table table-striped display" >
                <thead style="background-color: #337ab7;color:white;">
                    <tr>
                        <th >Menu Code</th>
                        <th >Menu Name</th>
                        <th >Module Name</th>
                        <th >Link</th>
                        <th >Edit</th>
                        <th >Delete</th>
                    </tr>
                </thead>
                <tbody>
    <?php
while($row = mysqli_fetch_array($qry)){
    $id = $row['id'];
    $menucode = $row['menucode'];
    $menuname = $row['menuname'];
    $tag = $row['tag'];
    $link = $row['link'];
   


    echo '<tr id= "'. $menuname .'"><td>'. $menucode . '</td>'.
    '<td>'. $menuname .'</td>'.
    '<td>'. $tag .'</td>'.
    '<td>'. $link .'</td>'.
   
     '<td><center><a href="#" class="btnmnuedit" id="'.$id.'|'. $menucode .'|'. $menuname
     .'|'. $link.'|'. $tag 
     .'"><span style="color:#337ab7;" class="glyphicon glyphicon-edit"  ></span></a></center></td>'.
     '<td><center><a href="#" class="bntmnuremove" id="'.$id.'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td>'.
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
  $(document).ready(function() {
    $('#userTable').DataTable();
  });
</script>