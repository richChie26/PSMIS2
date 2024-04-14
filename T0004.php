<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $sql ="SELECT `id`, `Suppliername` FROM `m_supplier` WHERE isactive = 1 order by `Suppliername` asc ";

    $qry = mysqli_query($con,$sql);

    $sqlunits = "SELECT `id`, `units` FROM `m_units` WHERE `isactive` = 1 order by `units` Asc";

    $qryunits = mysqli_query($con,$sqlunits);



?>
<form action="#" method="post" id="frmMenu">

  <div id="myalert">
    <div class="alert alert-info"> <strong>Information!</strong> Please fill-up the form correctly! .</div>
  </div>
  <!-- First row -->
  <div class="row">

    <div class="col-xs-4">
      <div class="form-group">
        <label>Date Request</label>
        <div class='input-group date' id='datetimepicker1'>
          <input type='date' id="dtpdate" name="dtpdate" class="form-control" />

        </div>
      </div>
    </div>
    <div class="col-xs-4">
      <div class="form-group has-feedback">
      <label>Fund Source</label>
        <input type="text" class="form-control" placeholder="Fund Source" id="txtsource" name="txtsource"
          required="true" readonly="true">
        <span class="glyphicon glyphicon-bookmark form-control-feedback"></span>

      </div>

    </div>
  </div>
  <!-- second row -->
  <div class="row">

    <div class="col-xs-4">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Stock No." id="txtstockno3" name="txtstockno3"
          required="true" readonly="true">
        <span class="glyphicon glyphicon-barcode form-control-feedback"></span>

      </div>

    </div>
    <div class="col-xs-4">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Item" id="txtitem3" readonly="true" name="txtitem3"
          required="true">
        <span class="glyphicon glyphicon-gift form-control-feedback"></span>

      </div>
    </div>

  </div>
  <!-- second row -->
  <div class="row">
    <div class="col-xs-12">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Description" id="txtdescription3" name="txtdescription3"
          required="true" readonly="true">
        <span class="glyphicon glyphicon-book form-control-feedback"></span>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-4">

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Units of Measurement" id="txtunits" name="txtunits"
          required="true" readonly="true">
        <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>

      </div>
    </div>
    <div class="col-xs-4">

      <div class="form-group has-feedback">
        <input type="number" class="form-control" placeholder="Quantity" id="txtquantity" name="txtquantity"
          required="true">
        <span class="glyphicon glyphicon-menu-hamburger form-control-feedback"></span>

      </div>
    </div>

  </div>
  <div class="row">
    <div class="col-xs-4">
      <div class="form-group has-feedback">
        <label>Request Purpose</label>
        <input type="text" class="form-control" placeholder="Purpose" id="txtpurpose" name="txtpurpose" required="true">
        <span class="glyphicon glyphicon-book form-control-feedback"></span>

      </div>
    </div>
  </div>
  <!-- button row -->
  <div class="row">
    <div class="col-xs-10">
      <div class="form-group has-feedback">
        <button class="btn btn-primary" id="btnaddrec"><span class="glyphicon glyphicon-plus">&nbsp;Add</span></button>

      </div>
    </div>

    <div class="col-xs-1">
      <div class="form-group has-feedback">
        <button class="btn btn-primary" id="btnsaverequest" style=" padding-right: : 15px;margin-right: :15px;"><span
            class="glyphicon glyphicon-floppy-disk">&nbsp;Submit</span></button>

      </div>
    </div>
  </div>

</form>

<ul class="nav nav-tabs responsive-tabs">
  <li class="active"><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list"
        style="background-color: #337ab7"></span> &nbsp;&nbsp;Request Supply</a></li>
  <li><a data-toggle="tab" href="#menu1" id="rislist">List of Requested Supplies</a></li>

</ul>

<di v class="tab-content">
  <div id="home" class="tab-pane fade in active">
    <div class="row">
      <div class="col-xs-12">
        <div>
          <br />
          <table class="table table-striped">
            <thead style="background-color: #337ab7;color:white;">
              <tr>

                <th>Stock No.</th>
                <th>Item</th>
                <th>Description</th>
                <th>Unit of Measurement</th>
                <th>Quantity</th>

                <th>Remove</th>
              </tr>
            </thead>
            <tbody id="rcdetails"></tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <div id="menu1" class="tab-pane fade">
    <div id="tabrichie"></div>

  </div>

  </div>
