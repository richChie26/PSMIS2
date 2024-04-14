<?php
include 'cn.php';

  $result = array();

  if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
  $id = $_GET['id'];

    $sql = "SELECT
               userid, up.`profileid`,ifnull(au.username,'') username,

                concat(lname,' ',`fname`,' ', substring(`mname`,1,1),'.') Completename , `contactNo`
                ,`address`

                FROM `u_profile` up 
                left join a_user au on up.`profileid` = au.profileid and au.isactive = 1 
                where up.isactive = 1  and userid = $id";


    $qry = mysqli_query($con,$sql);
    $arr = mysqli_fetch_array($qry);
   
    $username = $arr['username'];
    $Completename = $arr['Completename'];

  ?>

  <form action="#" method="post" id="frmMenu">
       
   <div id="myalert"><div class="alert alert-info" >  <strong>Edit Mode!</strong> Please fill-up the form correctly!  .</div></div>

       <div class="row">
        <div class="col-xs-4">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="User Name" id="username" name= "username" value="<?php echo $username; ?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group has-feedback">
         <input type="hidden" id="hiddenid" value="<?php echo $id; ?>">
            
          </div>
        </div>
<div class="col-xs-4">
          
        </div>
        
  </div> 
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Completename" id="completenameedit" name="completenameedit" value="<?php echo $Completename; ?>" required="true" readonly="true">
        <span class="glyphicon glyphicon-th-list form-control-feedback"></span>
      </div>
     
     
      <div class="row">
        
   
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin:5px;" id="btnaccountedit">Update</button><br/>
        </div>
       
      </div>
    </form><div id="mnudetails"></div>