<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;



?>

 <form action="#" method="post" id="frmMenu">
       
      <div class="row">
          <div class="col-xs-6">
          <div class="form-group has-feedback">
      
           <input type="text" name="txtSearchReclass2" id="txtSearchReclass2"
		    class="form-control" placeholder="Search Item Name">  

			
          </div>
        </div>
      <div class="col-xs-1">
          <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnseachClass2"><span class="glyphicon glyphicon-zoom-in"></span></button>
          
          </div>
       </div>
        <div class="col-xs-5">
          <div class="form-group has-feedback">
		 <select id="optClass" class="form-control"  style="display:none">
			<option>Select Option</option>
			<?php 
				$sqlkoto = "SELECT `id`, `accounttitle` FROM `m_accouttitle` WHERE isactive =1 and `typeofasset` in (2,3)"; 
				$qrykoto = mysqli_query($con,$sqlkoto);

				while($myrow = mysqli_fetch_array($qrykoto)){
					echo '<option value="'.$myrow['id'].'">' .$myrow['accounttitle'] .'</option>';	
				}
			?>
		 </select>
       
          </div>
        </div>

        
  </div> 
     <div class="row">
   			<div class="col-xs-12">
   				<div id="listofmenu">
   					<table id="" class="table" style="width:100%;">
   						<tr style="background-color: #337ab7;color:white;">
							<th style="display:none">Select</th>
							<th>Property No</th>
							<th>Item Name</th>
							<th>Description</th>
							
							<th>Amount</th>
							<!-- <th>From Account Title</th> -->
							<th>New Account Title</th>
                            <th>Date reclasified</th>
                            <th>Remarks</th>
                            <th>Action</th>
							
   						</tr>
              <tbody id="tblsearch">
   						<?php 
   							$sqlmenu = " 
                               SELECT a.id,
                               `itemno`, `item`,`description`, format(`amount`,2)  amount
                               ,c.accounttitle reclassfrom ,d.accounttitle reclassTo,`dateReclass`
							   ,a.remarks,a.propertyno
                               FROM `t_reclass` a 
                               left join m_equipent b on a.`itemid` = b.id and b.isactive = 1 
                               left join m_accouttitle c on a.`reclassfrom` = c.id and c.isactive = 1 
                               left join m_accouttitle d on a.`reclassTo`  = d.id and d.isactive = 1 
                               left join t_equipmentdeliverydetails e on a.`itemid` = e.itemid and e.isactive = 1 
                               where a.isactive =1 
                            ";
   							$qrymenu = mysqli_query($con,$sqlmenu);
   							while($row = mysqli_fetch_array($qrymenu)){
   								echo '<tr><td style="display:none">
   									<input name="selector[]" id="ad_Checkbox1" class="ads_Checkbox" type="checkbox" value="'.$row['id'].'" /></td>
   									<td>'.$row['propertyno'].'</td>
									<td>'.$row['item'].'</td>
									<td>'.$row['description'].'</td>
									<td>'.$row['amount'].'</td>
								
									<td>'.$row['reclassTo'].'</td>
									<td>'.$row['dateReclass'].'</td>
                                    <td>'.$row['remarks'].'</td>
									<td> <button  class="btn btn-primary bnmyreclass" id = "'.$row['id'].'"> View Property Card</button></td>
   								</tr>';
   							}
   						?>
            </tbody>
		</table>

   				</div>
   			</div>
   			<div class="col-xs-1" style="display:none">
   				<button class="btn btn-primary"  style = "display:none" id="btnsaveMepi"><span class="glyphicon glyphicon-plus "></span></button>
   				<br/><br/>
   				<!-- <button class="btn btn-danger" id="btnremovemenu"><span class="glyphicon glyphicon-minus "></span></button> -->
   				
   				
   			</div>  
   			<div class="col-xs-12">
			  
			<div id="groupmenus">
				
			<table id="" class="table display" style="width:100%; display:none" >
   						<tr style="background-color: #337ab7;color:white;">
							
							<th>Item No</th>
							<th>Item Name</th>
							<th>From</th>
							<th>To </th>
							<th>Date Reclass </th>
   						
   						</tr><tbody id="mygpbody"></tbody>
   					</table>
  			</div>
   			</div>  	
     </div>
     
     
    </form> 

	