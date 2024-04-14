<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


 $txtsupplier = $_GET['txtsupplier'];
 $txtsource = $_GET['txtsource'];
 $txtPO = $_GET['txtPO'];
 $txtddate = $_GET['txtddate'];
 $txtpodate = $_GET['txtpodate'];
 $txtreceiptni = $_GET['txtreceiptni'];

echo '<div class="row">
		<div class="col-xs-6">
		Supplier : '.$txtsupplier.' 
		<br/>P.O. Number : '.$txtPO.' 
		<br/> P.O. Date : '.$txtpodate.'
		</div>

		<div class="col-xs-6">
			Receipt No.: '.$txtreceiptni.'
		 <br/> 
		 	Delivery Date : '.$txtddate.'
		</div>
	  </div> ';


echo '<div class="row">
         <div class="col-xs-12">
           <div >
            <br/>
             <table  class="table table-striped" id="richietable">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                     <th> Account Title</th>
                    <th>Stock No.</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Quantity</th> 
                    <th>Unit of Measurement</th>
                    <th>Amount</th>
                   
                </tr>
              </thead>
                <tbody>';
                	
              

      $sql = "SELECT 

b.accounttitle, stockno, item itemname ,description, `qty`,Units 'UN',
amount,format( (`amount`* qty),2) totalAmount

FROM `t_tempreceived` a 
left join (SELECT x.id,z.accounttitle, `stockno`,item,`description`,za.units FROM `m_materials` x 
left join m_itemname y on x.`item` = y.id and y.isactive  = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.units = za.id and za.isactive = 1 
where x.isactive = 1 ) b on a.itemid = b.id
where a.createdby = $uid

union all 
SELECT 

 'Total', '','' ,'', '','','', format(SUM((`amount`* qty)),2) totalAmount

FROM `t_tempreceived` a 
left join (SELECT x.id,z.accounttitle, `stockno`,itemname,`description`,za.units FROM `m_materials` x 
left join m_itemname y on x.`item` = y.id and y.isactive  = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.units = za.id and za.isactive = 1 
where x.isactive = 1 ) b on a.itemid = b.id
where a.createdby = $uid

 ";
            

               	$qry = mysqli_query($con,$sql);

	$qry = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($qry)) {
		$myrow = "";
		if($row['accounttitle'] == "Total"){
			$myrow =  '<span class= "colorred">' . $row['accounttitle'] . '</span>' ;


		}else{
		 $myrow =$row['accounttitle'] ;
		}



		echo 
                   ' <tr><td>'.$myrow .'</td>
                    <td>'.$row['stockno'] .'</td>
                    <td>'.ucwords(strtolower($row['itemname'])) .'</td>
                    <td>'.ucwords(strtolower($row['description'])) .'</td>
                    <td>'.$row['qty'] .'</td>
                    <td>'.$row['UN'] .'</td> 
                    <td><span>&#8369;</span>'.$row['totalAmount'] .'</td>
                   </tr>'; 

	}




echo "                </tbody>
             </table>
           </div>
         </div>
    </div>";


 echo '<div class="row">
 		<div class="col-xs-12">
 			<div class="alert alert-info"><strong>Confirmation!</strong> 
 			Are you want to save this transaction?</div>

 		</div>
 </div>';

 echo '<div class="row">
 	
 		<div class="col-xs-4">
 		<button class="btn btn-primary" id="btnyestosave">Yes</button>
 		<button class="btn btn-danger" data-dismiss="modal">No</button>

 		</div>
 </div>';
?>

