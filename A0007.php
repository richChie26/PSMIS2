

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


$sql = "SELECT `id`, `Suppliername`, `Address`, `tin`, `contactNo`, `contactperson`,
 `contactpersonPosition` FROM `m_supplier` WHERE `isactive` = 1 order by `Suppliername` Asc";

$qry = mysqli_query($con,$sql);
?>

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>
<!-- First row -->
       <div class="row">
          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Supplier name" id="supplier" name= "supplier" required="true">
            <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>
       
          </div>
        </div>
      <div class="col-xs-4">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Address" id="address" name= "address" required="true">
            <span class="glyphicon glyphicon-compressed form-control-feedback"></span>
       
          </div>
       </div>
        <div class="col-xs-4">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Bussiness Tin" id="tin" name= "tin" required="true">
            <span class="glyphicon glyphicon-sd-video form-control-feedback"></span>
       
          </div>
        </div>

        
  </div> 
 <!-- second row -->

    <div class="row">
          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Contact Person" id="cp" name= "cp" required="true">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
       
          </div>
        </div>
      <div class="col-xs-4">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Contact Number" id="cpnumber" name= "cpnumber" required="true">
            <span class="glyphicon g glyphicon-list-alt form-control-feedback"></span>
       
          </div>
       </div>
        <div class="col-xs-4">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Position" id="cpPosition" name= "cpPosition" required="true">
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
       
          </div>
        </div>

        
  </div> 

  <!-- button row -->
   <div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnsavesuppply"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
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

           


                    <th>Supplier Name</th>
                    <th>Address</th>
                    <th>TIN</th> 

                    <th>Contact Person</th>
                    <th>Contact No.</th>
                    <th>Position</th> 

                    <th>Edit</th>
                    <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails">

        <?php
            $sql1 = 'SELECT `id`, `Suppliername`, `Address`, `tin`, `contactNo`, `contactperson`, `contactpersonPosition` FROM `m_supplier` WHERE `isactive` = 1 
            
                order by `Suppliername` Asc
            
            
                ';
            $qry1 = mysqli_query($con,$sql1);
              while($row = mysqli_fetch_array($qry1)){
                echo ' <tr> <td>'. $row['Suppliername'].'</td>
                                <td>'. $row['Address'].'</td>
                                <td>'. $row['tin'].'</td> 
                                <td>'. $row['contactperson'].'</td>
                                <td>'. $row['contactNo'].'</td>
                                <td>'. $row['contactpersonPosition'].'</td> 
            
            
                 <td><center><a href="#" class="btnsupplyedit" id="'.$row['id']. '|'.$row['Suppliername'].'|'.$row['Address']. '|'.$row['tin'].'|'.$row['contactperson'].'|'.$row['contactNo']. '|'.$row['contactpersonPosition'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                            <td><center><a href="#" class="btnsupplyremove" id="'.$row['id'].'|'.$row['Suppliername'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';
            
            
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