<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$transcode = $_GET['transcode'];
$Suppliername = $_GET['Suppliername'];
$Pono = $_GET['Pono'];
$PoDate = $_GET['PoDate'];
$receiptno = $_GET['receiptno'];
$datereceived = $_GET['datereceived'];

echo '<div class="row">
        <div class="col-xs-6">
        Supplier : '.$Suppliername.' 
        <br/>P.O. Number : '.$Pono.' 
        <br/> P.O. Date : '.$PoDate.'
        </div>

        <div class="col-xs-6">
            Receipt No.: '.$receiptno.'
         <br/> 
            Delivery Date : '.$datereceived.'
           <br/><br/> 
           <button class="btn btn-primary bntprintresi" id="'.$transcode.'"><span class="glyphicon glyphicon-print"></span>  &nbsp;&nbsp; Print</button>
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
                    <th>Amount</th>
                   
                </tr>
              </thead>
                <tbody>';
?>



                    <?php
                        $sqldet = "SELECT 

accounttitle, stockno,item itemname ,description, `qty`,Units,amount, 
format((`amount`* qty),2) totalAmount

FROM `t_itemreceived` a 
left join (SELECT x.id,z.accounttitle, `stockno`,item,`description`,za.units FROM `m_materials` x 
left join m_itemname y on x.`item` = y.id and y.isactive  = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.units = za.id and za.isactive = 1 
where x.isactive = 1 ) b on a.itemid = b.id

where `transcode` = '$transcode' and a.isactive = 1 
union all 
SELECT 

 'Total', '','' ,'', '','','', format(SUM((`amount`* qty)),2) totalAmount

FROM `t_itemreceived` a 
left join (SELECT x.id,z.accounttitle, `stockno`,itemname,`description`,za.units FROM `m_materials` x 
left join m_itemname y on x.`item` = y.id and y.isactive  = 1 
left join m_accouttitle z on x.`titleid` = z.id and z.isactive = 1 
left join m_units za on x.units = za.id and za.isactive = 1 
where x.isactive = 1 ) b on a.itemid = b.id
where `transcode` = '$transcode' and a.isactive = 1 ";
                    
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
                    <td>'.ucwords(strtolower($rowdet['itemname'])) .'</td>
                    <td>'.ucwords(strtolower($rowdet['description'])) .'</td>
                    <td>'.$rowdet['qty'] .'</td>
                    <td>'.$rowdet['Units'] .'</td> 
                    <td><span>&#8369;</span>'.$rowdet['totalAmount'] .'</td>
                   </tr>'; 
}

                    ?>


                </tbody></table>
              


                 

         