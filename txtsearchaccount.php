<?php

include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $txtsearchaccount = $_GET['txtsearchaccount'];
$sql = 'SELECT
               userid, up.`profileid`,ifnull(au.username,"") username,

                concat(lname,", ",`fname`," ", substring(`mname`,1,1),".") Completename , `contactNo`
                ,`address`

                FROM `u_profile` up 
                left join a_user au on up.`profileid` = au.profileid and au.isactive = 1 
                where up.isactive = 1  and ifnull(au.username,"") != ""
                and   concat(lname,", ",`fname`," ", substring(`mname`,1,1),".")  like "%'.$txtsearchaccount .'%"
                order by  concat(lname,", ",`fname`," ", substring(`mname`,1,1)) ASC';

	$qry = mysqli_query($con,$sql);


    ?>
<div class= "row"> <div class="col-xs-12">
            <table id="userTable"  class ="table table-striped">
                <thead style="background-color: #337ab7;color:white;">
                    <tr>
                        <th >User Name</th>
                        <th >Completename</th>
                        <th >Contact Number</th>
                        <th >Address</th>
                        <th >Edit</th>
                        <th >Delete</th>
                    </tr>
                </thead>
                <tbody>
    <?php
while($row = mysqli_fetch_array($qry)){
    $id = $row['userid'];
    $username = $row['username'];
    $Completename = $row['Completename'];
      $contactNo = $row['contactNo'];
    $address = $row['address'];
   


    echo '<tr id= "'. $id .'"><td>'. $username . '</td>'.
    '<td>'. $Completename .'</td>'.
    '<td>'. $contactNo .'</td>'.
        '<td>'. $address .'</td>'.   
   
     '<td><center><a href="#" class="btneditaccount" id="'.$id. '|'. $username.'"><span style="color:#337ab7;" class="glyphicon glyphicon-edit"  ></span></a></center></td>'.
     '<td><center><a href="#" class="btnremoveAccount" id="'.$id.'|'.$username. '"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td>'.
     '</tr>';

}

// Encoding array in JSON format
// echo json_encode($return_arr);
     mysqli_close($con);
?>


</tbody>
            </table></div> 

    </div>