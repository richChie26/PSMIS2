<?php
include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;
$myid = $_GET['myid'];
$sqlkoto = "SELECT `id`, `accounttitle` FROM `m_accouttitle` WHERE isactive =1 and `typeofasset` in (3)"; 
$qrykoto = mysqli_query($con,$sqlkoto);
$myitem = "";
?>
<div class="container-fluid">
        <div class="row">
            <div class="cols">
    <h4>TRANSFER FROM:</h4>
            <table id="" class="table" style="width:100%;">
                                <tr style="background-color: #337ab7;color:white;">
                     
                                    <th>Property No</th>
                                    <th>Item Name</th>
                                    <th>Description</th>
                                    
                                    <th>Amount</th>
                                    <th>Account Title</th>
                                
                                    
                                </tr>
                    <tbody id="tblsearch">
                                <?php 
                                    $sqlmenu = "SELECT 
                                    description,   b.`id`,`itemno`, `item`, d.`accounttitle`, `yearoflife`, `units`
                                        ,format(amount,2) amount,propertyno
                                        FROM  t_equipmentdeliverydetails  a
                                        left join `m_equipent` b on a.itemid = b.id and b.isactive =1 
                                        left join m_units c on b.unitofmeasurement = c.id and c.isactive = 1 
                                        left join m_accouttitle d on b.accounttitle = d.id and d.isactive = 1
                                        WHERE b.isactive =1 and b.id =
                                        (select tp.itemid from t_equipmentdeliverydetails tp where  tp.propertyno =
                                          '$myid')
                                          and amount < 50000 ";
                                    // echo $sqlmenu;
                                    $qrymenu = mysqli_query($con,$sqlmenu);
                                    while($row = mysqli_fetch_array($qrymenu)){
                                        echo '<tr>
                                         
                                            <td>'.$row['propertyno'].'</td>
                                            <td>'.$row['item'].'</td>
                                            <td>'.$row['description'].'</td>
                                            
                                            <td>'.$row['amount'].'</td>
                                            <td>'.$row['accounttitle'].'</td>
                                            
                                        </tr>';

                                        $myitem = $row['item'];
                                    }
                                ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="cols">
            <h4 style="background-color:#337ab7; color:white; 
                 padding:10px; margin:0px;" >TRANSFER TO:</h4>
            </div>
        </div>
   
         <form>
        <div class="row">
            <div class="cols">
                <div id="showmydetails">
                    <table class="table table-striped">
                        <tr>
                            <td>Article :</td>
                            <td>
                                <div class = "form-group">
                                        <input type="text" id ="itemShowmore" 
                                        class= "form-control"
                                        readeOnly /> 
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
                                        readeOnly /> 
        
        
                        </div>
                            </td>
                        </tr>
                        <tr>
                        
                            <td>Remarks</td>
                            <td><div class="form-group">
                            <input type="hidden" id= "myhdid" value="<?php echo $myid; ?>">    
                            <input type="text" id ="reclassremarks" class="form-control" placeholder="Remarks Here">
                            </div></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div></form>
        <div class="row">
            <div class="cols">
                <button class="btn btn-primary" id="btnsavereclass"> Save </button>
            </div>
        </div>
</div>