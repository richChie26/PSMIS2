

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
            <input type="text" class="form-control" placeholder="Section" id="txtsectiondata" name= "txtsectiondata" required="true">
            <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>
       
          </div>
        </div>
      
      

        
  </div> 
 
   <div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnsavesection"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
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
                    <th>Section</th>
                    
                    <th><center>Edit</center></th>
                    <th><center>Remove</center></th> 
                </tr>
              </thead>
                <tbody id="rcdetails">
            <?php
            
    $sql1 = ' SELECT `section`,`id` FROM `a_section` WHERE `isactive` = 1 

    order by `section` ASC';
$qry1 = mysqli_query($con,$sql1);
  while($row = mysqli_fetch_array($qry1)){
    echo ' <tr> <td>'. $row['section'].'</td>
                   
     <td><center><a href="#" class="btnsectionedit" id="'.$row['id']. '|'.$row['section'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="btnsectiondel" id="'.$row['id'].'|'.$row['section'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


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