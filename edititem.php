<?php
include 'cn.php';
$itemid = $_GET['itemid'];
$propertyno = $_GET['propertyno'];


$sql = "SELECT `propertyno`, convert(`dateaquired`,date) dateaquired, `description`,concat( `Serial` ,' ', `chasisnumber` )  `chasisnumber` , `amount`,
e.accounttitle,`item`, `yearoflife`,Fundcategory
FROM 
`t_equipmentdeliverydetails` a
  left join `m_equipent` b  on a.itemid = b.id and b.isactive = 1 
  left join t_equipmentdeliveryheader c on a.deliverycode = c.deliverycode and c.isactive = 1 
left join m_fundcluster d on c.sourceoffund = d.id and d.isactive =1 
left join m_accouttitle e on a.accounttitle = e.id and e.isactive =1 
where a.isactive = 1 and a.`propertyno` = '$propertyno' ";
$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);
$description = $arr['description'];
$amount = $arr['amount'];
$chasisnumber = $arr['chasisnumber'];
$accounttitle = $arr['accounttitle'];
$item = $arr['item'];
$yearoflife = $arr['yearoflife'];
$Fundcategory = $arr['Fundcategory'];
$dateaquired = $arr['dateaquired'];
echo '<div class="panel panel-primary">
<div class="panel-heading">Article/Item Details</div>
<div class="panel-body" >
   <div class="row">
    <div class="col-xs-6">
         
     <div class="form-group has-feedback">
         <input type="text" class="form-control" placeholder="Fund Source" 
         value = "'.$Fundcategory.'"
         id="txtsource" name= "txtsource" required="true" readonly="true">
         <span class="glyphicon glyphicon-bookmark form-control-feedback"></span>
    
       </div>
   </div> 
   <div class="col-xs-4"><label>Date Acquired</label>
       <input type="date" name="dtpdateaquired"
        id="dtpdateaquired" value="'.$dateaquired .'">
   </div>

   </div>


   <div class="row">
          <div class="col-xs-6">
         
     <div class="form-group has-feedback">
         <input type="text" class="form-control" value ="'.$accounttitle.'"
          placeholder="Account Title" id="txtaccount" name= "txtaccount" required="true" readonly="true">
         <span class="glyphicon glyphicon-tag form-control-feedback"></span>
    
       </div>
   </div>
 
       <div class="col-xs-4">
         
     <div class="form-group has-feedback">
         <input type="text" class="form-control" value="'.$item.'"
          placeholder="Article/Item:" id="txtarticlee" name= "txtarticlee" required="true" readonly="true">
         <span class="glyphicon glyphicon-tags form-control-feedback"></span>
    
       </div>
   </div>
   </div>
   <div class="row">
        <div class="col-xs-6">
          
          <div class="form-group has-feedback">
         <input type="text" class="form-control"
         value="'.$yearoflife.'" placeholder="Estimated Useful Life:" id="txtestimated" name= "txtestimated" required="true" readonly="true" >
         <span class="glyphicon glyphicon-menu-hamburger form-control-feedback"></span>
    
       </div>
        </div> 
        <div class="col-xs-4">  <div class="form-group has-feedback">
         <input type="text" class="form-control" value="'.$amount.'"
         placeholder="Amount" id="txtamount" name= "txtamount" required="true" >
         <span class=" glyphicon glyphicon-ruble form-control-feedback"></span>
    
       </div></div>


   </div>
   <div class="row">
     <div class="col-xs-10">
       <div class="form-group has-feedback">
         <input type="text" class="form-control" 
         value="'.$description.'"
         placeholder="Description" id="txtdesc" name= "txtdesc" required="true" >
         <span class="glyphicon glyphicon-tasks form-control-feedback"></span>
     </div>
       </div>
   </div>

    <div class="row">
     <div class="col-xs-5">
       <div class="form-group has-feedback">
         <input type="text" class="form-control" value="'.$chasisnumber .'" placeholder="Serial Number" id="txtserial" name= "txtserial" required="true" >
         <span class="glyphicon glyphicon-equalizer form-control-feedback"></span>
     </div>
       </div>
       
   </div>



   </div>


</div>
<button class="btn btn-primary btnsaveedititem" id="btn|'.$propertyno.'"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span></button>
 
';
?>