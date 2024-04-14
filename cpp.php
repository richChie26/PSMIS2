<?php 
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $currentpassword = md5($_GET['currentpassword']);
    $newpassword = md5($_GET['newpassword']);
    $confirmpassword = md5($_GET['confirmpassword']);

    // $currentpassword = md5('1');
    // $newpassword = md5('12');
    // $confirmpassword = md5('123');

    $sql = "SELECT `userid`,`password` FROM `a_user` WHERE `isactive` = 1 and userid = $uid ";
    $qry = mysqli_query($con,$sql);
    $arr = mysqli_fetch_array($qry);
    $password = $arr['password'];
if($password != $currentpassword){
	$result[] = array("msg" => "Old Password is not match" , "tag" =>"1");
}elseif($newpassword != $confirmpassword ){
	$result[] = array("msg" => "Confirm Password is not match","tag" => "2");
}else{
	$result[] = array("msg" => "Password Successfully Updatate","tag"=>"3");


	$sqlupdate = "update a_user set password = '$newpassword'
	where userid = $uid";
	mysqli_query($con,$sqlupdate);
}
    
 echo json_encode($result);
     mysqli_close($con);
?>