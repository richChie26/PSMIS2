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
                     <th>Equipment</th>
                    <th>Description</th>
                    <th>Serial</th>
                    
                  
                    <th>Quantity</th> 
                    <th>Amount</th>
                  
                      <th style="display:none">Remove</th> 
                   
                </tr>
              </thead>
                <tbody>';
                	
              

      $sql = "SELECT f.id
,accounttitle
,item
,yearoflife,
`amount`, `description`, `serial`, `dateaquire`

FROM `t_tempsemipee` f
left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife` FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = 2 and x.isactive =1) b on `itemid` = b.id 
where tag = 2 and `createdby` = $uid

union all 
SELECT ''
,'Total'
,''
,'',
format(sum(`amount`),2), '', '', ''

FROM `t_tempsemipee` f
left join (SELECT x.id , y.`accounttitle`, `item`,`yearoflife` FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = 2 and x.isactive =1) b on `itemid` = b.id 
where tag = 2 and `createdby` = $uid

 ";
            

               	$qry = mysqli_query($con,$sql);

	$qry = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($qry)) {
		$ss = "";
    if($row['accounttitle'] == "Total"){
      $ss = "";
    }else{
        $ss = "1";
    }

 
                   echo '<tr>
	<td>'.$row['accounttitle'].'</td>
	<td>'.$row['item'].'</td>
	<td>'.$row['description'].'</td>
	<td>'.$row['serial'].'</td>
	

	<td>'.$ss.'</td> 
	<td><span>&#8369;</span>'.$row['amount'].'</td>

	<td style="display:none"><center><a href="#" class="btnremovesimeppe" id= "'.$row['id'].'|'.$row['item'].'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></center></td> 
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
 			Do you want to save this transaction.</div>

 		</div>
 </div>';

 echo '<div class="row">
 	
 		<div class="col-xs-4">
 		<button class="btn btn-primary" id="btnyestosavesemippe">Yes</button>
 		<button class="btn btn-danger" data-dismiss="modal">No</button>

 		</div>
 </div>';
?>



