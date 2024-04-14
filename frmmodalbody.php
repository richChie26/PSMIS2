<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


$sql = "SELECT `id`, `Groupnane` FROM `a_group` WHERE isactive = 1 order by `Groupnane` ASC";

$qry = mysqli_query($con,$sql);
?>

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>

       <div class="row">
          <div class="col-xs-5">
          <div class="form-group has-feedback">
      
           <input type="text" name="txtsearchmenu" id="txtsearchmenu" class="form-control" placeholder="Search Menu Name">  
          </div>
        </div>
      <div class="col-xs-1">
          <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnsearchmenu"><span class="glyphicon glyphicon-zoom-in"></span></button>
          
          </div>
       </div>
        <div class="col-xs-4">
          <div class="form-group has-feedback">
        
           <select class="form-control" id="cmbGroup">
			   <?php 
			   	while($row = mysqli_fetch_array($qry)){
			   ?>
			    <option value="<?php echo $row['id']; ?>"><?php echo $row['Groupnane'] ; ?></option>
			<?php
				}
			?>
			</select>
          </div>
        </div>

        
  </div> 
     <div class="row">
   			<div class="col-xs-5">
   				<div id="listofmenu">
   					<table class="table">
   						<tr style="background-color: #337ab7;color:white;">
   							<th>Select</th>
   							<th>Menu Code</th>
   							<th>Menu Name</th>
   						</tr>
              <tbody id="tblsearch">
   						<?php 
   							$sqlmenu = "SELECT `id`, `menucode`, `menuname` FROM `a_menu` WHERE isactive = 1 order by `menuname` ASC";
   							$qrymenu = mysqli_query($con,$sqlmenu);
   							while($row = mysqli_fetch_array($qrymenu)){
   								echo '<tr><td>
   									<input name="selector[]" id="ad_Checkbox1" class="ads_Checkbox" 
									type="checkbox" value="'.$row['id'].'" />
									</td>
   									<td>'.$row['menucode'].'</td>
   									<td>'.$row['menuname'].'</td>
   								</tr>';
   							}
   						?>
            </tbody>
   					</table>

   				</div>
   			</div>
   			<div class="col-xs-1">
   				<button class="btn btn-primary" id="btnsavemenu"><span class="glyphicon glyphicon-plus "></span></button>
   				<br/><br/>
   				<button class="btn btn-danger" id="btnremovemenu"><span class="glyphicon glyphicon-minus "></span></button>
   				
   				
   			</div>  
   			<div class="col-xs-6">
   				<div id="groupmenus">
   					<table class="table">
   						<tr style="background-color: #337ab7;color:white;">
   							<th>Select</th>
	   						<th>Group Name</th>
	   						<th>Description</th>
	   						<th>Menu Code</th>
	   						<th>Menu Name</th>
   						</tr><tbody id="gpbody"></tbody>
   					</table>
  			</div>
   			</div>  	
     </div>
     
     
    </form> 