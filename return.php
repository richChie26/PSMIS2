<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    ?>

<div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>

<div class="row">
	<div class="col-xs-5">
	<div class="form-group">
		<label>Select Type</label>
		<select class="form-control" id="optsets">
			<option value="0">Select Option</option>
			<option value="2">Semi-Expendables</option>
			<option value="3">PPE</option>
		</select>
	</div>
	</div>
	<div class="col-xs-5">
		<div class="form-group">
			<label>Property Number</label>
			<input type="text" name="txtpropertyreturn" id="txtpropertyreturn" class="form-control" placeholder = "Property Number" readonly="">
		</div>
	</div>
</div>
<div class= "row"> 
	<div class="col-xs-12">
		<table class ="table table-striped" id="tbltemp">
                <thead style="background-color: #337ab7;color:white;"> <tr>
		
    <th>Property Number</th>
		<th>Item Name</th>
		<th>Description</th>
    <th>PAR Number</th>
    <th>Accountable Person </th>
    <th>Date Issued</th>
		
		</tr></thead><tbody id="returnlist">
			
		</tbody></table>
	</div></div>
	<div class="row">
       <div class="col-xs-4">
          <div class="form-group">
              Condition of Inventory Item : <select class="form-control" id="selcondition">
                   <option value ="Select">Select Option</option>
                  <option value ="Serviceable">Serviceable</option>
                  <option value ="For Repair">For Repair</option>
                  <!-- <option value ="Unserviceable">Unserviceable</option> -->
                  <option value ="For Disposal">For Disposal</option>
                  <!-- <option value ="Disposed">Disposed</option> -->

              </select>
          </div>
        </div> 
         <div class="col-xs-3">
        	<div class="form-group">
        		<label>Date Returned</label><br/>
        		<input type="date" name="dtpdateret" id ="dtpdateret">
        	</div>
        </div> 
         <div class="col-xs-4">
        	<div class="form-group">
        		<label>Remarks</label><br/>
        		<input type="text" name="txtmyremarks" id="txtmyremarks"class= "form-control">
        	</div>
        </div> 
</div>

 <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;Item to Return</a></li>
    <li><a data-toggle="tab" href="#menu1" id="newreturntab">List of Item Returned</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <br/>

<div class="row">
		<div class="col-xs-5">
			<button class="btn btn-primary" id="btnreturnadd">
				Add
			</button>
		</div>
		<div class="col-xs-7">
			<button class="btn btn-primary" style="float: right;" id="btnretursubmit">
				Submit
			</button>
      
		</div>

</div><br/>
    <div class="row">
         <div class="col-xs-12">
           <div >
             <table  class="table table-condensed table-striped">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

   
    <th>Property Number</th>
		<th>Item Name</th>
		<th>Description</th>
    <th>PAR Number</th>
    <th>Condition</th>
    <th>Remarks</th>
    <th>Delete</th>
                  
                </tr>
              </thead>
                <tbody id= "treturn">
                     <?php
 

$sql = "SELECT a.id,
`parno`, a.`propertyno`, `remarks`, `conditions`, item itemname
,`description`, `Serial`, `amount`, `chasisnumber`,d.accounttitle,datereturn
FROM `temptreturn`  a 
left join t_equipmentdeliverydetails b on a.`propertyno` = b.propertyno 
left join m_equipent c on b.itemid = c.id  and c.isactive = 1 
left join m_accouttitle d on c.accounttitle = d.id and d.isactive = 1 
where a.`createdby` = $uid" ;
     $qry = mysqli_query($con,$sql);                                                                                      
 while($row = mysqli_fetch_array($qry)){
        
     echo    '<tr>

  
    <td>'.$row['propertyno'].'</td>
    <td>'.$row['itemname'].'</td>
    <td>'.$row['description'].'</td>
    <td>'.$row['parno'].'</td>
   <td>'.$row['conditions'].'</td>
    <td>'.$row['remarks'].'</td>
    <td><a href="#" id="'.$row['id'].'" class="btnremovereturn"><span style="color:red;" class="glyphicon glyphicon-minus"></span></a></td>
                  
                </tr>';
      
           }
                    ?>
                </tbody>
             </table>
           </div>
         </div>
    </div>

     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "tabmyreturn"></div>

    </div>
   
 
  </div>