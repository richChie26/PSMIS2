<?php

include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $txtsearchprofile = $_GET['txtsearchprofile'];
$sql = 'SELECT up.`profileid`, lname,mname,fname
,ifnull(au.username,"") username, concat(lname,", ",`fname`," ", substring(`mname`,1,1),".") Completename , `contactNo` ,`address` , ifnull(up.position,"") Position , ifnull(c.`ResponsibilityCenter`,"") ResposibilityCenter ,ifnull(d.section,"") Section

,up.`Position` pos ,up.`ResponsibilityCenter` rc ,up.`Section` sec

FROM `u_profile` up left join a_user au on up.`profileid` = au.profileid and au.isactive = 1 left join a_responsibilitycenter c on up.`ResponsibilityCenter` = c.id and c.isactive = 1 left join a_section d on up.`Section` = d.id and d.isactive =1 where up.isactive = 1 
    and  concat(lname,", ",`fname`," ", substring(`mname`,1,1),".") like "%'.$txtsearchprofile.'%"
order by concat(lname,", ",`fname`," ", substring(`mname`,1,1)) ASC';

	$qry = mysqli_query($con,$sql);


    ?>
<div class= "row"> <div class="col-xs-12">
            <table id="userTable"  class ="table table-striped">
                <thead style="background-color: #337ab7;color:white;">
                   
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
    echo '<tr><td>'. $username . '</td>'.
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

     '<td><center><a href="#" class="bntproremove" id="'.$profileid.'|'.$row['Completename'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td>'.
     '</tr>';

}

// Encoding array in JSON format
// echo json_encode($return_arr);
     mysqli_close($con);
?>


</tbody>
            </table></div> 

    </div>