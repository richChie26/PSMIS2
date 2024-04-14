<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
      <link rel="stylesheet" href="bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <script src="chiescript.js" type="text/javascript"></script>
   <script src="buttonevents.js" type="text/javascript"></script>
    <style type="text/css">
footer {
  font-size: 9px;
  color: #f00;
  text-align: center;
}

@page {
  size: A4;
  margin: 11mm 17mm 17mm 17mm;
}

@media print {
  footer {
    position: fixed;
    bottom: 0;
  }

  .content-block, p {
    page-break-inside: avoid;
  }

  html, body {
    width: 210mm;
    height: 297mm;
  }
}
    </style>
    
</head>
<body>
<?php
  include('btnprintris.php');
?>

</body>
<script type="text/javascript">
    $(document).ready(function(){
        window.print();
    })

</script>
</html>