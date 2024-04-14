
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

$sql = 'SELECT
               userid, up.`profileid`,ifnull(au.username,"") username,

                concat( `fname`, " " , substring(`mname`,1,1),". ", lname) "Employee Name" ,
                 `contactNo`
                ,`address`,Position,rc.ResponsibilityCenter

                FROM `u_profile` up 
                left join a_user au on up.`profileid` = au.profileid and au.isactive = 1 
                left join a_responsibilitycenter  rc on up.responsibilitycenter = rc.id and rc.isactive
                where up.isactive = 1  and ifnull(au.username,"") != ""
                order by  concat(lname,", ",`fname`," ", substring(`mname`,1,1)) ASC';

	$qry = mysqli_query($con,$sql);


    ?>
<div class="row">
    <div class="col-xs-12">
        <table  class="table table-striped" id="example" >
            <thead style="background-color: #337ab7;color:white;">
                <tr>
                    <th>User Name</th>
                    <th>Employee Name</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Responsibility Center</th>
                    <th>Position</th>
                    <th>Reset Password</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
while($row = mysqli_fetch_array($qry)){
    $id = $row['userid'];
    $username = $row['username'];
    $Completename = $row['Employee Name'];
      $contactNo = $row['contactNo'];
    $address = $row['address'];
    $Position = $row['Position'];
    $ResponsibilityCenter = $row['ResponsibilityCenter'];


    echo '<tr id= "'. $id .'"><td>'. $username . '</td>'.
    '<td>'. $Completename .'</td>'.
    '<td>'. $contactNo .'</td>'.
        '<td>'. $address .'</td>'.   
        '<td>'. $ResponsibilityCenter .'</td>'.   
        '<td>'. $Position .'</td>'.   
        '<td><button class="btn btn-primary btn-sm btnreset" id="btn|'.$id.'|'. $Completename. '">Reset</button ></td>'.   
     '<td><center><a href="#" class="btneditaccount" id="'.$id. '|'. $username.'"><span style="color:#337ab7;" class="glyphicon glyphicon-edit"  ></span></a></center></td>'.
     '<td><center><a href="#" class="btnremoveAccount" id="'.$id.'|'.$username. '"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td>'.
     '</tr>';

}

// Encoding array in JSON format
// echo json_encode($return_arr);
     mysqli_close($con);
?>

            </tbody>
        </table>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>