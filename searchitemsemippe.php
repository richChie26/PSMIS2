<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $mnuasset = $_GET['mnuasset'];
$txtsearchppe = $_GET['txtsearchppe'];
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
 

$sqlppe = "SELECT a.id, accounttitle,item,yearoflife, 
concat(item, ', ',`description`,', ', `Serial`) description, `propertyno` FROM `t_equipmentdeliverydetails` a 
left join 

(SELECT x.id , y.`accounttitle`, `item`,`yearoflife`,y.typeofasset FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = 3 and x.isactive =1 ) b on a.`itemid` = b.id 
where a.isactive = 1 and `ResponsibilityCenter` = $Responsibility and ifnull(a.`Status`,'') = ''
and b.typeofasset = 3 and item like '%".$txtsearchppe."%'
"; 

$qrypee = mysqli_query($con,$sqlppe);

echo '
<div class="row">
   <div class="col-xs-8">
       

         
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Search Materials and Supply" id="txtsearchppe" name= "txtsearchppe" required="true">
            <span class="glyphicon glyphicon-zoom-in form-control-feedback"></span>
       
          </div>
        
        </div>
         <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnsearchppe"><span class="glyphicon glyphicon-zoom-in"></span></button>
           
          </div>
        </div> 
</div>
<div class= "row"> <div class="col-xs-12"><table class ="table table-striped">
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
