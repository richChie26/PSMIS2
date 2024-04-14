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


?>
<form action="#" method="post" id="frmMenu">

  <div id="myalert">
    <div class="alert alert-info"> <strong>Information!</strong> Please fill-up the form correctly! .</div>
  </div>

  <div class="row">

    <div class="col-xs-4">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Code" id="fundcode" name="fundcode" required="true">
        <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>

      </div>
    </div>

    <div class="col-xs-4">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Financing Source" id="fsource" name="fsource"
          required="true">
        <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>

      </div>
    </div>

  </div>

  <!-- second row -->

  <div class="row">

    <div class="col-xs-4">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Authorization" id="txtauthorization"
          name="txtauthorization" required="true">
        <span class="glyphicon glyphicon-book  form-control-feedback"></span>

      </div>
    </div>

    <div class="col-xs-4">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Fund Category" id="fcategory" name="fcategory"
          required="true">
        <span class="glyphicon glyphicon-align-center form-control-feedback"></span>

      </div>
    </div>
    <div class="col-xs-4">
    <div class="form-group has-feedback">
           <input type="checkbox" id="chkactive" name="chkactive" >

           <!-- <input type="checkbox" name="chk[]" id="chk[]" value="Apples" /> -->
          <label for="chkactive">Activation </label>
          </div>
        </div>
    </div>
  </div>

  <!-- button row -->
  <div class="row">
    <div class="col-xs-4">
      <div class="form-group has-feedback">
        <button class="btn btn-primary" id="btnsavefundcluster"><span
            class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>

      </div>
    </div>

  </div>
  <!-- <div class="row">
    <div class="col-xs-6">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Search Fund Cotegory" id="txtSearchcluster"
          name="txtSearchcluster" required="true">
        <span class="glyphicon glyphicon-zoom-in form-control-feedback text-info"></span>

      </div>
    </div>
    <div class="col-xs-1">
      <div class="form-group has-feedback">
        <button class="btn btn-info" id="btnsearchcluster"><span class="glyphicon glyphicon-zoom-in"></span></button>

      </div>
    </div>

  </div> -->

</form>
<div class="row">
  <div class="col-xs-12">
    <div>
      <table class="table table-striped" id="example" >
        <thead style="background-color: #337ab7;color:white;">
          <tr >

            <th>Code</th>
            <th>Financing Source</th>
            <th>Authorization</th>
            <th>Fund Category</th>
            <th style="text-align:center">Activation</th>
            <th style="text-align:center">Edit</th>
            <th style="text-align:center">Remove</th>
          </tr>
        </thead>
        <tbody id="rcdetails">
        <?php
        
        

    $sql = 'SELECT `id`, `code`, `FinancingSource`, `Authorization`, `Fundcategory`,
    Activation 
    FROM `m_fundcluster` WHERE isactive = 1 ';
$qry = mysqli_query($con,$sql);
 while($row = mysqli_fetch_array($qry)){
         $tass = "";
          $Activation = $row['Activation'];
          if($Activation == 1 ){
            $tass = '<span class="glyphicon glyphicon-ok" style="color:#76ff03;"></span>';
           }else{
              $tass = '<span class="glyphicon glyphicon-remove" style="color:#ef5350;"></span>';
           }
   echo ' <tr> <td>'. $row['code'].'</td>

         <td>'. $row['FinancingSource'].'</td>
         <td>'. $row['Authorization'].'</td>
         <td>'. $row['Fundcategory'].'</td>
         <td style="text-align:center">'. $tass.'</td>
       
    <td style="text-align:center"><center>
    <a href="#" class="btneditcluster" 
    id="'.$row['id']. '|'
    .$row['code'].'|'
    .$row['FinancingSource'].'|'
    .$row['Authorization'].'|'
    .$row['Fundcategory'].'|'
    .$row['Activation'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
               <td style="text-align:center"><center><a href="#" class="btnclusterremove" id="'.$row['id'].'|'.$row['Fundcategory'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


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