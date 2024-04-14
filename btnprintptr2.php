<?php
	include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$mydata = $_GET['mydata'];
    // $mydata = "2021-09-0001";
 
    $sqlres = "SELECT a.`ResponsibilityCenter`,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$completename = $aarres['completename'];
?>
<div class="row">
   <div class="col-xs-5"><img src="img/logo.bmp" 
style="float: right;  
" 
width="80" height="80"></div>
   <div class="col-xs-5"><b>Republic of the Philippines</b><br/>          
<b>Department of Environment and Natural Resources</b> <br/>
<b><?php echo $ResponsibilityCenter; ?></b>         
            

</div>
   
</div>
<center><h5><b>PROPERTY TRANSFER REPORT</b></h5> </center>