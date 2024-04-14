
<head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

  $btnid = $_GET['btnid'];


  $sql = "SELECT a.`typeofasset`,b.typeofassets FROM `m_accouttitle` a 
left join m_assets b on a.typeofasset = b.id and b.isactive = 1

WHERE a.`isactive` = 1  and a.`id` = $btnid";

  $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);
  if($arr['typeofasset'] == 1 ){
?>   

 <div class="showimportaccount">
       <div class="row">
          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
          
       <input type="text" class="form-control" placeholder="Item  Name" id="txtartivle" name= "txtartivle" required="true" readonly="true">
            <span class="glyphicon glyphicon-gift form-control-feedback"></span>
        </div></div>
     
      </div>

      <div class="row">
         <div class="col-xs-12">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Description" id="txtdescription" name= "txtdescription" required="true">
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
       
          </div>
        </div>
</div>
    
<div class="row">
         <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            
           <select class="form-control" id="mnuunits" name = "mnuunits">
                <option value="Select Units">Select Units</option>
                <?php 
                  $sqlunit = "SELECT `id`, `units` FROM `m_units` WHERE `isactive` = 1 
order by `units` Asc ";
                $qryunits = mysqli_query($con,$sqlunit);
                while ($rowunits = mysqli_fetch_array($qryunits)) {
                  echo '<option value = "'.$rowunits['id'] .'">'.$rowunits['units'] .'</option>';
                }
                ?>


           </select>
       
          </div>
        </div>

          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Re-order Point" id="txtreorder" name= "txtreorder" required="true">
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
       
          </div>
        </div>
</div>
   
<div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnmaterialssave"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
          </div>
        </div>
  <div class="col-xs-8">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnItemimport" style="float: right;"><span class="glyphicon glyphicon-import">&nbsp;Import</span></button>
          
          </div>
        </div>

   </div>


<div class="panel panel-primary">
    <div class="panel-heading">List of <?php echo $arr['typeofassets']; ?></div>
  <div class="panel-body" >

    <div class="row">
   
        <div class="col-xs-4">
        <div class="form-group">
            <select id="Matsearchoption" class="form-control"  style="display:none;">
                <option>Stock Number</option>
                <option value="Item Name">Item Name</option>
                <option value="Descriptions">Descriptions</option>
            </select>
       </div>
        
        </div>
         <div class="col-xs-5">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Search Supply and Materials" id="txtsearchmat" name= "txtsearchmat" required="true" style="display:none;">
            <span class="glyphicon glyphicon-zoom-in form-control-feedback text-info" style="display:none;"></span>
       
          </div>
        </div>
         <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnsearchmat" style="display:none;"><span class="glyphicon glyphicon-zoom-in" style="display:none;"></span></button>
           
          </div>
        </div> 
           <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnrefreshmat" style="display:none;"><span class="glyphicon glyphicon-refresh" style="display:none;"></span></button>
           
          </div>
        </div> 
       
     </div>
     
    </form> 
    <div class="row">
         <div class="col-xs-12">
           <div >
             <table  id="example"  style="width:100%"   class ="display">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           


                    <th>Account Title</th>
                    <th>Stock No.</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Unit of Measure</th>
                    <th>Reorder Point</th>
                    <th>Edit</th>
                    <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails">
                    <?php
                        $sql1 = 'SELECT 
              a.id ,
              b.accounttitle,
              a.item, `stockno`, `description`
              ,c.units

              ,

              `titleid`,a.`units` unitsid,reorderpoint,d.id itemid 
              FROM `m_materials` a 
              left join m_accouttitle b on a.`titleid` = b.id and b.isactive =1 
              left join m_units c on a.`units` = c.id and c.isactive = 1 
              left join m_itemname d on a.item = d.id and d.isactive = 1 
              where a.isactive = 1  and titleid = '.$btnid.'
                  order by `description` Asc


    ';
 
$qry1 = mysqli_query($con,$sql1);
  while($row = mysqli_fetch_array($qry1)){
    echo ' <tr> <td>'. $row['accounttitle'].'</td>
                <td>'. $row['stockno'].'</td>
                <td>'. $row['item'].'</td>
                <td>'. $row['description'].'</td>
                <td>'. $row['units'].'</td>
                 <td>'. $row['reorderpoint'].'</td>
              

     <td><center><a href="#" class="btnmatedit" id="
     '.$row['id']. '|'
     .$row['titleid'].'|'
     .$row['item'].'|'
     .$row['stockno'].'|'
     .$row['description'].'|'
     .$row['unitsid'].'|'
     .$row['reorderpoint'].'|'
     .$row['itemid'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                <td><center><a href="#" class="bntmatremove" id="'.$row['id'].'|'.$row['description'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';


  }

                    ?>


                </tbody>
             </table>
           </div>
         </div>
    </div>



 </div> </div>


    
</div>
<?php
  }else{
  ?>
  <div class="row">
          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Item/Article" id="txtartivle" name= "txtartivle" required="true"  readonly="true">
            <span class="glyphicon glyphicon-gift form-control-feedback"></span>
       
          </div>
        </div>
        <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <select class="form-control" id="mnuunits">
              
              <option value="0">Select Units</option>
              <?php 
                $sqlunits = "SELECT `id`, `units` FROM `m_units` WHERE isactive = 1 order by `units` Asc";
                $qryunits = mysqli_query($con,$sqlunits);
                while ($rowunits = mysqli_fetch_array($qryunits)) {
                  echo '<option value="'.$rowunits['id'].'">'.$rowunits['units'].'</option>';
                }
              ?>
            </select>       
          </div>
        </div>
         <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="Number" class="form-control" placeholder="Useful Life" id="txtyearoflife" name= "txtyearoflife" required="true">
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
       
          </div>
        </div>
      </div>

    <div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnmaterialssave"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
          </div>
        </div>
  <div class="col-xs-8">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnItemimport" style="float: right;"><span class="glyphicon glyphicon-import">&nbsp;Import</span></button>
          
          </div>
        </div>

   </div>

<div class="panel panel-primary">
   <div class="panel-heading">List of <?php echo $arr['typeofassets']; ?></div>
  <div class="panel-body" >

    <!-- <div class="row">
   
     
         <div class="col-xs-5">
         <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Search Supply and Materials" id="txtsearchmat" name= "txtsearchmat" required="true" style="display:none;">
            <span class="glyphicon glyphicon-zoom-in form-control-feedback text-info" style="display:none;" ></span>
       
          </div>
        </div>
         <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-info" id="btnsearchmat" style="display:none;" ><span class="glyphicon glyphicon-zoom-in" style="display:none;"></span></button>
           
          </div>
        </div> 
           <div class="col-xs-1">
        <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnrefreshmat"style="display:none;" ><span class="glyphicon glyphicon-refresh" style="display:none;" ></span></button>
           
          </div>
        </div> 
       
     </div> -->
     
  
    <div class="row">
         <div class="col-xs-12">
           <div >
             <table  id="example"  style="width:100%"   class ="display">
               <thead style="background-color: #337ab7;color:white;">
                <tr>
                    <th>Account Title</th>
                    <th>Item/Article</th>
                    <th>Unit of Measure</th>
                    <th>Useful life</th>
                    <th>Edit</th>
                    <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails">
              <?php 
                  $sqlll = "SELECT a.id,
                    b.accounttitle,
                    `item`, `accountcode`, `yearoflife`
                      ,a.`accounttitle` aid , c.units ,unitofmeasurement
                    FROM `m_equipent` a 
                    left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
                    left join m_units c on a.unitofmeasurement  = c.id and c.isactive =1 
                    where a.isactive = 1
                    and a.`accounttitle` = $btnid ";
                    $qrylll = mysqli_query($con,$sqlll);
                    while($rowll = mysqli_fetch_array($qrylll)){
                        echo '
                         <tr>
                              <td>'.ucwords(strtolower($rowll['accounttitle'])).'</td>
                              <td>'.ucwords(strtolower($rowll['item'])).'</td>
                         <td>'.ucwords(strtolower($rowll['units'])).'</td>
                              <td>'.$rowll['yearoflife'].'</td>
                              <td><center><a href="#" class="btneditccc" id="
     '.$rowll['id']. '|'
     .$rowll['accounttitle'].'|'
     .$rowll['item'].'|'
     .$rowll['unitofmeasurement'].'|'
     .$rowll['yearoflife'].'|'
     .$rowll['aid'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
                              <td><center>
<a href="#" class="btnremovemyppe" id="'.$rowll['id']. '|'    .ucwords(strtolower($rowll['item'])).'">
<span style="color:red;" class="glyphicon glyphicon-minus"></span></a></center>
                              </td> 
                          </tr>

                        ';
                    }
              ?>


                </tbody>
             </table>
           </div>
         </div>
    </div>



 </div> </div>


   <?php
  }
?>

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>