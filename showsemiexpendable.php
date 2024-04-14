
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

    ?>
    <div class="container-fluid">
    <div class="row">
        <div class="cols">
        <div class="form-group"> 

            <input type="text" class="form-control" id="txtseachsemirec"
             name="txtseachsemirec" placeholder="Search Item name and press enter">
        </div>
        <table id="" class="table" style="width:100%;">
                           
        
        <tr style="background-color: #337ab7;color:white;">
                 
                            <th>Account Title</th>
                                <th>Item Name</th>
                                <th>Estimated Usefull Life</th>
                            
                                <th>Units</th>
                             
                            
                                
                            </tr>
                <tbody id="tblsearchsss">
                            <?php 
                                $sqlmenu = "SELECT  
                                a.`id`, `itemno`, b. `accounttitle`, `item`,  `yearoflife`, `units`
                                
                                FROM `m_equipent` a 
                                left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
                                left join m_units c on a.`unitofmeasurement` = c.id and c.isactive =1 
                                where a.isactive =1  and b.typeofasset = 2 ";

                                $qrymenu = mysqli_query($con,$sqlmenu);
                                while($row = mysqli_fetch_array($qrymenu)){
                                    echo '<tr id = "'.$row['id'].'" class="selectmyid">
                                    <td>'.$row['accounttitle'].'</td>
                                    
                                        <td>'.$row['item'].'</td>
                                        <td>'.$row['yearoflife'].'</td>
                                        
                                        <td>'.$row['units'].'</td>
                                      
                                        
                                    </tr>';

                             
                                }
                            ?>
                </tbody>
            </table>
        </div>
    </div>
    <br/>

  

</div>


<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>