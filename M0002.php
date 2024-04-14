
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


?> <div class="showimportaccount">

 <form action="#" method="post" id="frmMenu">
       
  <div id="myalert"><div class="alert alert-info" > <strong>Information!</strong> Please fill-up the form correctly!  .</div></div>
<!-- First row -->
       <div class="row">
                  
<div class="col-xs-4">
    <div class="form-group">
      <select class="form-control" id="seltitle">
        <option value="0">Select Option</option>
        <?php
          $sqlopt = "SELECT `id`, `accounttitle`,`typeofasset` FROM `m_accouttitle` WHERE  isactive = 1 
order by `typeofasset` ,`accounttitle` ASC ";
    $qryopt = mysqli_query($con,$sqlopt);
        while ($rowopt = mysqli_fetch_array($qryopt)) {
            echo '<option value="'.$rowopt['id'].'">'.$rowopt['accounttitle'].'</option>';
        }
        ?>

      </select>
    </div>
</div>
          <div class="col-xs-4">
       
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Item name " id="txtitemname" name= "txtitemname" required="true">
            <span class="glyphicon glyphicon-align-left form-control-feedback"></span>
       
          </div>
        </div>

    
      
      

        
  </div> 
  
 <!-- second row -->

  <!-- button row -->
   <div class="row">
      <div class="col-xs-4">
          <div class="form-group has-feedback">
                    <button class="btn btn-primary" id="btnsaveitemname"><span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span></button>
          
          </div>
        </div>

   </div>
 
     
    </form> 
    <div class="row">
         <div class="col-xs-12">
           <div >
             <table  <table id="example"  style="width:100%"   class ="display">
              
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           
                <th width="20%">Type of Asset </th>
                   <th width="30%">Account Title </th>
                   <th width="30%">Item Name</th>
                    <th width="10%">Edit</th>
                    <th width="10%">Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails">

<?php 
 $sql = 'SELECT a.`id`, a.`itemname` , a.`accounttitle` accounttitleid ,b.accounttitle,c.typeofassets  FROM `m_itemname` a 
 left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
left join m_assets c on b.typeofasset = c.id and c.isactive =  1 

 WHERE a.`isactive` = 1 order by a.`itemname` ASC 
     ';
 $qry = mysqli_query($con,$sql);
   while($row = mysqli_fetch_array($qry)){
   
         
 
     echo ' <tr> 
     <td>'. $row['typeofassets'].'</td>
     <td>'. $row['accounttitle'].'</td>
     <td>'. ucwords(strtolower($row['itemname'])).'</td>
 
      <td><center><a href="#" class="btnedititemname" id="'.$row['id']. '|'.$row['itemname'].'|'.$row['accounttitleid'].'|'.$row['accounttitle'].'"><span class="glyphicon glyphicon-edit"  ></span></a></center></td>
 <td><center>
 <a href="#" class="btnremoveitemname" id="'.$row['id'].'|'.$row['itemname'] .'"><span style="color:red;" class="glyphicon glyphicon-minus"  ></span></a></center></td> </tr>';
 
 
   }

?>

                </tbody>
             </table>
           </div>
         </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>