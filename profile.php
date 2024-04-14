<?php
	include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
	 $sql = "SELECT 

`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
     

if(mysqli_num_rows($qry)>0){
    $row = mysqli_fetch_array($qry);
	$id = $row['userid'];
    $username = $row['username'];
    $name = $row['Completename'];
    $contactNo = $row['contactNo'];
    $pic = $row['pic'];

    $result[] = array("id" => $id,
                    "username" => $username,
                    "Completename" => $name,
                    "contactNo" => $contactNo,
                	"pic" => $pic);
   

     
     // array_push($result['login'], $index);
   // $result["success"] = $arr['username'];    
     echo json_encode($result);
     mysqli_close($con);
}else{
   $result["success"] = 1;
     echo json_encode($result);
     mysqli_close($con);   
}
?>