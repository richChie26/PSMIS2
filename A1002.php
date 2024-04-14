<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <link rel="stylesheet" href="bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php

include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;

  if($uid == 1){
        echo '
        <div class="row">
        <div class="col-xs-9">
        <div class="form-group">
        <textarea class="form-control" cols"15" rows="15" id="txtquery" style="margin-left:20px;"></textarea>
        </div></div></div>
            <div class="row">
            <div class="col-xs-9">
            <button id="btnsendqry" class="btn btn-primary">Send</button></div></div>
        ';
  }
?>

<script type="text/javascript">
	$("document").ready(function() {
        
        $(document).on("click","#btnsendqry",function(e){
            e.preventDefault();
           $.ajax({
               url:'A1001.php',
               type:'get',
               data:{txtquery:$("#txtquery").val()},
               cache:false,
               success:function(data){
                   alert(data);
               }
           })
        })
    })
    </script>
</body>
</html>