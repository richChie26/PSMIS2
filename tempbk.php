<?php


if($uid == 1 ){
  $sql = "	SELECT 
  a.id ,
  b.accounttitle,
  a.item, `stockno`, `description`
  ,c.units
  
  ,
  
   ( SELECT 
  concat(`fname`,' ',substring(`mname`,1,1),' ', `lname`)
  
  
  FROM `a_user` x 
  left join u_profile y on x.profileid = y.profileid and y.isactive =1 
  WHERE x.isactive =1  and x.userid = a.createdby) createdby
  ,a.creationdate
  FROM `m_materials` a 
  left join m_accouttitle b on a.`titleid` = b.id and b.isactive =1 
  left join m_units c on a.`units` = c.id and c.isactive = 1 
  left join m_itemname d on a.item = d.id and d.isactive = 1 
  where a.isactive = 1   
      order by `description` Asc";
  
  $qry = mysqli_query($con,$sql);

  echo '<div style="width:100%; background-color: #337ab7;color:white; height: 40px;">
    <h3 style="margin-top:10px;margin-left:10px;padding-top:10px;"> List of Inventory Items</h3>
  </div>';
  echo '<table id="" class="display" style="width:100%;">
  <thead style="background-color: #337ab7;color:white;"> 
      <tr>
          <th>Account Title</th>
          <th>Item name</th>
          <th>Stock No</th>
          <th>Description</</th>
          <th>Unit of Measurement</th>
          <th>Created By</th>
          <th>Creation Date</th>
      </tr>
  </thead>
  <tbody>';
  
  while($row = mysqli_fetch_array($qry)){
    echo '<tr>';
  echo '     
        <td>' . $row['accounttitle'] . '</td> 
        <td>' . $row['item'] . '</td>
        <td>' . $row['stockno'] . '.</td>
        <td>' . $row['description'] . '</td>
        <td>' . $row['units'] . '  </td>
        <td>' . $row['createdby'] . '</td>
        <td>' . $row['creationdate'] . '</td>';
  
  echo '</tr>';
  }
  
  
  echo '  </tbody>
  
  </table>';
  $sql1 = "SELECT f.accounttitle,`propertyno`,b.item,a.`description`,convert(`dateaquired`,date) dateaquired , `Serial`, format(`amount`,2) amount, `chasisnumber`,c.units,yearoflife
  ,d.rccode,d.ResponsibilityCenter,
  `Status`,cname ,a.`creationdate` FROM `t_equipmentdeliverydetails`a 
  left join m_equipent b on a.`itemid` = b.id and b.isactive =1 
  left join m_units c on b.unitofmeasurement = c.id and c.isactive =1 
  left join a_responsibilitycenter d on a.`ResponsibilityCenter` = d.id and d.isactive =1
  left join (SELECT userid,concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname FROM `u_profile` x 
  left join a_user y on x.profileid = y.profileid and y.isactive =1 
  where x.isactive =1 ) e on a.`createdby` = e.userid 
  left join m_accouttitle f on b.accounttitle = f.id 
  where a.isactive = 1 and a.tag != 0 and a.ResponsibilityCenter = $rid";
  
  $qry1 = mysqli_query($con,$sql1);
  echo '<div style="width:100%; background-color: #337ab7;color:white; height: 40px;">
    <h3 style="margin-top:10px;margin-left:10px;padding-top:10px;"> List of Semi-Expendables</h3>
  </div>';
  echo '<table id="" class="display" style="width:100%;">
  <thead style="background-color: #337ab7;color:white;"> 
      <tr>
       <th>Account Title</th>
          <th>Item name</th>
          <th>Property No</th>
          <th>Description</</th>
          <th>Unit of Measurement</th>
          <th>Serial No</th>
      
          <th>Amount</th>
          <th>Usefull Life</th>
          
          <th>Responsibility Center</th>
          <th>Status</th>
          <th>Created By</th>
          <th>Creation Date</th>
      </tr>
  </thead>
  <tbody>';
  
  while($row1 = mysqli_fetch_array($qry1)){
    echo '<tr>';
  echo '     
    <td>' . $row1['accounttitle'] . '</td> 
        <td>' . $row1['item'] . '</td>
        <td>' . $row1['propertyno'] . '.</td>
        <td>' . $row1['description'] . '</td>
        <td>' . $row1['units'] . '  </td>
        <td>' . $row1['Serial'] . '  </td>

        <td>' . $row1['amount'] . '  </td>
        <td>' . $row1['yearoflife'] . '  </td>
        <td>' . $row1['ResponsibilityCenter'] . '  </td>
        <td>' . $row1['Status'] . '  </td>
        <td>' . $row1['cname'] . '</td>
        <td>' . $row1['creationdate'] . '</td>';
  
  echo '</tr>';
  }
  
  
  echo '  </tbody>
  
  </table>';
    
  $sql2 = "	SELECT f.accounttitle,`propertyno`,b.item,a.`description`,convert(`dateaquired`,date) dateaquired , `Serial`, 
  format(`amount`,2) amount, `chasisnumber`,c.units,yearoflife
  ,d.rccode,d.ResponsibilityCenter,
  `Status`,cname ,a.`creationdate` FROM `t_equipmentdeliverydetails`a 
  left join m_equipent b on a.`itemid` = b.id and b.isactive =1 
  left join m_units c on b.unitofmeasurement = c.id and c.isactive =1 
  left join a_responsibilitycenter d on a.`ResponsibilityCenter` = d.id and d.isactive =1
  left join (SELECT userid,concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) Cname FROM `u_profile` x 
  left join a_user y on x.profileid = y.profileid and y.isactive =1 
  where x.isactive =1 ) e on a.`createdby` = e.userid 
  left join m_accouttitle f on b.accounttitle = f.id 
  where a.isactive = 1 and a.tag = 0 and a.ResponsibilityCenter = $rid";
  
  $qry2 = mysqli_query($con,$sql2);
  echo '<div style="width:100%; background-color: #337ab7;color:white; height: 40px;">
    <h3 style="margin-top:10px;margin-left:10px;padding-top:10px;"> List of Property Plant and Equipment</h3>
  </div>';
  echo '<table id="" class="display" style="width:100%;">
  <thead style="background-color: #337ab7;color:white;"> 
      <tr>
          <th>Account Title</th>
          <th>Item name</th>
          <th>Property No</th>
          <th>Description</</th>
          <th>Unit of Measurement</th>
          <th>Serial No</th>
          <th>Chasis</th>
          <th>Amount</th>
          <th>Usefull Life</th>
          
          <th>Responsibility Center</th>
          <th>Status</th>
          <th>Created By</th>
          <th>Creation Date</th>
          
      </tr>
  </thead>
  <tbody>';
  
  while($row2 = mysqli_fetch_array($qry2)){
    echo '<tr>';
  echo '     
        <td>' . $row2['accounttitle'] . '</td> 
        <td>' . $row2['item'] . '</td>
        <td>' . $row2['propertyno'] . '.</td>
        <td>' . $row2['description'] . '</td>
        <td>' . $row2['units'] . '  </td>
        <td>' . $row2['Serial'] . '  </td>
        <td>' . $row2['chasisnumber'] . '  </td>
        <td>' . $row2['amount'] . '  </td>
        <td>' . $row2['yearoflife'] . '  </td>
        <td>' . $row2['ResponsibilityCenter'] . '  </td>
        <td>' . $row2['Status'] . '  </td>
        <td>' . $row2['cname'] . '</td>
        <td>' . $row2['creationdate'] . '</td>';
  
  echo '</tr>';
  }
  
  
  echo '  </tbody>
  
  </table>';
  

}else{

  // myelse================================================


  $sql = "	SELECT 
  a.id ,
  b.accounttitle,
  a.item, `stockno`, `description`
  ,c.units
  
  ,
  
   (SELECT 
  concat(`fname`,' ',substring(`mname`,1,1),' ', `lname`)
  
  
  FROM `a_user` x 
  left join u_profile y on x.profileid = y.profileid and y.isactive =1 
  WHERE x.isactive =1  and x.userid = a.createdby) createdby
  ,a.creationdate
  FROM  t_itemreceived xy 
  left join  `m_materials` a  on xy.itemid = a.id and a.isactive =1 
  left join m_accouttitle b on a.`titleid` = b.id and b.isactive =1 
  left join m_units c on a.`units` = c.id and c.isactive = 1 
  left join m_itemname d on a.item = d.id and d.isactive = 1 
  where xy.isactive = 1  
   and xy.ResponsibilityCenter =  $rid 
      order by `description` Asc";
  
  $qry = mysqli_query($con,$sql);

  // echo $sql;
  echo '<div style="width:100%; background-color: #337ab7;color:white; height: 40px;">
    <h3 style="margin-top:10px;margin-left:10px;padding-top:10px;"> List of Inventory Items</h3>
  </div>';
  echo '<table id="" class="display" style="width:100%;">
  <thead style="background-color: #337ab7;color:white;"> 
      <tr>
          <th>Account Title</th>
          <th>Item name</th>
          <th>Stock No</th>
          <th>Description<//th>
          <th>Unit of Measurement</th>
          <th>Created By</th>
          <th>Creation Date</th>
      </tr>
  </thead>
  <tbody>';
  
  while($row = mysqli_fetch_array($qry)){
    echo '<tr>';
  echo '     
        <td>' . $row['accounttitle'] . '</td> 
        <td>' . $row['item'] . '</td>
        <td>' . $row['stockno'] . '.</td>
        <td>' . $row['description'] . 'td>
        <td>' . $row['units'] . '  </td>
        <td>' . $row['createdby'] . '</td>
        <td>' . $row['creationdate'] . '</td>';
  
  echo '</tr>';
  }
  
  
  echo '  </tbody>
  
  </table>';
  $sql1 = "SELECT f.accounttitle,`propertyno`,b.item,a.`description`,convert(`dateaquired`,date) dateaquired , `Serial`, format(`amount`,2) amount, `chasisnumber`,c.units,yearoflife
  ,d.rccode,d.ResponsibilityCenter,
  `Status`,cname ,a.`creationdate` FROM `t_equipmentdeliverydetails`a 
  left join m_equipent b on a.`itemid` = b.id and b.isactive =1 
  left join m_units c on b.unitofmeasurement = c.id and c.isactive =1 
  left join a_responsibilitycenter d on a.`ResponsibilityCenter` = d.id and d.isactive =1
  left join (SELECT userid,concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname FROM `u_profile` x 
  left join a_user y on x.profileid = y.profileid and y.isactive =1 
  where x.isactive =1 ) e on a.`createdby` = e.userid 
  left join m_accouttitle f on b.accounttitle = f.id 
  where a.isactive = 1 and a.tag != 0
  and  a.`ResponsibilityCenter`= $rid
  
  ";
  
  $qry1 = mysqli_query($con,$sql1);
  echo '<div style="width:100%; background-color: #337ab7;color:white; height: 40px;">
    <h3 style="margin-top:10px;margin-left:10px;padding-top:10px;"> List of Semi-Expendables</h3>
  </div>';
  echo '<table id="" class="display" style="width:100%;">
  <thead style="background-color: #337ab7;color:white;"> 
      <tr>
       <th>Account Title</th>
          <th>Item name</th>
          <th>Property No</th>
          <th>Description</</th>
          <th>Unit of Measurement</th>
          <th>Serial No</th>
      
          <th>Amount</th>
          <th>Usefull Life</th>
          
          <th>Responsibility Center</th>
          <th>Status</th>
          <th>Created By</th>
          <th>Creation Date</th>
      </tr>
  </thead>
  <tbody>';
  
  while($row1 = mysqli_fetch_array($qry1)){
    echo '<tr>';
  echo '     
    <td>' . $row1['accounttitle'] . '</td> 
        <td>' . $row1['item'] . '</td>
        <td>' . $row1['propertyno'] . '.</td>
        <td>' . $row1['description'] . '</td>
        <td>' . $row1['units'] . '  </td>
        <td>' . $row1['Serial'] . '  </td>

        <td>' . $row1['amount'] . '  </td>
        <td>' . $row1['yearoflife'] . '  </td>
        <td>' . $row1['ResponsibilityCenter'] . '  </td>
        <td>' . $row1['Status'] . '  </td>
        <td>' . $row1['cname'] . '</td>
        <td>' . $row1['creationdate'] . '</td>';
  
  echo '</tr>';
  }
  
  
  echo '  </tbody>
  
  </table>';
    
  $sql2 = "	SELECT f.accounttitle,`propertyno`,b.item,a.`description`,convert(`dateaquired`,date) dateaquired , `Serial`, format(`amount`,2) amount, `chasisnumber`,c.units,yearoflife
  ,d.rccode,d.ResponsibilityCenter,
  `Status`,cname ,a.`creationdate` FROM `t_equipmentdeliverydetails`a 
  left join m_equipent b on a.`itemid` = b.id and b.isactive =1 
  left join m_units c on b.unitofmeasurement = c.id and c.isactive =1 
  left join a_responsibilitycenter d on a.`ResponsibilityCenter` = d.id and d.isactive =1
  left join (SELECT userid,concat(`fname`,' ', substring(`mname`,1,1),'. ', `lname`) cname FROM `u_profile` x 
  left join a_user y on x.profileid = y.profileid and y.isactive =1 
  where x.isactive =1 ) e on a.`createdby` = e.userid 
  left join m_accouttitle f on b.accounttitle = f.id 
  where a.isactive = 1 and a.tag = 0
  and  a.`ResponsibilityCenter`= $rid
  ";
  
  $qry2 = mysqli_query($con,$sql2);
  echo '<div style="width:100%; background-color: #337ab7;color:white; height: 40px;">
    <h3 style="margin-top:10px;margin-left:10px;padding-top:10px;"> List of Property Plant and Equipment</h3>
  </div>';
  echo '<table id="" class="display" style="width:100%;">
  <thead style="background-color: #337ab7;color:white;"> 
      <tr>
          <th>Account Title</th>
          <th>Item name</th>
          <th>Property No</th>
          <th>Description</</th>
          <th>Unit of Measurement</th>
          <th>Serial No</th>
          <th>Chasis</th>
          <th>Amount</th>
          <th>Usefull Life</th>
          
          <th>Responsibility Center</th>
          <th>Status</th>
      
          
      </tr>
  </thead>
  <tbody>';
  
  while($row2 = mysqli_fetch_array($qry2)){
    echo '<tr>';
  echo '     
        <td>' . $row2['accounttitle'] . '</td> 
        <td>' . $row2['item'] . '</td>
        <td>' . $row2['propertyno'] . '.</td>
        <td>' . $row2['description'] . '</td>
        <td>' . $row2['units'] . '  </td>
        <td>' . $row2['Serial'] . '  </td>
        <td>' . $row2['chasisnumber'] . '  </td>
        <td>' . $row2['amount'] . '  </td>
        <td>' . $row2['yearoflife'] . '  </td>
        <td>' . $row2['ResponsibilityCenter'] . '  </td>
        <td>' . $row2['Status'] . '  </td>'
   ;
  
  echo '</tr>';
  }
  
  
  echo '  </tbody>
  
  </table>';
}
?>