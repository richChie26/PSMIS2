<?php 
         include 'cn.php';

         $result = array();
         
         if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
              $_SESSION["uid"]  = 0;
           }
           $uid = $_SESSION["uid"] ;
         
         $item = $_GET['item'];
         $sqlmenu = "SELECT  
                                    a.`id`, `itemno`, b. `accounttitle`, `item`,  `yearoflife`, `units`
                                    
                                    FROM `m_equipent` a 
                                    left join m_accouttitle b on a.`accounttitle` = b.id and b.isactive = 1 
                                    left join m_units c on a.`unitofmeasurement` = c.id and c.isactive =1 
                                    where a.isactive =1  and b.typeofasset = 2 and 
                                    item like '%$item%' ";

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