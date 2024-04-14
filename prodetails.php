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

$sql = 'SELECT up.`profileid`, lname,mname,fname
,ifnull(au.username,"") username, concat(`fname`," ", substring(`mname`,1,1),". ",lname  ) Completename , `contactNo` ,`address` , ifnull(up.position,"") Position , ifnull(c.`ResponsibilityCenter`,"") ResposibilityCenter ,ifnull(d.section,"") Section

,up.`Position` pos ,up.`ResponsibilityCenter` rc ,up.`Section` sec

FROM `u_profile` up left join a_user au on up.`profileid` = au.profileid and au.isactive = 1 left join a_responsibilitycenter c on up.`ResponsibilityCenter` = c.id and c.isactive = 1 left join a_section d on up.`Section` = d.id and d.isactive =1 where up.isactive = 1 order by concat(lname,", ",`fname`," ", substring(`mname`,1,1)) ASC';

	$qry = mysqli_query($con,$sql);


    ?>
<div class= "row"> <div class="col-xs-12">
            <table id="example"  style="width:100%"   class ="display">
                <thead style="background-color: #337ab7;color:white;">
                <tr>
                     
                        <th >Complete Name</th>
                        <th >Contact Number</th>
                        <th >Address</th>
                        <th >Position</th>
                        <th >Responsibility Center</th>
                        <th >Section</th>
                         <th >Edit</th> 
                        <th >Remove</th>
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

    // $return_arr[] = array("profileid" => $profileid,
    //                 "username" => $username,
    //                 "Completename" => $Completename,
    //                 "contactNo" => $contactNo,
    //                 "address" => $address);
    echo 
    '<td>'. $Completename .'</td>'.
    '<td>'. $contactNo .'</td>'.
     '<td>'. $address .'</td>'.
     '<td>'. $row['Position'] .'</td>'.
    '<td>'. $row['ResposibilityCenter'] .'</td>'.
     '<td>'. $row['Section'] .'</td>'.
     '<td><center><a href="#" class="btbproedit" id="
     '.$row['profileid']. '|'
     .$row['fname'].'|'
     .$row['lname'].'|'
     .$row['mname'].'|'
     .$row['contactNo'].'|'
     .$row['address'].'|'
     .$row['pos'].'|'
     .$row['rc'].'|'
     .$row['sec'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>'.

     '<td><center><a href="#" class="bntproremove" id="'.$profileid.'|'.$row['Completename'] .'">
     <span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td>'.
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