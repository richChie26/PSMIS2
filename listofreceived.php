<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $sql = "SELECT Suppliername,`transcode`,
`datereceived`, `Pono`, substring(`PODATE`,1,10) PoDate, `receiptno`
FROM `t_receivedheader` a 
left join m_supplier b on a.`supplierid` = b.id  and b.isactive =1 
where a.isactive = 1 and a.`createdby` = $uid order by a.id desc";

$qry = mysqli_query($con,$sql);




    ?>
    <br/>
   <table class="table table-striped">
<tr style="background-color: #337ab7;color:white;">
<th>Supplier </th> 
<th>P.O. Number </th> 
<th>P.O. Date </th> 
<th>Receipt Number </th> 
<th>Date Received</th> 
<th>Print ND</th> 
</tr>
<?php 
    while ($row = mysqli_fetch_array($qry)) {
        # code...

echo '
<tr >
<td>'.  ucwords(strtolower($row['Suppliername'])).' </td> 
<td>  '.$row['Pono'] .'</td> 
<td> '. $row['PoDate'] .'</td> 
<td>'. $row['receiptno'] .'</td> 
<td> '. $row['datereceived'] .'</td> 
<td>  <a href="#" class="itemset" id="'. $row['transcode'].'"><span class="glyphicon glyphicon-print"> </span></a > </td>

</tr>';
    }
?>

                                </table>