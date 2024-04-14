<style>
  .printbox {
    border-style: solid;
    border-color: black;
    border-width: 1px;
  }
</style>

<?php
	include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$mydata = $_GET['mydata'];
    // $mydata = "RIS-0001";
 
$sqlres = "SELECT a.`ResponsibilityCenter`,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];
$completename = $aarres['completename'];
$sql = "SELECT `PARNO`, date_format(`Dateissue`,'%M %d, %Y') Dateissue, date_format(`datereceived`,'%M %d, %Y') datereceived,b.Completename ReceivedBy , b.Position,(SELECT (SELECT concat('[',j.`code`,'] ',`Fundcategory`) FROM `m_fundcluster` j WHERE j.isactive =1 and j.id = g.sourceoffund) FROM `t_equipmentdeliverydetails` f left join t_equipmentdeliveryheader g on f.`deliverycode` = g.deliverycode and g.isactive = 1 where f.isactive = 1 and f.`id` = ( SELECT k.`itemid` FROM `t_pardetails` k where k.`parno` = a.PARNO order by k.id asc limit 1 )) Fundcluster

,c.Completename issuedby, c.position issuePosition
FROM `t_par` a left join (SELECT x.userid ,concat(`fname`,' ', substring(`mname`,1,1) ,'. ' , `lname`) Completename ,concat(z.section,' | ',y.position) Position FROM `a_user` x left join u_profile y on x.`profileid` = y.`profileid` and y.isactive = 1 left join a_section z on y.section = z.id and z.isactive =1 where x.isactive = 1 ) b on a.`receivedby` = b.userid

left join (SELECT x.userid ,concat(`fname`,' ', substring(`mname`,1,1) ,'. ' , `lname`) Completename ,concat(z.section,' | ',y.position) Position FROM `a_user` x left join u_profile y on x.`profileid` = y.`profileid` and y.isactive = 1 left join a_section z on y.section = z.id and z.isactive =1 where x.isactive = 1 ) c on a.issuedby = c.userid 

where a.isactive = 1 and tag =0 and a.PARNO =  '$mydata' "; 
$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);


?>
<div class="row">
  <div class="cols-xs-8"></div>
  <div class="cols-xs-2"> <i> <span style="float:right;padding:20px;">Appendix 71</span></i></div>
</div>
<div class="row">
  <div class="col-xs-3">
    <img src="img/logo.bmp" width="80" height="80"></div>
  <div class="col-xs-6" style="text-align:center"><b>Republic of the Philippines</b><br />
    <b>Department of Environment and Natural Resources</b> <br />
    <b><?php echo $ResponsibilityCenter; ?></b> <br />

  </div>
  <div class="col-xs-2"></div>
</div>
<div class="row">
  <div class="col-xs-12">
    <center>
      <h4><b>PROPERTY ACKNOWLEDGEMENT RECEIPT</b></h4>
    </center>
  </div>
</div>

<br />
<div class="row">
  <div class="col-xs-6">
    <b>Entity Name:</b> &nbsp;&nbsp;&nbsp;&nbsp;<u>PENRO Isabela</u>
  </div>
  <div class="col-xs-6">

  </div>
</div>
<div class="row">
  <div class="col-xs-8">
    <b>Fund Cluster: </b> &nbsp;&nbsp;<u><?php echo $arr['Fundcluster']; ?>
  </div>
  <div class="col-xs-4">
    <b>PAR No.: </b> &nbsp;&nbsp;<u><?php echo $arr['PARNO']; ?></u>
  </div>
</div>

<div class="row">
  <div class="col-xs-11">
    <div>

      <table class="table" style="border-style: solid;width: 95%;" border="1">
        <tr>
          <th width="10%" class="printbox">
            <center>Quantity</center>
          </th>
          <th width="10%" class="printbox">
            <center>Unit</center>
          </th>

          <th width="40%" class="printbox">
            <center>Description</center>
          </th>
          <th width="25%" class="printbox">
            <center>Property Number</center>
          </th>
          <th width="15%" class="printbox">
            <center>Date Acquired</center>
          </th>
          <th class="printbox">
            <center>Amount</center>
          </th>
        </tr>

        <?php 
                $sqlpar = "SELECT item,
(Select f.itemno from m_equipent  f 

left join m_units g on f.unitofmeasurement = g.id and g.isactive = 1 
 where f.isactive = 1 and f.id = b.itemid
)ItemNo 
,(Select f.yearoflife from m_equipent  f 

left join m_units g on f.unitofmeasurement = g.id and g.isactive = 1 
 where f.isactive = 1 and f.id = b.itemid
) yearoflife
,
(Select g.units from m_equipent  f 

left join m_units g on f.unitofmeasurement = g.id and g.isactive = 1 
 where f.isactive = 1 and f.id = b.itemid
) Units
,concat(b.`description`,' ',b.`Serial`) Description
,a.qty
,format(b.amount,2) amount

,format((a.qty * b.amount),2) Totalcost
,a.propertyno
,date_format(b.dateaquired,'%m-%d-%Y') dateaquired

,date_format(`PODate`,'%m-%d-%Y') PODate, `PONumber`,Suppliername
FROM `t_pardetails` a 
left join t_equipmentdeliverydetails b on a.`itemid` = b.id and b.isactive =1 
left join t_equipmentdeliveryheader c on b.deliverycode  = c.deliverycode and c.isactive = 1 
left join m_supplier d on c.Supplierid = d.id and d.isactive = 1 
left join m_equipent e on b.itemid = e.id and e.isactive =1 
where a.parno = '$mydata' and a.tag =0  ";
  $qrypar  = mysqli_query($con,$sqlpar);


$PODate = "";
  $PONumber = "";
 $Suppliername = "";   
 $Description = "";
$propertyno = "";
$dateaquired = "";
$amount = "";

$myitem = "";
 
  while ($itemrow =mysqli_fetch_array($qrypar)) {
    $Description = $itemrow['Description'];
$propertyno = $itemrow['propertyno'];
$dateaquired = $itemrow['dateaquired'];
$amount = $itemrow['amount'];
$myitem = $itemrow['item'];
    echo  '<tr style="height:200px;">
              <td class="printbox"><center>'.$itemrow['qty'].'</center></td>
              <td class="printbox"><center>'.$itemrow['Units'].'</center></td>       
             <td class="printbox"><center>'.ucwords(strtolower($itemrow['Description'])).'</center></td>
              <td class="printbox"><center>'.$itemrow['propertyno'].'</center></td>
              <td class="printbox"><center>'.$itemrow['dateaquired'].'</center></td>
            <td class="printbox"><center><span>&#8369;</span>'.$itemrow['amount'].'</center></td>
          </tr>';
$PODate = $itemrow['PODate'];
$PONumber = $itemrow['PONumber'];
$Suppliername = $itemrow['Suppliername'];

          
  }

          ?>
        <tr style="height:200px;">
          <td colspan="3" class="printbox">
            <?php
      echo 
'<div class="row"><div class="cols" style="padding:20px;">
<b>Supplier:</b>&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .$Suppliername .  '<br/>
<b>PO Date:</b> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$PODate . '<br/>
<b>PO Number:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
$PONumber .      
'</div></div>'
    ?>

          </td>
          <td colspan="3" class="printbox">
            <div style="  border-style: solid;
      border-color: #337ab7;
      border-width: 5px;
      height:100%;
      width:100%;
      font-size: 12px;
      color:#337ab7;
      ">
              <div class="row">
                <div class="col-xs-3">
                  <img src="img/logo.bmp" style="padding:10px;float:right;" width="80" height="80"></div>
                <div class="col-xs-6" style="text-align:center"><b>Republic of the Philippines</b><br />
                  <b>Department of Environment and Natural Resources</b> <br />
                  <b>Region 2, <?php echo $ResponsibilityCenter; ?></b> <br />

                </div>
                <div class="col-xs-2"></div>
              </div><br />
              <div class="row">
                <div class="col-xs-12">
                  <table style="margin:5px;">
                    <tr>
                      <td width="20%">Office: </td>
                      <td width="30%" style=" font-size:12px;"><u><?php echo $ResponsibilityCenter; ?></u></td>
                      <td width="20%">PAR No.: </td>
                      <td width="30%" style=" font-size:12px;"><u><?php echo $arr['PARNO']; ?></u></td>
                    </tr>
                    <tr>
                      <td>Article: </td>
                      <td style=" font-size:12px;"><u><?php echo $myitem; ?></u></td>
                      <td>Date Acquired: </td>
                      <td style="font-size:12px;"><u><?php echo $dateaquired; ?></u></td>
                    </tr>
                    <tr>
                      <td>Property No.: </td>
                      <td style=" font-size:12px;"><u><?php echo $propertyno; ?></u></td>
                      <td>Cost: </td>
                      <td style=" font-size:12px;"><u><?php echo $amount; ?></u></td>
                    </tr>
                    <tr>
                      <td colspan="2">Description:
                        <div style="border-style: solid;
                  border-color: #337ab7;
                  border-width: 2px;
                  height:150px;
                  width:100%;">
                          <?php echo $Description; ?></div>
                      </td>
                      <td colspan="2" style=" font-size:12px;"> <span style="padding:10px;"> Condition:
                          <u>Serviceable</u></span><br /><br />

                        <span style=" font-size:12px; margin:10px;"> Accountable Person:</span> <br />
                        <span style="padding:10px;"> <u><?php echo $arr['ReceivedBy']; ?></u><br><br /></span>
                        <span style=" font-size:10px;margin:10px;"> COA Representative:</span> <br>
                      </td>

                    </tr>

                  </table>
                </div>
              </div>
            </div>

          </td>

        </tr>
        <tr>

          <td colspan="3" width="35%">
            <b>Received by: </b>

            <br>
            <br>
            <center>
              <table cellpadding="1" cellspacing="1">
                <tr>
                  <td>
                    <center><?php echo $arr['ReceivedBy']; ?></center>
                  </td>
                </tr>
                <tr>
                  <td>______________________________________</td>
                </tr>
                <tr>
                  <td>
                    <center>Signatue over Printed Name of End User</center>
                  </td>
                </tr>
              </table>
            </center>
            <br />
            <center>
              <table cellpadding="1" cellspacing="1">
                <tr>
                  <td>
                    <center><?php echo $arr['Position']; ?></center>
                    ____________________________________________
                  </td>
                </tr>
                <tr>
                  <td>
                    <center>Office/Position </center>
                  </td>
                </tr>
              </table>
            </center><br />
            <center>
              <table cellpadding="1" cellspacing="1">
                <tr>
                  <td>
                    <center><?php echo $arr['datereceived']; ?></center>
                  </td>
                </tr>
                <tr>
                  <td>______________________________________</td>
                </tr>
                <tr>
                  <td>
                    <center>Date</center>
                  </td>
                </tr>
              </table>
            </center>
          </td>

          <td colspan="4" width="65%">
            <b>Issued by: </b>
            <br>

            <br />
            <center>
              <table cellpadding="1" cellspacing="1">
                <tr>
                  <td>
                    <center><?php echo $arr['issuedby']; ?></center>
                  </td>
                </tr>
                <tr>
                  <td>_________________________________________________________</td>
                </tr>
                <tr>
                  <td>
                    <center>Signatue over Printed Name of Supply and/or Property Custodian</center>
                  </td>
                </tr>
              </table>
            </center>
            <br />
            <center>
              <table cellpadding="1" cellspacing="1">
                <tr>
                  <td>
                    <center><?php echo $arr['issuePosition']; ?></center>
                  </td>
                </tr>
                <tr>
                  <td>______________________________________</td>
                </tr>
                <tr>
                  <td>
                    <center>Office/Position </center>
                  </td>
                </tr>
              </table>
            </center><br />
            <center>
              <table cellpadding="1" cellspacing="1">
                <tr>
                  <td>
                    <center><?php echo $arr['Dateissue']; ?></center>
                  </td>
                </tr>
                <tr>
                  <td>______________________________________</td>
                </tr>
                <tr>
                  <td>
                    <center>Date</center>
                  </td>
                </tr>
              </table>
            </center>
          </td>

        </tr>
      </table>
    </div>
  </div>
</div>