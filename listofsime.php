
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
    $mnuasset = $_GET['mnuasset'];

    $sql = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    $Responsibility = $arr['Responsibility'];
 

$sqlppe = "SELECT a.id, b.accounttitle,item,yearoflife, 
concat(item, ', ',`description`,', ', `Serial`) description, `propertyno` FROM `t_equipmentdeliverydetails` a 
left join 

(SELECT x.id , y.`accounttitle`, `item`,`yearoflife`,y.typeofasset FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = 2 and x.isactive =1 ) b on a.`itemid` = b.id 
where a.isactive = 1 and `ResponsibilityCenter` = $Responsibility and ifnull(a.`Status`,'') in ('','Serviceable','For Repair')
and b.typeofasset = 2
"; 

// echo $sqlppe;
$qrypee = mysqli_query($con,$sqlppe);

echo '
<div class="row">

<div class= "row"> <div class="col-xs-12"><table id="example"  style="width:99%"   class ="display">
                <thead style="background-color: #337ab7;color:white;"> <tr>
    <th>Account Title</th>
    <th>Property Number</th>
    <th>Item Name</th>
    <th>Description</th>
    <th>Estimated Useful Life</th>
    
    </tr></thead><tbody id="listofmats">
    ';

while($row = mysqli_fetch_array($qrypee)){
  echo '<tr class= "itemrowppesemi" id="'.$row['id'].'|'.$row['propertyno'].'|'.$row['item'].'|'.$row['description'].'|'.$row['yearoflife'] .'|'.$row['accounttitle'] .'" >
        <td>'.$row['accounttitle'].'</td>
        <td>'.$row['propertyno'].'</td>
        <td>'.$row['item'].'</td>
        <td>'.$row['description'].'</td>
       <td>'.$row['yearoflife'].'</td>
  </tr>';
}
echo '</tbody></table></div></div>';    
?>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>