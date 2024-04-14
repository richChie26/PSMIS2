<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
$selrsmi = $_GET['selrsmi'];
$txtsearchnewrsmi = $_GET['txtsearchnewrsmi'];
     
          $sql = "SELECT `code` rsmicode,convert(`creationdate`,date) rsmiDate  FROM `t_rsmicode`
            where code like '%".$txtsearchnewrsmi."%'
           order by id desc ";


  $qry = mysqli_query($con,$sql);
$forprint = "";
while ($row = mysqli_fetch_array($qry)) {
$forprint = '<a href="#" class="btnprintrsmi" id="ptr'. '|'. $row['rsmicode'] .'"><span class="glyphicon glyphicon-print" style="color:#337ab7;"></span></a>';
  echo '<tr >  
  <td data-toggle="collapse" data-target="#'. $row['rsmicode'] .'" class="accordion-toggle">'.$row['rsmicode'].'</td>
    <td data-toggle="collapse" data-target="#'. $row['rsmicode'] .'" class="accordion-toggle">'.$row['rsmiDate'].'</td>
      
       <td><center></center></td>
        </tr>';
$risno = $row['rsmicode'];
$sqllist = "
SELECT  `approvedqty`,`risno`, `purpose`,c.`status`, item,
stockno,
units
,e.`rsmicode`, `rsmiDate`,rccode ,r.ResponsibilityCenter
 FROM `t_requisitiondetails` a
left join (SELECT f.`id`, `item`, `stockno`, h.units  
 FROM 
`m_materials` f 
left join m_itemname g on f.`item` = g.itemname and g.isactive =1
left join m_units h on f.`units` = h.id and h.isactive = 1) b on a.`itemid` = b.id 
left join t_requesitionhead c on a.`RSIcode` = c.risno and c.isactive = 1 
left join t_rsmidetails d on d.rsiid = c.id 
left join t_rsmi e on d.codes = e.rsmicode
left join a_responsibilitycenter r on e.ResponsibilityCenter = r.id and r.isactive = 1 
where  ifnull(e.newrsmicode,'') != ''  and ifnull(e.newrsmicode,'') = '$risno'

 ";


$qrylist = mysqli_query($con,$sqllist);
?>


  <tr>
            <td colspan="12" class="hiddenRow">
              <div class="accordian-body collapse" id="<?php echo $row['rsmicode'] ;?>"> 
              <table class="table table-striped">
                      <thead>
                        <tr class="info">
                           
                
                     <th> RIS No</th>
                     <th> Resposibility Center</th>
                    <th>Stock No.</th>
                    <th>Item</th>
                    <th>Units</th>
                    <th>Quantity Issued</th> 
                  
                      
                        </tr>
                      </thead>  
                      
                      <tbody id="tbl<?php echo $row['risno']; ?>">
                        <?php 

                       
                          while ($newrow = mysqli_fetch_array($qrylist)) {
$sss = "<span>&#8369;</span> &nbsp;";
$sd = "";
if($newrow['risno'] == "Total"){
$sss = "";
$sd = "";
}else{
  $sss = "<span>&#8369;</span> &nbsp;";
  $sd = ucwords(strtolower($newrow['ResponsibilityCenter']));
}


                           echo '<tr>
                            <td>'.ucwords(strtolower($newrow['risno'])).'</td>
                             <td>'.$sd.'</td>
                            <td>'.$newrow['stockno'].'</td>
                            <td>'.ucwords(strtolower($newrow['item'])).'</td>
                              <td>'.ucwords(strtolower($newrow['units'])).'</td>
                            <td>'.$newrow['approvedqty'].'</td>
                                   
                           </tr>';

                          }
                        ?>
                    
                           
                      </tbody>
                </table>
              
              </div> 
          </td>
        </tr>
<?php
}
?>