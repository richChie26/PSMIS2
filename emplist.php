

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
                up.`profileid`,ifnull(au.username,"") username,

                concat(lname,", ",`fname`," ", substring(`mname`,1,1)) Completename , `contactNo`
                ,`address`

                FROM `u_profile` up 
                left join a_user au on up.`profileid` = au.profileid and au.isactive = 1 
                where up.isactive = 1  and ifnull(au.username,"") = ""
                order by  concat(lname,", ",`fname`," ", substring(`mname`,1,1)) ASC';

	$qry = mysqli_query($con,$sql);


    ?>
<div class= "row"> <div class="col-xs-12">
            <table  id="example"  class ="table table-striped">
                <thead style="background-color: #337ab7;color:white;">
                    <tr>
                        <th >Username</th>
                        <th >Complete Name</th>
               
                        <th >Contact Number</th>
                        <th >Address</th>
                       
                    </tr>
                </thead>
                <tbody>
    <?php
while($row = mysqli_fetch_array($qry)){
    $profileid = $row['profileid'];
    $username = $row['username'];
    $Completename = $row['Completename'];

    $contactNo = $row['contactNo'];
    $address = $row['address'];

    $return_arr[] = array("profileid" => $profileid,
                    "username" => $username,
                    "Completename" => $Completename,
                    "contactNo" => $contactNo,
                    "address" => $address);
    echo '<tr class="rihieid" id="'.$profileid.'|'.$Completename.'"><td>'. $username . '</td>'.
    '<td class ="tdclass" >'. $Completename .'</td>'.
    '<td>'. $contactNo .'</td>'.
     '<td>'. $address .'</td>'. 
    
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