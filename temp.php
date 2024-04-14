
<head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
    <style>
  <thead style="background-color: #337ab7;color:white;"> 
</style>
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

$arr =mysqli_fetch_array($qryres);
$rid = $arr['rid'];
?>
  <div class="row" >



	    <div class="col-sm-11 problema" id="anakproblema"
	    	>
	      <div id="richiedetails">


		  


	      </div>
	   
	   	   </div>
	</div>

<script>
	$(document).ready(function () {
    $('table.display').DataTable();
});
</script>
