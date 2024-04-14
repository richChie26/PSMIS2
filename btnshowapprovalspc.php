<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$rid  = $aarres['rid'];

$selPhysicalA = $_GET['selPhysicalA'];
$txtsource = $_GET['txtsource'];

if($selPhysicalA == 1 ){
echo '<table class ="table">
<thead style="background-color: #337ab7;color:white;">
<tr>
     
        <th><center>Code</center></th>
        <th><center>Source of Fund</center></th>
        <th><center>Date</center></th>
        <th><center>Print Preview</center></th>
        <th><center>Action</center></th>
</tr>

</thead>';
// btn-xs
$sqlshow = "SELECT `code`, `reportDate`, `status`,id FROM `t_rpciheader` WHERE isactive = 1 and  `rid` = $rid 
and `status` = 'For Approval' ";
// echo $sqlshow;
$qryshow = mysqli_query($con,$sqlshow);
            while($row = mysqli_fetch_array($qryshow)){
            echo '<tr>
            <td>'.$row['code'].'</td>
            <td>'.$txtsource.'</td>
            <td>'.$row['reportDate'].'</td>
            <td><center><a href="#" class="btnapprrpc" id="'.$row['code'].'|'.$row['id'].'"><span class="glyphicon glyphicon-print"></span></a></center></td>
            <td><center><button class= "btn btn-xs btn-primary btnrpcapprove" id="'.$row['code'].'|'.$row['id'].'">Approve</button>
            <button class= "btn btn-xs btn-danger btnrpcdisapprove" id="'.$row['code'].'|'.$row['id'].'">Disapprove</button></center>
            </td>
            </tr>';
            }
echo '</table>';
}else if ($selPhysicalA == 2){

}else if ($selPhysicalA == 3){
    
}

?>