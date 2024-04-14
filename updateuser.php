<?php 
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;

  $sql = "SELECT a.profileid, trim(concat( substring(`fname`,1,1),'.', `lname` ))  uname  FROM `u_profile` a 
  left JOIN a_user b on a.profileid = b.profileid and b.isactive =1 
  where a.isactive =1 and ifnull(b.profileid,'') = '' ";

  $qry = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($qry)){
    $pass = md5('abcd');
    $profileid = $row['profileid'];
    $uname = $row['uname'];

    $sqlinsert = "insert into `a_user` (`username`, `profileid`, `password`, `isactive`, `createdby`, `creationdate`)
    VALUES ('$uname', $profileid, '$pass', 1, $uid, now())";

    //  mysqli_query($con,$sqlinsert );
  }
?>