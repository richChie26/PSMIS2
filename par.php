<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $myid = $_GET['myid'];

$sql = "SELECT distinct a.id,stockno,item,description,units ,a.qty, ifnull(d.qty,0) - ifnull(approved,0) available,purpose,cname,a.RSIcode,a.itemid
,(SELECT `amount` FROM `t_itemreceived` f where f.isactive = 1 and f.itemid = a.itemid  order by `id` desc  limit 1 )

 FROM `t_requisitiondetails`  a 
left join (SELECT distinct itemid,ifnull(sum(`qty`),0) approved FROM `t_requisitiondetails` x 
left join t_requesitionhead y on x.RSIcode = y.risno  and y.isactive = 1 
where ifnull(dateapproved,'') != ''
group by itemid) b on a.itemid = b.itemid

left join (SELECT  x.id,`stockno`,  `item` , `description`, y.units FROM `m_materials` x

left join m_units y  on x.`units` = y.id and y.isactive = 1 

WHERE x.isactive = 1 
) c on a.`itemid` = c.id 
left join t_itemreceived d on a.`itemid` = d.itemid and d.isactive = 1 
left join (SELECT purpose,cname,risno FROM `t_requesitionhead`k
left join (SELECT userid , concat(`lname` , ', ', `fname`,' ' , substring( `mname`,1,1),'.')  Cname FROM `a_user` g 
left join u_profile h on g.`profileid` = h.profileid and h.isactive = 1 
where g.isactive = 1 ) l on k.`requestedyby` = l.userid 
where k.isactive = 1 ) e on a.`RSIcode` = e.risno 


where ifnull(a.Status,'') = 'approved' and  a.id= $myid 
 "; 

$qry = mysqli_query($con,$sql);

echo '
<div class= "row"><div class="col-xs-12">
 
  ';
$row = mysqli_fetch_array($qry);
$itemid = $row['itemid'];
    echo '<label>RIS No.: '. $row['RSIcode'].'</label> <br/>';
    echo '<label>Requested By: '. $row['cname'].'</label><br/>';
     echo '<label>Purpose: '. $row['purpose'].'</label><br/>';

 echo '<table class ="table table-striped">
                <thead style="background-color: #337ab7;color:white;"> <tr>
   
    <th>Stoc No.</th>
    <th>Item Name</th>
    <th>Description</th>
    <th>Units</th>
    <th>Qty</th>
    <th>Available</th>
    <th>Propety No.</th>
     
    </tr></thead><tbody id="listofmats"> <tr>';
   
    echo "
    <td>".$row['stockno']."</td>
    <td>".$row['item']."</td>
    <td>".$row['description']."</td>
    <td>".$row['units']."</td>
    <td>".$row['qty']."</td>
    <td>".$row['available']."</td><td>
    <select id ='propertyno' >
    ";
    
    $sqlpro ="SELECT `propertyno` FROM `t_propertyno` where itemid  = $itemid and ifnull(status,'') = '' ";
    $qrypro = mysqli_query($con,$sqlpro);
      while ($myrow = mysqli_fetch_array($qrypro)) {
        echo "
                <option value='".$myrow['propertyno']."'>".$myrow['propertyno']."</option>
              ";    
      }
    
     
    

    echo '</select></td></tr></tbody></table>
<button class="btn btn-primary btnsavepar" id="'.$row['id'].'" style=" padding-right: : 15px;margin-right: :15px;"><span class="glyphicon glyphicon-thumbs-up">&nbsp;Save</span></button>
    ';
echo '</div></div>';		
?>
