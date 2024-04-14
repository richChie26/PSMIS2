<?php
  include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

$val = $_GET['val'];

$sqlres = "SELECT a.`ResponsibilityCenter` rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename,a.Position
 FROM `u_profile` a
left join a_user b on a.`profileid` = b.`profileid` and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";


    $qryres = mysqli_query($con,$sqlres);
    $aarres = mysqli_fetch_array($qryres);
    $ResponsibilityCenter = $aarres['ResponsibilityCenter'];
    $positon = $aarres['Position'];
    $completename  = $aarres['completename'];
    $rid = $aarres['rid'];
?>

			<?php 

$sqlirrup = "SELECT a.id, concat(d.item ,' ', c.description) Particular, c.ResponsibilityCenter,format(amount,2) amount, 
substring(c.dateaquired,1,10) dateaquired,PARNO,a.propertyno FROM `t_returndetails` a
left join t_returns b on a.rcode = b.rcode and b.isactive =1 
left join t_equipmentdeliverydetails c on a.propertyno = c.propertyno and c.isactive = 1 
left join m_equipent d on c.itemid = d.id and d.isactive = 1 
left join t_iirupdetails e on  a.`propertyno` = e.propertyno and e.isactive =1 
where `condition` in ('Unserviceable','for Disposal','Disposed')
and ifnull(e.propertyno,'') = '' and c.ResponsibilityCenter = $rid ";
$qryirrup = mysqli_query($con,$sqlirrup);

if(mysqli_num_rows($qryirrup) > 0 ){

$sqlcode = "select case when length( cn) =1 then 
concat('IIRUP-000',cn)
 when length( cn) =2 then 
concat('IIRUP-00',cn)
 when length( cn) =3 then 
concat('IIRUP-0',cn)
else 
concat('IIRUP-',cn)
end IIRUPno


from 

(SELECT (count(id) + 1) cn  FROM `t_iirupheader` ) a ";


      $qrycode = mysqli_query($con,$sqlcode);
      $arrcode = mysqli_fetch_array($qrycode);
      $IIRUPno = $arrcode['IIRUPno'];
      $sqlinsert = "insert into  `t_iirupheader` (`irrupno`)values('$IIRUPno')";
      mysqli_query($con,$sqlinsert);
        // while ($row = mysqli_fetch_array($qryirrup)) {

      // $propertyno = $row['propertyno'];
      foreach ($val as $chie ){

      $sqlirrupdetails = "insert into  `t_iirupdetails` (`iirupno`, `propertyno`, `isactive`, `createdby`, `creationdate`)
     select    '$IIRUPno', propertyno, 1, $uid, now() from  t_returndetails where id = $chie";

      mysqli_query($con,$sqlirrupdetails );
      }
// }
}


?>

