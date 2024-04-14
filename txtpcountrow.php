<?php
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;
  $id = $_GET['id'];
$itemid = $_GET['itemid'];
$dtpReportDate = $_GET['dtpReportDate'];
$calc = $_GET['calc'];
$newval = $_GET['newval'];
$ave = $_GET['ave'];
$totss = $_GET['totss'];
// echo $newval;
$sqlll = " select id from  t_tempitemcount where createdBy = $uid and 
 itemid = $itemid and rid = $id and datereport = '$dtpReportDate'";  
$qryyy = mysqli_query($con,$sqlll);
if($newval == "" ){
  $sql = "
  delete from  t_tempitemcount  
                where createdBy = $uid and  itemid = $itemid  and rid = $id  and datereport = '$dtpReportDate'
  ";
$qry = mysqli_query($con,$sql);
  //  echo $sql;
 
 
}elseif(mysqli_num_rows($qryyy) > 0 ){
  $sql = "
  update t_tempitemcount set qty =$newval
                ,shorttage ='$calc' 
                where createdBy = $uid and  itemid = $itemid  and rid = $id 
                and datereport = '$dtpReportDate'
  ";
$qry = mysqli_query($con,$sql);
}else{
$sql = "insert into  `t_tempitemcount`(`rid`, `itemid`, `datereport`, `qty`, `shorttage`, `createdBy`,`Total`, `ave`)values
($id , $itemid,'$dtpReportDate' ,$newval, '$calc', $uid,$totss, $ave)";
$qry = mysqli_query($con,$sql);
}
// echo $sql ;
$sqlll = " select sum(qty) qty , sum(shorttage) shorttage from  t_tempitemcount where createdBy = $uid and  itemid = $itemid
and datereport = '$dtpReportDate' ";
$qty = "";

$qrysss = mysqli_query($con,$sqlll);
while($row = mysqli_fetch_array($qrysss)){
  $qty = $row['qty'] . '|'.$row['shorttage']  .'|' .$itemid;
}

   echo $qty ;
?>