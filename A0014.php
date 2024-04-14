<?php 

    echo 
'<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <strong>Information!</strong> Please fill up the form .
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group has-feedback">
            <select class="form-control" id="mnutag" name="mnutag" required="true">

                <option value="SetUp">Set-Up</option>
                <option value="Transactions">Transactions</option>
                <option value="Reports">Reports</option>
            </select>

        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Menu Code" id="mcode2" name="mcode2" required="true"
                readOnly="true">
            <span class="glyphicon glyphicon-th-large form-control-feedback"></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Menu Name" id="mnuname2" name="mnuname2" required="true"
                readOnly="true">
            <span class="glyphicon glyphicon-th form-control-feedback"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Sequence" id="mnusequence" name="mnusequence" required="true"
                >
            <span class="glyphicon glyphicon-signal form-control-feedback"></span>
        </div>

    </div>
</div>

';
?>