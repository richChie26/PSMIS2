<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename,a.Position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$positon = $aarres['Position'];
$completename  = $aarres['completename'];
$rid = $aarres['rid'];
?>


 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"></div>
<!-- First row -->

  
<div class="row">
       <div class="col-xs-12">
        <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home" id="irrupf"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;For Submission</a></li>
    <li><a data-toggle="tab" href="#menu1" id="irrups">Submitted</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <br/>
   
<button class="btn btn-primary" id="btnirrupsend" style="float: right;">Submit</button>
&nbsp;&nbsp;
<button class="btn btn-primary" id="btnirrupprint" style="float: left;display:none">Print</button>   
<div class="row">
	<div class="col-xs-12"></div>
</div>

      <div class="row">
         <div class="col-xs-12">
           <div id="irrup1">
          
            
           </div>
         </div>
    </div>
     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "irrupe"></div>

    </div>
   
 
  </div>


 
        </div>
    

        





</div>
<div id="receivingbox"></div>

