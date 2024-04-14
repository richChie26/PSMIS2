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


    $sql = "" ;
  $sqlse = "select id from a_mostaccess where isactive =1 and userid = $uid"; 
    $qry21 = mysqli_query($con,$sqlse);

    if(mysqli_num_rows($qry21) > 0 ){
$sql ="SELECT `PARNO`, `Dateissue`, `datereceived`,Completename ReceivedBy ,
Position
FROM `t_par` a 
left join (SELECT 
x.userid ,concat(`fname`,' ', substring(`mname`,1,1) ,'. ' , `lname`) Completename
,concat(z.section,' | ',y.position) Position
FROM `a_user` x 
left join u_profile y on x.`profileid` = y.`profileid` and y.isactive = 1
left join a_section z on y.section = z.id  and z.isactive =1 
where x.isactive = 1 ) b on a.`receivedby` = b.userid 
where a.isactive = 1  and a.tag = 2 
order by a.id Desc
";
    }else{
      $sql ="SELECT `PARNO`, `Dateissue`, `datereceived`,Completename ReceivedBy ,
Position
FROM `t_par` a 
left join (SELECT 
x.userid ,concat(`fname`,' ', substring(`mname`,1,1) ,'. ' , `lname`) Completename
,concat(z.section,' | ',y.position) Position
FROM `a_user` x 
left join u_profile y on x.`profileid` = y.`profileid` and y.isactive = 1
left join a_section z on y.section = z.id  and z.isactive =1 
where x.isactive = 1 ) b on a.`receivedby` = b.userid 
where a.isactive = 1 and a.createdby = $uid  and a.tag = 2 
order by a.id Desc
";
    }

	$qry = mysqli_query($con,$sql);

?>
<br />

<div class="row">
  <div class="cols-xs-12">
    <table class="table table-condensed table-striped display"  id="example"   >
      <thead style="background-color: #337ab7;color:white;">
        <th>ICS No</th>
        <th>Date Issued</th>

        <th>Received By</th>
        <th>Section | Position</th>
        <th></th>
        <th></th>
      </thead>
      <tbody>
        <?php
						while ($row= mysqli_fetch_array($qry)) {
							echo '<tr >
									<td  >'.$row['PARNO'].'</td>
				               		<td>'.$row['Dateissue'].'</td>
				               	
				               		<td  >'.$row['ReceivedBy'].'</td>
				               		<td  >'.$row['Position'].'</td>
                           <td><center><a href="#" class="btnprevics" id="'. $row['PARNO'] .'"><span class="glyphicon glyphicon-list-alt" style="color:#337ab7;"></span></a></center></td> 
               					  <td><center><a href="#" class="btnprintics" id="ICS'. '|'. $row['PARNO'] .'"><span class="glyphicon glyphicon-print" style="color:#337ab7;"></span></a></center></td> 
                           </tr>';
						
             }
             
             ?>
            </div>
          </td>
        </tr>

       
      </tbody>
    </table>
  </div>
</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>