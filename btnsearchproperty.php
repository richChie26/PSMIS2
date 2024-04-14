<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
    $mnuasset = $_GET['mnuasset'];
    $txtsearchproperty =$_GET['txtsearchproperty'];

    $mnuasset = $_GET['mnuasset'];


    $tag = 0;
    
    if($mnuasset == 2){
      $tag = 2;
    }else if($mnuasset = 3){
      $tag= 0 ;
    }
    $sql = "SELECT 
(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat(`lname`, ', ', `fname`,' ', substring(`mname`,1,1),'.') Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 

where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    $Responsibility = $arr['Responsibility'];
$sqlppe = "
select * from ( SELECT a.id, d.accounttitle,item,yearoflife, b.typeofasset,convert(dateaquired,date) dateaquired,
concat(item, ', ',`description`,', ', `Serial`,', ', `chasisnumber`) description, `propertyno` 
,(SELECT  cname FROM t_pardetails tp left join `t_par` ji on ji.`PARNO` = tp.parno and ji.tag = $tag
 left join 
 (SELECT `userid`, `username` ,concat(`fname`, ' ' , substring(`mname`,1,1),'. ', `lname`) cname FROM `a_user` ki left join u_profile up on ki.`profileid` = up.profileid and up.isactive = 1 where ki.isactive = 1 ) fg on ji.`receivedby` = fg.userid 
where tp.propertyno = a.propertyno and ji.tag = $tag  order by tp.id desc limit 1
) Receivername,
(SELECT  ji.Dateissue FROM t_pardetails tp left join `t_par` ji on ji.`PARNO` = tp.parno  and tp.tag = $tag left join (SELECT `userid`, `username` ,concat(`fname`, ' ' , substring(`mname`,1,1),'. ', `lname`) cname FROM `a_user` ki left join u_profile up on ki.`profileid` = up.profileid and up.isactive = 1 where ki.isactive = 1 ) fg on ji.`receivedby` = fg.userid 
where tp.propertyno = a.propertyno and ji.tag = $tag order by tp.id desc limit 1
)dateissued,

(SELECT  tp.parno FROM t_pardetails tp left join `t_par` ji on ji.`PARNO` = tp.parno left join (SELECT `userid`, `username` ,concat(`fname`, ' ' , substring(`mname`,1,1),'. ', `lname`) cname FROM `a_user` ki left join u_profile up on ki.`profileid` = up.profileid and up.isactive = 1 where ki.isactive = 1 ) fg on ji.`receivedby` = fg.userid 
where tp.propertyno = a.propertyno and ji.tag = $tag order by tp.id desc limit 1
) parno 
FROM `t_equipmentdeliverydetails` a 
left join  m_accouttitle d on a.accounttitle = d.id and d.isactive = 1 
left join 
(SELECT x.id , y.`accounttitle`, `item`,`yearoflife`,y.typeofasset FROM `m_equipent` x left join m_accouttitle y on x.`accounttitle` = y.id and y.isactive = 1 where y.typeofasset = $mnuasset and x.isactive =1 ) b on a.`itemid` = b.id 
where a.isactive = 1 and `ResponsibilityCenter` = $Responsibility and ifnull(a.`Status`,'') = 'Issued'
and b.typeofasset = $mnuasset ) newtable 
where Receivername like '%$txtsearchproperty%'



"; 
// echo $sqlppe;
$qrypee = mysqli_query($con,$sqlppe);
while($row = mysqli_fetch_array($qrypee)){
  echo '<tr class= "itemrowppechie" id="'.$row['id'].'|'.$row['propertyno'].'|'.$row['item'].'|'.$row['description'].'|'.$row['yearoflife'] .'|'.$row['accounttitle'] .'|'.$row['Receivername'] .'|'.$row['dateissued'] .'|'.$row['parno'].'|'.$row['typeofasset'] .'" >
  <td>'.$row['dateaquired'].'</td>
  <td>'.$row['propertyno'].'</td>
  <td>'.$row['item'].'</td>
  <td>'.$row['description'].'</td>
 <td>'.$row['Receivername'].'</td>
</tr>';

}