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

$sqlres = "SELECT 

(select r.`ResponsibilityCenter` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";

$qryres = mysqli_query($con,$sqlres);
$arrres = mysqli_fetch_array($qryres);

$Responsibility = $arrres['Responsibility'];

$sql = "" ;
$sqlse = "select id from a_mostaccess where isactive =1 and userid = $uid"; 
  $qry21 = mysqli_query($con,$sqlse);

  if(mysqli_num_rows($qry21) > 0 ){

    $sql ="SELECT a.id,`risno`,`purpose`, substring(`datarerequest`,1,10) DateRequest,b.Requestedby,c.ReceivedBy,
ResposibilityCenter ResponsibilityCenter,Position, Section,remarksforapproval
FROM `t_requesitionhead` a
left join (SELECT `userid`,
Completename Requestedby, `ResposibilityCenter`,Position, Section

FROM `a_user` X 
LEFT join vwprofile  y on x.`profileid` = y.profileid 
           
where x.isactive = 1 ) b on a.`requestedby` = b.userid 
left join (SELECT `userid`,
Completename ReceivedBy, `ResposibilityCenter` rec ,Position po, Section se

FROM `a_user` X 
LEFT join vwprofile  y on x.`profileid` = y.profileid 
           
where x.isactive = 1 ) c on a.receivedby = c.userid

where a.isactive = 1 and ifnull(status,'') in ('Released','Submited') 


order by a.id desc ";
  }else{
    $sql ="SELECT a.id,`risno`,`purpose`, substring(`datarerequest`,1,10) DateRequest,b.Requestedby,c.ReceivedBy,
    ResposibilityCenter ResponsibilityCenter,Position, Section,remarksforapproval
    FROM `t_requesitionhead` a
    left join (SELECT `userid`,
    Completename Requestedby, `ResposibilityCenter`,Position, Section
    
    FROM `a_user` X 
    LEFT join vwprofile  y on x.`profileid` = y.profileid 
               
    where x.isactive = 1 ) b on a.`requestedby` = b.userid 
    left join (SELECT `userid`,
    Completename ReceivedBy, `ResposibilityCenter` rec ,Position po, Section se
    
    FROM `a_user` X 
    LEFT join vwprofile  y on x.`profileid` = y.profileid 
               
    where x.isactive = 1 ) c on a.receivedby = c.userid
    
    where a.isactive = 1 and ifnull(status,'') in ('Released','Submited') 
    and ResposibilityCenter = '$Responsibility'
   order by a.id desc ";
  }

  // echo $sql;
    $qry = mysqli_query($con,$sql);

?>

<div class="row">
  <div class="col-xs-12">
<br/>  
      <table class="table table-condensed table-striped display" id="example">
        <thead style="background-color: #337ab7;color:white;">
          <tr>

            <th>RIS No.</th>
            <th>Purpose</th>
            <th>Date Request</th>
            <th>Requested By</th>
            <th>Received By</th>
            <th>Resposibility Center</th>
            <th>Section</th>
            <th>Position</th>
            <th>Remarks</th>
            <th></th>
            <th></th>

          </tr>
        </thead>
        <tbody>
          <?php

                    while($row = mysqli_fetch_array($qry)){
              
         echo   '<tr>
            <td>'. $row['risno'] .'</td>
            <td> '.$row['purpose'] .'</td>
            <td> '.$row['DateRequest'].' </td>
            <td> '.$row['Requestedby'] .'</td>
            <td> '.$row['ReceivedBy'] .'</td>
            <td> '.$row['ResponsibilityCenter'] .'</td>
            <td> '.$row['Section'] .'</td>
            <td> '. $row['Position'] .' </td>
            <td>
                '.  $row['remarksforapproval'] .'
            </td>
            <td>
              <center><a href="#" class="btnprevris" id="'. $row['risno'].'"><span
                    class="glyphicon glyphicon-list-alt" style="color:#337ab7;"></span></a></center>
            </td>

            <td>
              <center><a href="#" class="btnprintris" id=" ptr'. '|'. $row['risno'].' "><span
                    class="glyphicon glyphicon-print" style="color:#337ab7;"></span></a></center>
            </td>

          </tr>

          </td>
          </tr>';

                       
                      }
                    ?>
        </tbody>
      </table>
   
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>