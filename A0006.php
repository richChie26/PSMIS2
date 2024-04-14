
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


$sql = "SELECT `id`, `Groupnane` FROM `a_group` WHERE isactive = 1 order by `Groupnane` ASC";

$qry = mysqli_query($con,$sql);
?>

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>

       <div class="row">
          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Units of Measurement" id="Units" name= "Units" required="true">
            <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>
       
          </div>
        </div>
      
      

        
  </div> 
 
   <div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnsaveunits"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
          </div>
        </div>

   </div>
   
     
    </form> 
    <div class="row">
         <div class="col-xs-12">
           <div >
             <table  class="table table-striped" id="example">
               <thead style="background-color: #337ab7;color:white;">
                <tr>
                    <th>Units Name</th>
                    
                    <th>Edit</th>
                    <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails">
<?php

$sql = ' SELECT `id`, `units` FROM `m_units` where isactive = 1 

    order by units ASC';
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
		echo ' <tr> <td>'. $row['units'].'</td>
                   
     <td><center><a href="#" class="btnunitsedit" id="'.$row['id']. '|'.$row['units'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnunitsremove" id="'.$row['id'].'|'.$row['units'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>

                </tbody>
             </table>
           </div>
         </div>
    </div>

    <script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>