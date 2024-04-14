<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;



$sql = "SELECT 
(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) rid,
 rc.ResponsibilityCenter Responsibility,
`userid`,
`username`,
concat( `fname`,' ', substring(`mname`,1,1),'. ' , `lname`) Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic
,sec.Section ,up.Position ,sec.id sectionid
FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1
left join a_responsibilitycenter rc on up.`ResponsibilityCenter` = rc.id and rc.isactive = 1 
left join a_section sec on up.section = sec.id and sec.isactive = 1 
where au.isactive = 1 and ifnull(rc.ResponsibilityCenter,'')!='' and `userid` = $uid ";
    $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

$rid = $arr['rid'];    
$sectionid = $arr['sectionid'];
    $Position =  $arr['Responsibility'] . " | ".$arr['Position']; 
  $Completename = $arr['Completename'];
 $sqlapprover = "SELECT 

a.userid ,CompleteName ,section ,Position
FROM `a_deparmentapproval` a 
left join (
    SELECT 
userid ,
concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) CompleteName, `Position`
,z.section
FROM `a_user` x 
left join u_profile y on x.`profileid` = y.profileid and y.isactive = 1 
left join a_section z on y.`Section` = z.id and z.isactive = 1 
where x.isactive =1 

) b on a.userid = b.userid 
where a.isactive = 1 
and  `responsibilitycenterid` = $rid
and  `sectionid` = $sectionid

" ;
$qryapprover = mysqli_query($con,$sqlapprover);
$approverid = 0;
$approvername = "";
$approversectionposition ="";

while ($row= mysqli_fetch_array($qryapprover)) {
    $approverid = $row['userid'];
    $approvername = $row['CompleteName'];
    $approversectionposition = $row['section'] .' | ' . $row['Position'];  
}

 ?>

<div class="panel panel-primary">
   <div class="panel-heading">PROPERTY TRANSFER REPORT (PTR)</div>
  <div class="panel-body" >
<div class="row">
       <div class="col-xs-4">
       
       DATE TRANSFERRED: <input type="date" name="dtpissued" id="dtpissued">

        </div>


</div>
<br/>
<div class="row">
       <div class="col-xs-4">
        <div  class="form-group">
        <input type="text" name="txtsimeitem" id="txtsimeitem" class="form-control" readonly="true" placeholder="Property Number:">
          </div>
        </div>
       <div class="col-xs-4">
        <div  class="form-group">
        <input type="text" name="txtsemidesc" id="txtsemidesc" class="form-control" readonly="true" placeholder="Description:">
          </div>
        </div>


</div>
<div class="row">
       <div class="col-xs-8">
        <div  class="form-group">
        <input type="text" name="txttransferedto" id="txttransferedto" class="form-control" readonly="true" placeholder="Transfer To:">
          </div>
        </div>

</div>
<div class="row">
       <div class="col-xs-4">
        <div  class="form-group">
            <SELECT class="form-control" id="seltypeoftransfer">
<option value="Select Option">Select Option</option>
<option value="DONATION">DONATION</option>
<option value="REASSIGNMENT">REASSIGNMENT</option>
<option value="RELOCATE">RELOCATE</option>
<option value="OTHERS">OTHER (SPECIFY)</option>

            </SELECT>
          </div>
  </div> 

      <div class="col-xs-4">
        <div class="form-group">
            <input type="text" name="txtothers" id="txtothers" class="form-control richiehide" placeholder="Specify if Others" />
        </div>
  </div>     
</div>
<div class="row">
       <div class="col-xs-4">
          <div class="form-group">
              Condition of Inventory Item : <select class="form-control" id="selcondition">
                   <option value ="Select Option">Select Option</option>
                  <option value ="Serviceable">Serviceable</option>
                  <option value ="For Repair">For Repair</option>
                  <!-- <option value ="Unserviceable">Unserviceable</option> -->
                  <option value ="For Disposal">For Disposal</option>
                  <!-- <option value ="Disposed">Disposed</option> -->

              </select>
          </div>
        </div>   
</div>
<div class="row">
    <div class="col-xs-8">
        <div class="form-group">
            Reason for Transfer <textarea name="txtreason" id="txtreason" class="form-control" cols="10" row="6"></textarea>  
        </div>
    </div>
</div>
<hr/>
<div class="row">
       <div class="col-xs-4">
        <div  class="form-group">
          Approved By
          <input type="hidden" name="txthiddenid" id="txthiddenid" value="<?php echo $approverid; ?>">
        <input type="text" name="txtapprovedby" id="txtapprovedby" class="form-control" readonly="true" placeholder="Approved By:"  value="<?php echo $approvername ; ?>">
          </div>
        </div>

</div>
<div class="row">
       <div class="col-xs-8">
        <div  class="form-group">
       <input type="text" name="txtapprovedposition" id="txtapprovedposition" class="form-control" readonly="true" placeholder="OFFICE/POSITION:" value="<?php echo $approversectionposition; ?>">
          </div>
  </div> 
</div>
<div class="row">
       <div class="col-xs-4">
        <div  class="form-group">
          Issued By
        <input type="text" name="txtissued" id="txtissued" class="form-control" readonly="true" placeholder="Issued By:" value="<?php echo $Completename; ?>">
          </div>
        </div>

</div>
<div class="row">
       <div class="col-xs-8">
        <div  class="form-group">
       <input type="text" name="txtissuedposition" id="txtissuedposition" class="form-control" readonly="true" placeholder="OFFICE/POSITION:" value="<?php echo $Position; ?>">
          </div>
  </div>   
</div>



<br/>

 <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp;PPE to Transfer</a></li>
    <li><a data-toggle="tab" href="#menu1" id="tabptr">List of PPE Transfered</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <br/>
<div class="row">
  <div class="col-xs-6">
      <button class="btn btn-primary" id ="btntempptr"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button>
  </div>
    <div class="col-xs-4">
     
  </div>
    <div class="col-xs-2">
      <button class="btn btn-primary" id="btnsaveptr" style="float:right" ><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Submit</button>
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
      <div id= "tabptrdetails"></div>

    </div>
   
 
  </div>

</div></div>