
<head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>

<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sql = "SELECT `id`, `position` FROM `a_position` order by `position` ASC";

$qry = mysqli_query($con,$sql);
?>

 <form action="#" method="post" id="frmMenu">

   <div id="myalert">
     <div class="alert alert-info"> <strong>Information!</strong> Please fill-up the form correctly! .</div>
   </div>

   <div class="row">
     <div class="col-xs-4">

       <div class="form-group has-feedback">
         <input type="text" class="form-control" placeholder="Position" id="txtpositiondata" name="txtpositiondata"
           required="true">
         <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>

       </div>
     </div>

   </div>

   <div class="row">
     <div class="col-xs-4">
       <div class="form-group has-feedback">
         <button class="btn btn-primary" id="btnsaveposition"><span
             class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>

       </div>
     </div>

     <div class="col-xs-8">
       <div class="form-group has-feedback">
         <button class="btn btn-primary" id="btnimportposition" style="float:right;"><span
             class="glyphicon glyphicon-import">&nbsp;Import</span></button>

       </div>
     </div>

   </div>
   <div class="row">
     <div class="col-xs-6">
       <div class="form-group has-feedback">
         <input type="text" class="form-control" placeholder="Search Position" id="txtsearchposition"
           name="txtsearchposition" required="true" style="display:none;">
         <span class="glyphicon glyphicon-zoom-in form-control-feedback text-info" style="display:none;"></span>

       </div>
     </div>
     <div class="col-xs-1">
       <div class="form-group has-feedback">
         <button class="btn btn-info" id="btnsearchposition" style="display:none;"><span
             class="glyphicon glyphicon-zoom-in"></span></button>

       </div>
     </div>

   </div>

 </form>
 <div class="row">
   <div class="col-xs-12">
     <div>
       <table id="example" style="width:100%" class="display">
         <thead style="background-color: #337ab7;color:white;">
           <tr>
             <th>Position</th>

             <th>
               <center>Edit</center>
             </th>
             <th>
               <center>Remove</center>
             </th>
           </tr>
         </thead>
         <tbody>
           <?php

$sql = ' SELECT `id`, `position` FROM `a_position`  where isactive = 1 
order by `position` ASC';
$qry = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($qry)){
echo ' <tr> <td>'. $row['position'].'</td>
               
 <td><center><a href="#" class="btnpositionedit" id="'.$row['id']. '|'.$row['position'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
            <td><center><a href="#" class="btnpositiondel" id="'.$row['id'].'|'.$row['position'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


}

?>

         </tbody>
       </table>
     </div>
   </div>
 </div>

 <script>
   $(document).ready(function() {
     $('#example').DataTable();
   });
 </script>