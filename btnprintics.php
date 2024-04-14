<style>
  .printbox {
    border-style: solid;
    border-color: black;
    border-width: 1px;
  }

  .textpost {
    text-align: center;
    vertical-align: top;
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

where a.isactive = 1  and a.PARNO =  '$mydata' "; 
$qry = mysqli_query($con,$sql);
$arr = mysqli_fetch_array($qry);

// echo $sql;
?>
<div class="row">
  <div class="cols-xs-8"></div>
  <div class="cols-xs-2"> <i> <span style="float:right;padding:20px;">Appendix 59</span></i></div>
</div>
<div class="row">
  <div class="col-xs-3">
    <div class="image-container">
      <img src="img/Logo.bmp" width="80" height="80"></div>
  </div>
  <div class="col-xs-6" style="text-align:center"><b>Republic of the Philippines</b><br />
    <b>Department of Environment and Natural Resources</b> <br />
    <b><?php echo $ResponsibilityCenter; ?></b> <br />

  </div>
  <div class="col-xs-2"></div>
</div>
<div class="row">
  <div class="col-xs-12">
    <center>
      <h4><b>INVENTORY CUSTODIAN SLIP</b></h4>
    </center>
  </div>
</div>

<br />
<div class="row">
  <div class="col-xs-8">
    <b>Entity Name:</b> &nbsp;&nbsp;&nbsp;&nbsp;<u>PENRO Isabela</u>
  </div>
  <div class="col-xs-4">

  </div>
</div>
<div class="row">
  <div class="col-xs-8">
    <b>Fund Cluster: </b> &nbsp;&nbsp;<u><?php echo $arr['Fundcluster']; ?>
  </div>
  <div class="col-xs-4">
    <b>ICS No.: </b> &nbsp;&nbsp;<u><?php echo $arr['PARNO']; ?></u>
  </div>
</div>
<br />
<div class="row">
  <div class="col-xs-12">
    <div class="table-responsive">
      <table style="border-style: solid;" border="1">
        <tr>
          <th class="printbox" rowspan="2" width="10%">
            <center>Quantity</center>
          </th>
          <th class="printbox" rowspan="2" width="10%">
            <center>Units</center>
          </th>
          <th class="printbox" colspan="2">
            <center>Amount</center>
          </th>
          <th class="printbox" rowspan="2" width="40%">
            <center>Description</center>
          </th>
          <th class="printbox" rowspan="2" width="10%">
            <center>Property No.</center>
          </th>
          <th class="printbox" rowspan="2" width="10%">
            <center>Estimated Useful Life</center>
          </th>

        </tr>
        <tr>
          <th class="printbox" width="10%">
            <center>Unit Cost</center>
          </th>
          <th class="printbox" width="10%">
            <center>Total Cost</center>
          </th>

          <?php 
                $sqlpar = "SELECT
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

,format((a.qty * b.amount),2) Totalcost,
a.propertyno 
FROM `t_pardetails` a 
left join t_equipmentdeliverydetails b on a.`itemid` = b.id and b.isactive =1 
where a.parno = '$mydata' and a.tag = 2 ";
  $qrypar  = mysqli_query($con,$sqlpar);
              
           
              ?>

        </tr>
        <?php
  while ($itemrow =mysqli_fetch_array($qrypar)) {
    echo  '<tr  style="height:300px;">
              <td class="printbox textpost"><center>'.$itemrow['qty'].'</center></td>
              <td class="printbox textpost"><center>'.$itemrow['Units'].'</center></td>
              <td class="printbox textpost"><center><span>&#8369;</span>'.$itemrow['amount'].'</center></td>
              <td class="printbox textpost"><center><span>&#8369;</span>'.$itemrow['Totalcost'].'</center></td>
              <td class="printbox textpost"><center>'.ucwords(strtolower($itemrow['Description'])).'</center></td>
              <td class="printbox textpost"><center>'.$itemrow['propertyno'].'</center></td>
              <td class="printbox textpost"><center>'.$itemrow['yearoflife'].'</center></td>

          </tr>';
  }

          ?>

        <tr>
          <td colspan="4" width="65%">
            <b>Received From</b>
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
                  <td>______________________________________</td>
                </tr>
                <tr>
                  <td>
                    <center>Signature Over Printed Name</center>
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
                    <center>Position / Office</center>
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
          <td colspan="3" width="35%">
            <b>Received By</b>

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
                    <center>Signature Over Printed Name</center>
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
                    <center>Position / Office</center>
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