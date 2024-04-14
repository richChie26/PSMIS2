<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $mheader = $_POST["mheader"];
    $mname = $_POST["mname"];
    $moffice = $_POST["moffice"];
    $munits = $_POST["munits"];
    $maddress = $_POST["maddress"];

// $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt');  
// $path = 'img/';  
 
//             $img = $_FILES['image']['name'];
//             $tmp = $_FILES['image']['tmp_name'];

           
//             $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

  
//             $final_image = rand(1000,1000000).$img;

 
// if(in_array($ext, $valid_extensions)) 
// { 
// $path = $path.strtolower($final_image); 

// if(move_uploaded_file($tmp,$path)) 
// {

 
//     $sqls = "update  `a_agencyprofile`  
//     set 
    
//     `AgencyHeader` = '$mheader', 
//     `AgencyName` = '$mname', 
//     `RegionalOffice` = '$moffice',
//      `OperatingUnit` ='$munits', 
//      `AgencyAddess`= '$maddress',
//       `logo` = '$path'
//     ";
 
//     mysqli_query($con, $sqls);
// //include database configuration file
// header("Location:home.html "  );

// //echo $insert?'ok':'err';
// }
// } 
// else 
// {
// echo 'invalid';
// }
 
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
$path = 'img/'; // upload directory
if(!empty($_POST['name']) || !empty($_POST['email']) || $_FILES['image'])
{
$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
// get uploaded file's extension
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
// can upload same image using rand function
$final_image = rand(1000,1000000).$img;
// check's valid format
if(in_array($ext, $valid_extensions)) 
{ 
$path = $path.strtolower($final_image); 
if(move_uploaded_file($tmp,$path)) 
{
echo "<img src='$path' />";
$name = $_POST['name'];
$email = $_POST['email'];
//include database configuration file
 
    $sqls = "update  `a_agencyprofile`  
    set 
    
    `AgencyHeader` = '$mheader', 
    `AgencyName` = '$mname', 
    `RegionalOffice` = '$moffice',
     `OperatingUnit` ='$munits', 
     `AgencyAddess`= '$maddress',
      `logo` = '$path'
    ";
 
    mysqli_query($con, $sqls);
//echo $insert?'ok':'err';
header("Location:home.html "  );
}
} 
else 
{
echo 'invalid';
}
}

 
?>