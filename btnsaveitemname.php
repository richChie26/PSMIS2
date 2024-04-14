<?php
include 'cn.php';

	$result = array();

 	if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;

    $txtitemname = ucwords(strtolower(preg_replace("/'/", "",$_GET['txtitemname'])));
    $seltitle = $_GET['seltitle'];

    $sql = " Select * from (SELECT `id`, `itemname`
    ,(SELECT `typeofasset` FROM `m_accouttitle` f where f.isactive =1 and f.`id` = a.accounttitle  ) tag 
     FROM `m_itemname` a  WHERE a.isactive =1 and  a.itemname = '$txtitemname'  ) k ";


     $sqlll = "SELECT `typeofasset`
      FROM `m_accouttitle` WHERE isactive = 1 and id = $seltitle ";
     $qryll  = mysqli_query($con,$sqlll);
	$qry = mysqli_query($con,$sql);
	if(mysqli_num_rows($qry) > 0 ){
        $arr = mysqli_fetch_array($qry);
        $tag = $arr['tag'];
        $arrll = mysqli_fetch_array($qryll);
        $typeofasset = $arrll['typeofasset'];

        
        if($tag == 1){
                $result[] = array("msg" => "Duplicate Item Name Already Exist!" , "tag" =>"1");
        }elseif(mysqli_num_rows($qry) > 1 ){
                $result[] = array("msg" => "Duplicate Item Name Already Exist!" , "tag" =>"1");
        }elseif($tag == $typeofasset ){
 $result[] = array("msg" => "Duplicate Item Name Already Exist!" , "tag" =>"1");
        }else{


             $result[] = array("msg" => "Success Item Name is Successefully Saved!" , "tag" =>"2");

            $sqlinsert = "insert into  `m_itemname`(`itemname`, `isactive`, `createdby`, `creationdate`,accounttitle)
values
('$txtitemname', 1, $uid , now() ,$seltitle)";
  mysqli_query($con,$sqlinsert);
        }

			
        
	}else{
            $result[] = array("msg" => "Success Item Name is Successefully Saved!" , "tag" =>"2");

            $sqlinsert = "insert into  `m_itemname`(`itemname`, `isactive`, `createdby`, `creationdate`,accounttitle)
values
('$txtitemname', 1, $uid , now() ,$seltitle)";
  mysqli_query($con,$sqlinsert);

    }


echo json_encode($result);
mysqli_close($con);
?>