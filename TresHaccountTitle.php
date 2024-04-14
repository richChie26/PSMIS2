

<head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>

<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;


    $sql = "SELECT 

(select r.`id` from a_responsibilitycenter r
where r.isactive = 1 and r.id =  up.ResponsibilityCenter) Responsibility,
`userid`,
`username`,
concat( `fname`,' ', substring(`mname`,1,1),'. ' , `lname`) Completename ,
`contactNo` ,
case when ifnull(`userpic`,'') = '' then 'img/userpic.png' else userpic end pic

FROM `a_user` au 
left join u_profile up on au.`profileid` = up.profileid and up.isactive = 1 
where au.isactive = 1 and `userid` = $uid ";
     $qry = mysqli_query($con,$sql);
  $arr = mysqli_fetch_array($qry);  

    $Responsibility = $arr['Responsibility'];
 

    $sql = 'SELECT a.id, b.typeofassets,a.typeofasset ta ,`accounttitle` ,`Acronyms`, `AccAUCScode`, `SubMajorAccountGroup`, `GLAccount`,   `Activation` FROM `m_accouttitle` a 
    left join m_assets b on a.`typeofasset` = b.id and b.isactive = 1 
    where a.isactive =1   and a.typeofasset  =3 
    order by b.typeofassets,accounttitle ASC
        ';
    $qry = mysqli_query($con,$sql);

    echo '<div class="row">
    <div class="col-xs-12">
      <div>
        <table   id="example" class="table table-striped">
          <thead style="background-color: #337ab7;color:white;">
           <tr>

      

               <th>Type of Asset</th>
               <th>Account Title</th>
              <th>Acronyms</th>
              <th>Account UACS Code</th>
              <th>Sub-Major Account Group</th>
              <th>GL Account</th>
              <th>Activation</th>
              
           </tr>
         </thead>
           <tbody id="">';
        while($row = mysqli_fetch_array($qry)){
        
               $activate = $row['Activation'];
                $img = "";
               if($activate == 1 ){
                $img = '<span class="glyphicon glyphicon-ok" style="color:#76ff03;"></span>';
               }else{
                  $img = '<span class="glyphicon glyphicon-remove" style="color:#ef5350;"></span>';
               }
    
          echo ' <tr class="clsAcct"> <td>'. $row['typeofassets'].'</td>
    
              <td>'. $row['accounttitle'].'</td>
              <td>'. $row['Acronyms'].'</td>
              <td>'. $row['AccAUCScode'].'</td>
              <td>'. $row['SubMajorAccountGroup'].'</td>
                <td>'. $row['GLAccount'].'</td>
                 <td>'. $img .'</td>
     
 
                    </tr>';
    
    
        }
 
 echo '</tbody>
    </table>
</div>
</div>
</div>';
?>

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>