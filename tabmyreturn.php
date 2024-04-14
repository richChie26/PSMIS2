<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$sql ="SELECT `rcode`, convert(`datereturn`,date)datereturn FROM `t_returns` WHERE `createdby` = $uid and isactive =1  
order by id desc 
";


	$qry = mysqli_query($con,$sql);

?>
<br/>
<div class="row">
	<div class="cols-xs-12">
		 <table  class="table table-condensed table-striped">
               <thead style="background-color: #337ab7;color:white;">
               		<th>CM Code </th>
               		<th>Date Return</th>
                   <th>Property No</th>
                   <th>Article </th>
                   <th>Description</th>
                   <th>Accountable Officer</th>
               		<th>Condition</th>
                   <th>Remarks</th>
                  <th>Print CM</th>  
               </thead>
			   <tbody>
            <?php 

            $sqldetails = "SELECT a.`rcode`,`remarks`, item,description,a.`PARNO`
            ,convert(b.datereturn,date) datereturn,a.propertyno,
`condition`, `remarks`,
            (SELECT concat(`fname`, ' ' , substring(`mname`,1,1),'. ', `lname`)   FROM `a_user`  j 
            left join u_profile k on j.`profileid` = k.profileid and k.isactive = 1 
            where  j.isactive = 1 and j.`userid` = b.returnby ) cname
            
            FROM `t_returndetails` a
            left join t_returns b on a.`rcode` = b.rcode and b.isactive =1 
            left join (
                SELECT y.item,`description` ,x.propertyno  FROM `t_equipmentdeliverydetails` x 
            left join m_equipent y on x.`itemid` = y.id and y.isactive = 1 
                ) c on a.`propertyno` = c.`propertyno`
                order by  a.id desc 
                ";

            $qrydetails = mysqli_query($con,$sqldetails);

            while($rows = mysqli_fetch_array($qrydetails)){
              echo ' <tr>      		
                      <td>'.$rows['rcode'].'   </td>
                      <td>'.$rows['datereturn'].'  </td>
                      <td>'.$rows['propertyno'].' </td>
                      <td>'.$rows['item'].'   </td>
                      <td>'.$rows['description'].' </td>
                      <td>'.$rows['cname'].' </td>
                      <td>'.$rows['condition'].'  </td>
                      <td>'.$rows['remarks'].'  </td>
                    <td><a href="#" id = "'.$rows['rcode'].'"class="btnprintret"><span class = "glyphicon glyphicon-print"></a></span></td> 
             </tr> ';

            }
            
            
            ?>         
			   </tbody>
		</table>
	</div>
</div>