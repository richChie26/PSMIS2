<?php

include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

?>


<div class="row">
	<div class="cols-xs-11" style="padding:10px;">
		 <table  class="table table-condensed table-striped">
            <thead style="background-color: #337ab7;color:white;">
               <tr >
                    <th>Par Number</th>                   
                    <th>Account Title</th>
                    <th>Property Number</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Condition</th>
                    <th>Remarks</th> 
                </tr>
               </thead>
			   <tbody>
                <?php
                $sql = "SELECT `parno`, a.`propertyno`, `remarks`, `condition`,item itemname
                ,`description`, `Serial`, `amount`, `chasisnumber`,d.accounttitle
                FROM `t_returndetails`  a 
                left join t_equipmentdeliverydetails b on a.`propertyno` = b.propertyno 
                left join m_equipent c on b.itemid = c.id  and c.isactive = 1 
                left join m_accouttitle d on c.accounttitle = d.id and d.isactive = 1 
                where  `condition` in ('Unserviceable','For Disposal');";
                $qry = mysqli_query($con,$sql);
                while($row = mysqli_fetch_array($qry)){
                 echo "       
                        <tr >
                            <th>".$row['parno']."</th>                   
                            <th>".$row['accounttitle']."</th>   
                            <th>".$row['propertyno']."</th>   
                            <th>".$row['itemname']."</th>   
                            <th>".$row['description']."</th>   
                            <th>".$row['condition']."</th>   
                            <th>".$row['remarks']."</th>   
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>  
                