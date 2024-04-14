<?php
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;

$myid = $_GET['myid'];
$myhdid = $_GET['myhdid'];

$sql = "SELECT  
a.`id`, `itemno`, b. `accounttitle`, `item`,  `yearoflife`, `units`
,b.id titleid
FROM `m_equipent` a 
left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
left join m_units c on a.`unitofmeasurement` = c.id and c.isactive =1 
where a.isactive =1  and b.typeofasset = 2 and a.id = $myid";

$qry = mysqli_query($con,$sql);

$nsq = "SELECT b.id  FROM `t_equipmentdeliverydetails` a 
left join m_equipent b on a.`itemid` = b.id  and b.isactive =1 
where a.isactive = 1 and `propertyno` = '$myhdid' ";


$nqry = mysqli_query($con,$nsq);
$prid = 0;
while($fet = mysqli_fetch_array($nqry)){
  $prid = $fet['id'];

}


while($arr = mysqli_fetch_array($qry)){
  echo '   <table class="table table-striped">
  <tr>
      <td>Article :</td>
      <td>
          <div class = "form-group">
                  <input type="text" id ="itemShowmore" 
                  class= "form-control"
                  value = "'.$arr['item'].'"
                  
                  readonly = "true" /> 
          </div>
          </td>
          </tr>
  <tr>
      <td>Account Title</td>
      <td> 

      <div class="form-group has-feedback">


      <input type="text" id ="optClass2222" 
                  class= "form-control"
                  disabled
                  value = "'.$arr['accounttitle'].'"
                  /> 


  </div>
      </td>
  </tr>
  <tr>
      <td>Remarks</td>
      <td><div class="form-group">
     
      <input type="hidden" id= "recid" value="'. $myid .'">    
      <input type="hidden" id= "myhdid" value="'. $prid .'">    
      <input type="hidden" id= "titleid" value="'. $arr['titleid'] .'">  
      <input type="hidden" id= "prop" value="'. $myhdid.'">  
      <input type="text" id ="reclassremarks" class="form-control" placeholder="Remarks Here">
      </div></td>
  </tr>
</table>';
  
}
  ?>