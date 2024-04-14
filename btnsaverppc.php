<?php

include 'cn.php';

$result = array();

if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
     $_SESSION["uid"]  = 0;
  }
  $uid = $_SESSION["uid"] ;


$sqlres = "SELECT a.ResponsibilityCenter rid ,c.ResponsibilityCenter
,concat(a.fname,' ', substring(a.mname, 1,1),'. ', lname) completename
 FROM u_profile a
left join a_user b on a.profileid = b.profileid and b.isactive = 1 
left join a_responsibilitycenter c on a.ResponsibilityCenter = c.id and c.isactive = 1 
where a.isactive = 1 and b.userid =  $uid ";

$selsource1 = $_GET['selsource'];


$sqlpppp = "SELECT `id` FROM `m_fundcluster` WHERE `Fundcategory` ='$selsource1' and isactive = 1 ";
$qrypppp = mysqli_query($con,$sqlpppp);
$selsource = 0 ;
while($rro = mysqli_fetch_array($qrypppp)){
    $selsource = $rro['id'];
}




$qryres = mysqli_query($con,$sqlres);
$aarres = mysqli_fetch_array($qryres);
$ResponsibilityCenter = $aarres['ResponsibilityCenter'];


$rid = $aarres['rid'];
$dtpReportDate = $_GET['dtpReportDate'];


$sqllssssx ="select * from (SELECT c.`itemid` id, ResponsibilityCenter,`item`,stockno, b.units,  a.`description` ,
`datereport`,sum(`qty`) qty , sum(`shorttage`) shorttage, `Total`, format(sum(`shorttage`) *  `ave`,2) totalave,ave


,case when (SELECT count(id) FROM `a_responsibilitycenter` WHERE `isactive` = 1 
    and `ResponsibilityCenter` != 'Others')  = 
    (select  count(f.itemid)   from  t_tempitemcount f where f.createdBy = $uid and  f.itemid = c.itemid and 
    convert(datereport,date) = convert('$dtpReportDate',date) ) then 
     'Pass'
     else 'Failed'
    end Pass

FROM 
t_tempitemcount c 
left join `m_materials` a on c.`itemid`  = a.id 

left join m_units b on a.`units` = 
     b.id and b.isactive = 1
left join a_responsibilitycenter d on c.`rid` = d.id and d.isactive =1 

where c.`createdBy` = $uid  and datereport = '$dtpReportDate') xs where Pass = 'Failed' ";
//  echo $sqllssssx;

$qrysssdsds = mysqli_query($con,$sqllssssx);

if(mysqli_num_rows($qrysssdsds)  > 0 ){

  echo 1;
}else{

echo 2;
  $sqlsss = "select 
            case when length(cnn) =1 then
            concat('RPCI-',date_format ('".$dtpReportDate."','%m-%Y'),'-0000',cnn)
                when length(cnn) =2 then
                concat('RPCI-',date_format ('".$dtpReportDate."','%m-%Y'),'-000',cnn)
                when length(cnn) =3 then
                concat('RPCI-',date_format ('".$dtpReportDate."','%m-%Y'),'-00',cnn)
                when length(cnn) =4 then
                concat('RPCI-',date_format ('".$dtpReportDate."','%m-%Y'),'-0',cnn)
                else
                concat('RPCI-',date_format ('".$dtpReportDate."','%m-%Y'),'-',cnn)
                end code
                from
                (SELECT count(id) + 1 cnn FROM t_rpciheader ) a ";
        $sssqry = mysqli_query($con,$sqlsss);
        $arrcode =mysqli_fetch_array($sssqry);


        $code = $arrcode['code'];
        $sqlchk = "select id from t_rpciheader where rid =$rid 
        and  convert(reportDate,date) =  convert('$dtpReportDate',date)";
        $qrysqlchk = mysqli_query($con,$sqlchk);
    
        $sqllle ="update  `t_tempitemcount` set `code` ='$code' where convert(`datereport`,date) = 
        convert('$dtpReportDate',date) and `createdBy` = $uid ";
        $qrysqlchk = mysqli_query($con,$sqllle);
            $sqlinsert = "insert into  t_rpciheader 
            (rid, code, reportDate, status, isActive, createdBy, creationDate)
            values
            ($rid,'$code' , '$dtpReportDate', 'For Approval', 1, $uid, now())";
            mysqli_query($con,$sqlinsert);

        $sqlsearch = "SELECT * FROM t_temprpcdetail WHERE resid = $rid and 
        convert(rpcidate,date) = convert('$dtpReportDate',date) and createdBy  = $uid";
            
            $qrysearch = mysqli_query($con,$sqlsearch);
            $sss = "";
            while($row = mysqli_fetch_array($qrysearch)){
                $id = $row['id'];
                  $itemid = $row['itemid'];
                  $resid = $row['resid'];
                  $createdBy = $row['createdBy'];
                  $cost = $row['cost'];
                  $bal = $row['bal'];
                  $onhand = $row['onhand'];
                  $storageqty = $row['storageqty'];
                  $storageVal = $row['storageVal'];
                  $remarks = $row['remarks'];
                $sqlsearIn ="
                insert into  t_rpcidetails 
                (code, itemid, riid, cost, bal, onhand, storageqty, storageVal, remarks, isactive, createdby, creationdate,selsource)
                values('$code', $itemid, $resid , '$cost', '$bal', 
                '$onhand', '$storageqty', '$storageVal', '$remarks', 1, $uid, now(),$selsource)
                
                ";
                mysqli_query($con,$sqlsearIn);
                // $sss = $sss +' | ' + $sqlsearIn;
                $sqldel = "delete  FROM `t_temprpcdetail` WHERE id =$id";
                mysqli_query($con,$sqldel);
            }
       

            $ttempvaldel ="delete from t_tempvaldel where  resid = $rid userid = $uid ";

            mysqli_query($con,$ttempvaldel);

            $ttemprpci = "delete from t_temprpci where  resposibilityid = $rid createdby = $uid ";
            mysqli_query($con,$ttemprpci);
        

        }
?>

