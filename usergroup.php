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
      
           <input type="text" name="txtsearhname" id="txtsearhname" class="form-control" placeholder="Search Employee Name">  
          </div>
        </div>
      <div class="col-xs-1">
          <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnsearchname"><span class="glyphicon glyphicon-zoom-in"></span></button>
          
          </div>
       </div>
        <div class="col-xs-4">
          <div class="form-group has-feedback">
          	
           <select class="form-control" id="cmbGroup1" placeholder="">
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
   							<th>User Name</th>
   						 <th>Full Name</th>
                <th>Position</th>
   						</tr>
   						<tbody id="tblsearch">
              <?php 
   							$sqlmenu = 'SELECT
               userid, up.`profileid`,ifnull(au.username,"") username,

                concat(lname,", ",`fname`," ", substring(`mname`,1,1),".") Completename ,             `Position`,rc. `ResponsibilityCenter`,sec.`Section`,`contactNo`
                ,`address`

                FROM `u_profile` up 
                left join a_user au on up.`profileid` = au.profileid and au.isactive = 1 
                left join a_responsibilitycenter rc on up.`ResponsibilityCenter` =rc.id and           rc.isactive =1 
                left join a_section sec on up.section = sec.id and sec.isactive = 1 
                
                where up.isactive = 1  and ifnull(au.username,"") != ""
                order by  concat(lname,", ",`fname`," ", substring(`mname`,1,1)) ASC ';
   							$qrymenu = mysqli_query($con,$sqlmenu);
   							while($row = mysqli_fetch_array($qrymenu)){
   								echo '<tr><td>
   									<input name="selector[]" id="ad_Checkbox1" class="ads_Checkbox" type="checkbox" value="'.$row['userid'].'" /></td>
   									<td>'.$row['username'].'</td>
   									<td>'.$row['Completename'].'</td>
                      <td>'.$row['Position'].'</td>
   								</tr>';
   							}
   						?>
                
              </tbody>
   					</table>

   				</div>
   			</div>
   			<div class="col-xs-1">
   				<button class="btn btn-primary" id="btnsavgroup1"><span class="glyphicon glyphicon-plus "></span></button>
   				<br/><br/>
   				<button class="btn btn-danger" id="btnremovegroup1"><span class="glyphicon glyphicon-minus "></span></button>
   				
   				
   			</div>  
   			<div class="col-xs-6">
   				<div id="groupmenus">
   					<table class="table">
   						<tr style="background-color: #337ab7;color:white;">
   							<th>Select</th>
	   						<th>User Name</th>
	   						<th>Complete Name</th>
	   						<th>Position</th>
	   						
   						</tr><tbody id="gpbody"></tbody>
   					</table>
  			</div>
   			</div>  	
     </div>
     
     
    </form> 