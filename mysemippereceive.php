<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $sqlres = "SELECT 

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
    
    $qryres = mysqli_query($con,$sqlres);
    $arrres = mysqli_fetch_array($qryres);
    
    $rid = $arrres['Responsibility'];

    ?>

<br/>
<div class="row">
	<div class="cols-xs-12">
		
		 <table  class="table table-condensed table-striped">
               <thead style="background-color: #337ab7;color:white;">
               		<th>Delivery Code</th>
               		<th>Supplier</th>
               		
               		<th>P.O. Number</th>
               		<th>P.O. Date</th>
               		<th>Delivery Receipt Number</th>
               		<th>Delivery Receipt Date</th>
               		<th>Source of Fund</th>
                  <th></th>
               </thead>
			   <tbody>
			   	<?php

          $sql = "";
          if($uid == 1 ){
            $sql ="SELECT DISTINCT 
            f.`id`, f.`deliverycode`, `PODate`, `PONumber`, `deliverydate` DRDate, `deliveryNumber` DRNumber
            ,Suppliername,Fundcategory
            
            FROM `t_equipmentdeliveryheader` f 
            left join m_supplier g on f.`Supplierid` = g.id and g.isactive = 1 
            left join m_fundcluster h on f.`sourceoffund` = h.id  and h.isactive = 1 
            left join t_equipmentdeliverydetails b on f.`deliverycode` = b.deliverycode and b.isactive =1 
            where f.isactive = 1 and f.tag = 0   order by f.id desc 
";
          }else{
			   		$sql ="SELECT DISTINCT 
             f.`id`, f.`deliverycode`, `PODate`, `PONumber`, `deliverydate` DRDate, `deliveryNumber` DRNumber
             ,Suppliername,Fundcategory
             
             FROM `t_equipmentdeliveryheader` f 
             left join m_supplier g on f.`Supplierid` = g.id and g.isactive = 1 
             left join m_fundcluster h on f.`sourceoffund` = h.id  and h.isactive = 1 
             left join t_equipmentdeliverydetails b on f.`deliverycode` = b.deliverycode and b.isactive =1 
             where f.isactive = 1 and f.tag = 0 and ResponsibilityCenter =    $rid  order by f.id desc 
";
          }
	$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {
	echo '<tr>
			<td data-toggle="collapse" data-target="#'. $row['deliverycode'] .'" class="accordion-toggle">'.$row['deliverycode'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['deliverycode'] .'" class="accordion-toggle">'.$row['Suppliername'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['deliverycode'] .'" class="accordion-toggle">'.$row['PONumber'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['deliverycode'] .'" class="accordion-toggle">'.$row['PODate'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['deliverycode'] .'" class="accordion-toggle">'.$row['DRNumber'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['deliverycode'] .'" class="accordion-toggle">'.$row['DRDate'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['deliverycode'] .'" class="accordion-toggle">'.$row['Fundcategory'].'</td>

       <td><center><a href="#" class="btnprintppedel" id="ptr'. '|'. $row['deliverycode'] .'"><span class="glyphicon glyphicon-print" style="color:#337ab7;"></span></a></center></td>
	      </tr>';


$deliverycode = $row['deliverycode'];
$sqllist = "SELECT a.id delitemid, b.accounttitle,item,yearoflife, 
concat(item, ', ',`description`,', ', `Serial`) description, `propertyno` ,format(amount,2) amount 
FROM `t_equipmentdeliverydetails` a 
left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife` FROM `m_equipent` x
         left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where 
         y.typeofasset = 3 and x.isactive =1 ) b on a.`itemid` = b.id 
         where a.isactive = 1 and a.deliverycode = '$deliverycode' 
 
         
         ";
$qrylist = mysqli_query($con,$sqllist);
?>


  <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $row['deliverycode'] ;?>"> 
              <table class="table table-striped">
                      <thead>
                        <tr class="info">
                           
                            <th>Account Title</th>
                            <th>Property No.</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Amount</th>
                              <th>Estimated Usefull life</th>
                             
                      
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['deliverycode']; ?>">
                        <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {
                           echo '<tr>
                           	<td>'.$newrow['accounttitle'].'</td>
                           	<td>'.ucwords(strtolower($newrow['propertyno'])).'</td>
                           	<td>'.ucwords(strtolower($newrow['description'])).'</td>
                           	<td>1</td>
                            <td> <span>&#8369;</span> '.$newrow['amount'].'</td>
                           	<td>'.$newrow['yearoflife'].'</td>

                           </tr>';

                          }
                        ?>
                    
                           
                      </tbody>
                </table>
              
              </div> 
          </td>
        </tr>
<?php
}

			   	?>
			   </tbody>
		  </table>
	</div>

</div>    