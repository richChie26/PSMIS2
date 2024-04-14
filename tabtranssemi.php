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
where au.isactive = 1 and `userid` = $uid";
 
$qryres = mysqli_query($con,$sqlres);
$arrres = mysqli_fetch_array($qryres);
$Responsibility = $arrres['Responsibility'];

    ?>

<br/>
<div class="row">
	<div class="cols-xs-12">

		 <table  class="table table-condensed table-striped">
       <thead style="background-color: #337ab7;color:white;">
       	  <th>Code</th>
        	<th>Origin</th>
       		<th>PTR Number</th>
       		<th>PTR Date</th>
            <th></th>
       </thead>
			   <tbody>
			   	<?php
			   		$sql ="SELECT distinct a.`id`, `origin`, `ptrcode`, `ptrdate`, a.`tcode` FROM `t_transferouside` a 
left join t_transferoutsidedetails b on a.`tcode` = b.tcode
where b.tag =1 
and a.isactive = 1  and `resposibilityid` = $Responsibility
order by a.id desc 
";
	$qry = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($qry)) {
	echo '<tr >
			<td data-toggle="collapse" data-target="#'. $row['tcode'] .'" class="accordion-toggle">'.$row['tcode'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['tcode'] .'" class="accordion-toggle">'.$row['origin'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['tcode'] .'" class="accordion-toggle">'.$row['ptrcode'].'</td>
			<td data-toggle="collapse" data-target="#'. $row['tcode'] .'" class="accordion-toggle">'.$row['ptrdate'].'</td>
	
       <td><center><a href="#" class="btnprintsemidel" id="ptr'. '|'. $row['tcode'] .'"><span class="glyphicon glyphicon-print" style="color:#337ab7;"></span></a></center></td>
	      </tr>';


$tcode = $row['tcode'];
$sqllist = "SELECT a.id ,
`itemid`,propertyno,
accounttitle , itemno, item,yearoflife ,units,
concat(a.`description`,', ' ,`serial`,', ', `cha`) description, amount
FROM `t_transferoutsidedetails` a
left join (SELECT x.id,
z.accounttitle , `itemno`, `item`,`yearoflife` ,y.units
FROM `m_equipent` x
left join m_units y on x.`unitofmeasurement` = y.id and y.isactive = 1 
left join m_accouttitle  z on x.`accounttitle` = z.id and z.isactive = 1 
          where x.isactive =1 ) b on a.`itemid` =b.id 
          where a.tcode = '$tcode'
          ";
$qrylist = mysqli_query($con,$sqllist);
?>


  <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $row['tcode'] ;?>"> 
              <table class="table table-striped">
                      <thead>
                        <tr class="info">
                           
                            <th>Account Title</th>
                            <th>Property No.</th>
                            <th>Description</th>
                              <th>Qty</th>
                                 <th>Amount</th>
                              <th>Usefull life</th>
                      
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['tcode']; ?>">
                        <?php 
                          while ($newrow = mysqli_fetch_array($qrylist)) {

                           echo '<tr>
                           	<td>'.$newrow['accounttitle'].'</td>
                           	<td>'.$newrow['propertyno'].'</td>
                           	<td>'.ucwords(strtolower($newrow['description'])).'</td>
                           	<td>1</td>
                              <td><span>&#8369;</span> '.$newrow['amount'].'</td>
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