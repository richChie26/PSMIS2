<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$risno = $_GET['risno'];
$purpose = $_GET['purpose'];
$Requestedby = $_GET['Requestedby'];
$DateRequest = $_GET['DateRequest'];

echo '<div class="row">
        <div class="col-xs-6">
        Purpose : '.$purpose.' 
        <br/>Date request : '.$DateRequest.' 
<div class="col-xs-6"><button class="btn btn-primary" id="btnprint">Print</button></div>

</div>      
        </div>

      </div> ';


echo '<div class="row">
         <div class="col-xs-12">
           <div >
            <br/>
             <table  class="table table-striped" id="richietable">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                     <th> Account Title</th>
                    <th>Stock No.</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Quantity</th> 
                    <th>Unit of Measurement</th>
            
                   
                </tr>
              </thead>
                <tbody>';
?>



                    <?php
                        $sqldet = "SELECT 
accounttitle,stockno,itemname,
description,`qty`,units
FROM `t_requisitiondetails` a 
left join (SELECT 
x.id,z.accounttitle,
itemname,`stockno`,`description`
,za.units
FROM `m_materials` x 
left join m_itemname y on x.item = y.id and y.isactive = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.`units` = za.id and za.isactive = 1  
where x.isactive = 1 ) b on a.`itemid` = b.id 
where `RSIcode` = '$risno'";
                    
                    $qrydet = mysqli_query($con,$sqldet);

while ( $rowdet = mysqli_fetch_array($qrydet)) {
    $myrow = "";
        if($rowdet['accounttitle'] == "Total"){
            $myrow =  '<span class= "colorred">' . $rowdet['accounttitle'] . '</span>' ;


        }else{
         $myrow =$rowdet['accounttitle'] ;
        }



        echo 
                   ' <tr><td>'.$myrow .'</td>
                    <td>'.$rowdet['stockno'] .'</td>
                    <td>'.$rowdet['itemname'] .'</td>
                    <td>'.$rowdet['description'] .'</td>
                    <td>'.$rowdet['qty'] .'</td>
                    <td>'.$rowdet['units'] .'</td> 
              
                   </tr>'; 
}

                    ?>


                </tbody></table>
              


                 

         