 
 

<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;



$sql = "SELECT 

(select r.`ResponsibilityCenter` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat( `fname`,' ', substring(`mname`,1,1),'. ' , `lname`) Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic
,sec.Section ,rc.ResponsibilityCenter,up.Position 
FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1
left join a_responsibilitycenter rc on up.`ResponsibilityCenter` = rc.id and rc.isactive = 1 
left join a_section sec on up.section = sec.id and sec.isactive = 1 

where au.isactive = 1  and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    

    $Position =  $arr['Responsibility'] . " | ".$arr['Position']; 
  $Completename = $arr['Completename'];
 ?>

<div class="panel panel-primary">
   <div class="panel-heading">PROPERTY ACKNOWLEDGEMENT RECEIPT (PAR)</div>
  <div class="panel-body" >
<div class="row">
       <div class="col-xs-4">
       <div class="form-group">
       Date Issued: <input type="date" name="dtpissued" id="dtpissued">
        </div>
        </div>

</div>

<div class="row">
       <div class="col-xs-4">
       	<div  class="form-group">
         <input type="hidden"  id="txtrecidforis" /> 
        <input type="text" name="txtproperty" id="txtproperty" class="form-control" readonly="true" placeholder="Property Number:">
        	</div>
        </div>
       <div class="col-xs-6">
       	<div  class="form-group">
        <input type="text" name="txtsemidesc" id="txtsemidesc" class="form-control" readonly="true" placeholder="Description:">
        	</div>
        </div>


</div>
<div class="row">
       <div class="col-xs-4">
       	<div  class="form-group">
        <input type="text" name="txtreceived" id="txtreceived" class="form-control" readonly="true" placeholder="Received By:">
        	</div>
        </div>

</div>
<div class="row">
       <div class="col-xs-4">
       	<div  class="form-group">
       <input type="text" name="txtposition" id="txtposition" class="form-control" readonly="true" placeholder="POSITION/OFFICE:">
        	</div>
  </div>   
</div>
<div class="row">
       <div class="col-xs-4">
       
  </div>   
</div>
<div class="row">
       <div class="col-xs-4">
       	<div  class="form-group">
        <input type="text" name="txtissued" id="txtissued" class="form-control" readonly="true" placeholder="Issued By:" value="<?php echo $Completename; ?>" >
        	</div>
        </div>

</div>
<div class="row">
       <div class="col-xs-4">
       	<div  class="form-group">
       <input type="text" name="txtissuedposition" id="txtissuedposition" value="<?php echo $Position; ?>" class="form-control" readonly="true" placeholder="POSITION/OFFICE:">
        	</div>
  </div>   
</div>


<br/>

 <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;PPE to Issue</a></li>
    <li><a data-toggle="tab" href="#menu1" id="newppetab">List of PPE Issued</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <br/>
      <div class="row">
  <div class="col-xs-6">
      <button class="btn btn-primary" id ="btntempppeissuance"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button>
  </div>
    <div class="col-xs-4">
     
  </div>
    <div class="col-xs-2">
      <button class="btn btn-primary" id="btnsaveppeissuance" style="float:right"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Submit</button>
  </div>  
</div>
<br/>
      <div class="row">
         <div class="col-xs-12">
           <div >
          
             <table  class="table table-striped" id="tblrichie">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

                    <th>Account Title</th>
                    <th> Property Number</th>
                    <th>Description</th>
                    <th>Estimated usefull life</th>
                    <th>Qty</th>
                    <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails"></tbody>
             </table>
           </div>
         </div>
    </div>
     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "tabppe"></div>

    </div>
   
 
  </div>

</div></div>