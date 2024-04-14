<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


  $txtsearchapprover = $_GET['txtsearchapprover'];

    $sql = "SELECT a.id,B.ResponsibilityCenter,c.section,d.CompleteName  FROM `a_deparmentapproval` a 
    left join a_responsibilitycenter b on a.`responsibilitycenterid` = b.id and b.isactive =1 
    left join a_section c on a.`sectionid` = c.id and c.isactive =1 
    left join (SELECT x.userid ,concat(fname, ', ' , Substring(mname,1,1) ,' ', lname) CompleteName FROM `a_user` x 
    left join u_profile y on x.profileid = y.profileid and y.isactive = 1 
    where x.isactive =1 ) d on a.userid = d.userid  where a.isactive = 1  and  b.ResponsibilityCenter like '%".$txtsearchapprover."%'
    order by a.id Desc
    ";
$qry = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($qry)){
	
     

  	echo ' <tr> <td>'. $row['ResponsibilityCenter'].'</td>

          <td>'. $row['section'].'</td>
          <td>'. $row['CompleteName'].'</td>
     
        


                   


              <td><center><a href="#" class="btnApproverRemove" id="'.$row['id'].'|'.$row['CompleteName'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


	}
?>