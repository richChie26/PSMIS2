<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $sql = "SELECT `risno`,`purpose`, substring(`datarerequest`,1,10) DateRequest,b.Requestedby
    , case when ifnull(`status`,'') = '' then 
         'For Approval'
        else 
            ifnull(`status`,'')
     end status, `remarksforapproval` 'Remarks'
     FROM `t_requesitionhead` a
left join (SELECT `userid`,
concat(`lname`,' ',`fname`,' ', substring(`mname`,1,1),'.') Requestedby, `ResponsibilityCenter`

FROM `a_user` X 
LEFT join u_profile y on x.`profileid` = y.profileid and y.isactive = 1
where x.isactive = 1 ) b on a.`requestedby` = b.userid 
where a.isactive = 1 and `createdby`  = $uid ";

$qry = mysqli_query($con,$sql);




    ?>
    <br/>
   <table class="table table-striped">
<tr style="background-color: #337ab7;color:white;">
<th>Purpose </th> 
<th>Requested by </th> 
<th>Date Request </th> 
<th>Remarks </th> 
<th>Status</th> 

</tr>
<?php 
    while ($row = mysqli_fetch_array($qry)) {
        # code...
    $mycolor = "";
    if($row['status'] == 'For Approval' ){
        $mycolor = 'style="color:#32ea26;"';
    }elseif($row['status'] == 'Disapproved'){
  $mycolor = 'style="color:#e80505;"';
    }elseif($row['status'] == 'Approved'){
       $mycolor = 'style="color:#337ab7;"';
    }


echo '
<tr class="itemsetris" id="'. $row['risno'] .'|'.$row['purpose'].'|' .$row['Requestedby'] .'|'. $row['DateRequest']. '" '. $mycolor .'>
<td>'.  $row['purpose'].' </td> 
<td>  '.$row['Requestedby'] .'</td> 
<td> '. $row['DateRequest'] .'</td> 
<td> '. $row['Remarks'] .'</td> 
<td> '. $row['status'] .'</td> 

</tr>';
    }
?>

                                </table>