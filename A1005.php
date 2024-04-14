<!DOCTYPE html>
<html lang="en">

<head>
  <title>Property and Supply Management Information System</title>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/logo.ico">
  <link rel="stylesheet" href="bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="chiescript.js" type="text/javascript"></script>
  <script src="buttonevents.js" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <style>


    .newwarning {
      border-style: solid;
      border-color: red;
    }

    .myborder {

      border: 1px solid black;
      border-top: 1px solid red;
      /* border-bottom: 1px solid red; */
    }

    .printheader {
      top: 0;
      margin-top: 0px;
    }

    #imglogoheader {
      background-image: url('img/Logo.bmp');
      width: 80px;
      height: 80px;
      float: left;
    }

    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }

    .carousel-inner img {
      width: 100%;
      /* Set width to 100% */
      margin: auto;
      min-height: 200px;


    }

    .richieholder::-webkit-input-placeholder {
      color: #337ab7
    }

    /* Hide the carousel text when the screen is less than 600 pixels wide */
    @media (max-width: 600px) {
      .carousel-caption {
        display: none;
      }


    }

    .navbar {
      box-shadow: 10px 10px 5px grey;
      border-radius: 25px;
      background-color: #76ff03;
      border-color: #01579b;

    }

    .navbar-nav>li>a {
      color: #004d40;

    }

    /*.container-fluid {
    border-color: #ffffff;
    color: #ffffff !important;
    background-color: #ffffff;
}
   
}*/

    body {
      background-image: url('img/logo.png');
      background-repeat: no-repeat;
      background-size: auto;
      background-size: 400px 400px;
      background-position: center;
      background-attachment: fixed;
    }

    .dropdown-menu {
      height: auto;
      max-height: 500px;
      overflow-x: hidden;
    }

    .richiehide {
      display: none;
    }


    .rates-page-tabs .nav-tabs>li>a {
      border: none;
      text-transform: uppercase;
      color: #7d7d7d;
    }

    .rates-page-tabs .nav-tabs>li>a:hover,
    .rates-page-tabs .nav-tabs>li>a:focus {
      color: red;
      background-color: white;
      box-shadow: 0px -2px 0px red inset;
    }

    .rates-page-tabs .nav-tabs>li.active>a,
    .rates-page-tabs .nav-tabs>li.active>a:focus,
    .rates-page-tabs .nav-tabs>li.active>a:hover {
      border: none;
      box-shadow: 0px -2px 0px red inset;
      color: red;
    }

    #tuklawtitle {
      color: rgba(35, 99, 6, 0.753);
      box-shadow: 0px -2px 0px rgb(58, 3, 185) inset;
    }

    .panel-group .panel-heading+.panel-collapse>.panel-body {
      border: 1px solid #ddd;
    }

    .rates-page-tabs .panel-group,
    .rates-page-tabs .panel-group .panel,
    .rates-page-tabs .panel-group .panel-heading,
    .rates-page-tabs .panel-group .panel-heading a,
    .rates-page-tabs .panel-group .panel-title,
    .rates-page-tabs .panel-group .panel-title a,
    .rates-page-tabs .panel-group .panel-body,
    .rates-page-tabs .panel-group .panel-group .panel-heading+.panel-collapse>.panel-body {
      border-radius: 2px;
      border: 0;
    }

    .rates-page-tabs .panel-group .panel-heading {
      padding: 0;
      background-color: white;
    }

    .rates-page-tabs .panel-group .panel-heading a {
      display: block;
      color: #303030;
      font-size: 12px;
      padding: 15px 15px 15px 45px;
      text-decoration: none;
      text-transform: uppercase;
      position: relative;
    }

    .rates-page-tabs .panel-group .panel-heading a.collapsed {}

    .rates-page-tabs .panel-group .panel-heading a:before {
      /*  content: '-';*/
      position: absolute;
      left: 14px;
      top: 8px;
      font-size: 26px;
    }

    .rates-page-tabs .panel-group .panel-heading a.collapsed:before {
      /*content: '+';*/
      left: 10px;
      top: 10px;
    }


    .rates-page-tabs .panel-group .panel-collapse {
      margin-top: 5px !important;
    }

    .rates-page-tabs .panel-group .panel-body {
      background: #ffffff;
      padding: 15px;
    }

    .rates-page-tabs .panel-group .panel {
      background-color: transparent;
    }

    .rates-page-tabs .panel-group .panel-body p:last-child,
    .rates-page-tabs .panel-group .panel-body ul:last-child,
    .rates-page-tabs .panel-group .panel-body ol:last-child {
      margin-bottom: 0;
    }


    .colorred {

      color: red;
    }

    .hiddenRow {
      padding: 0 !important;
    }

    .problema {
      margin-top: 80px;
      margin-left: 35px;
    }

    .asawaproblema {
      margin-top: 0px;
      margin-left: 35px;
    }
  </style>

</head>
<body>
<form action="A1006.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
   </body>
   </html>