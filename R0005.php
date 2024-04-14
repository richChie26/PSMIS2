<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


?>
<div class="row">
	<div class="col-xs-5">
		<div class="form-group">
			<input type="text" name="txtempnameindex" id="txtempnameindex" class="form-control"
			placeholder="Accountable Officer:" 
			>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group">
				

			<button class="btn btn-primary" id="btnprinindex" style="float: right;">Print</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div id="ooo5"></div>
	</div>
 </div>