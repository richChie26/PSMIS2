<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$txtorigin = $_GET['txtorigin'];
$PTRNumber = $_GET['PTRNumber'];
$ptrdate = $_GET['ptrdate'];
 


echo '<div class="row">
		<div class="col-xs-6">
		Origin : '.$txtorigin.' 
		<br/>PTR Number : '.$PTRNumber.' 
		<br/>PTR Date: '.$ptrdate.'
		</div>

		
	  </div> ';


echo '<div class="row">
         <div class="col-xs-12">
           <div >
            <br/>
             <table  class="table table-striped" id="richietable">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                     <th>Equipment</th>
                    <th>Description</th>
                    <th>Serial</th>
                  
                  
                    <th>Quantity</th> 
                    <th>Amount</th>
                  
                     
                   
                </tr>
              </thead>
                <tbody>';
                	
              

      $sql = "SELECT a.id ,

`accounttitle`, `itemno`,  `item`, `yearoflife`, '1' Qty, units
, format(`amount`,2) amount, `decription`, `cha`, `serial`,Fundcategory,propertyno
FROM `t_temptransfer` a
left join (SELECT 
x.`id`, `itemno`, y.`accounttitle`, `item`, `yearoflife`,units
FROM `m_equipent`  x 
left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive =1
left join m_units z on x.`unitofmeasurement` = z.id and z.isactive = 1 
where x.isactive = 1  ) b on a.`itemid` = b.id

left join m_fundcluster c on a.`fund` = c.id and c.isactive = 1 
where tag = 1 and a.createdby = $uid

 ";
            

               	$qry = mysqli_query($con,$sql);

	$qry = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($qry)) {
		


 
                   echo '<tr>

	<td>'.ucwords(strtolower($row['item'])).'</td>
	<td>'.$row['decription'].'</td>
	<td>'.$row['serial'].'</td>


	<td>1</td> 
	<td><span>&#8369;</span>'.$row['amount'].'</td>


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
 		<button class="btn btn-primary" id="btnyessemimanual">Yes</button>
          
 		<button class="btn btn-danger" data-dismiss="modal">No</button>

 		</div>
 </div>';


?>

