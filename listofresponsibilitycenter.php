<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


    $sql = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat( `fname`,' ', substring(`mname`,1,1),'. ' , `lname`) Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    $Responsibility = $arr['Responsibility'];
 

$sqlppe = "SELECT 
`id`, `rccode`, `operationUnitCode`, `ResponsibilityCenter`

FROM `a_responsibilitycenter` WHERE isactive = 1  
order by `ResponsibilityCenter` ASC
"; 


$qrypee = mysqli_query($con,$sqlppe);

echo '
<div class="row">
   <div class="col-xs-8">
       

         
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Search Responsibility Center" id="txtsearchrespon" name= "txtsearchrespon" required="true">
            <span class="glyphicon glyphicon-zoom-in form-control-feedback"></span>
       
          </div>
        
        </div>
         <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnsearh"><span class="glyphicon glyphicon-zoom-in"></span></button>
           
          </div>
        </div> 
</div>
<div class= "row"> <div class="col-xs-12"><table class ="table table-striped">
                <thead style="background-color: #337ab7;color:white;"> <tr>
    <th>Resposibility Center Code</th>
    <th>Operations Unit Code</th>
    <th>Responsibility Center</th>
  

		
		</tr></thead><tbody id="listofmats">
		';

while($row = mysqli_fetch_array($qrypee)){
	echo '<tr class= "itemlistiofrespon" id="'.$row['id'].'|'.$row['rccode'].'|'.$row['operationUnitCode'].'|'.$row['ResponsibilityCenter'].'" >
        <td>'.$row['rccode'].'</td>
			  <td>'.$row['operationUnitCode'].'</td>
			  <td>'.$row['ResponsibilityCenter'].'</td>
		
	</tr>';
}
echo '</tbody></table></div></div>';		
?>
