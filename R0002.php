<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $sql ="SELECT `id`, `typeofassets` FROM `m_assets` WHERE isactive = 1 ";

    $qry = mysqli_query($con,$sql);

    $sqlunits = "SELECT `id`, `units` FROM `m_units` WHERE `isactive` = 1 order by `units` Asc";

    $qryunits = mysqli_query($con,$sqlunits);



?>

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"></div>
<!-- First row -->

<div class="panel panel-primary">
   <div class="panel-heading">List of RSMI</div>
  <div class="panel-body" >
<div class="row">
       <div class="col-xs-12">
        <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;For Submission</a></li>
    <li><a data-toggle="tab" href="#menu1" id="tabnewrsmi">Submitted</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <br/>


      <div class="row">
         <div class="col-xs-12">
           <div id="tsmli">
          
            
           </div>
         </div>
    </div>
     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "mynewrsmi"></div>

    </div>
   
 
  </div>


 
        </div>
    

        
</div>

</div></div>
<div id="receivingbox"></div>
