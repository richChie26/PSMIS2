
<?php 
include 'cn.php';
if(!isset($_SESSION['uid']) || (trim($_SESSION['uid']) == '')) {
       $_SESSION["uid"]  = 0;
    }
    $uid = $_SESSION["uid"] ;
       $sql = "SELECT 

(select r.`ResponsibilityCenter` from a_responsibilitycenter r
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

$Completename = "";
 $username = "";
 $pic = "";
 if($uid!= 0 ){
  $arr = mysqli_fetch_array($qry);  
   $Completename = $arr['Completename'];
   $username = $arr['username'];
   $pic = $arr['pic'];
    $Responsibility = $arr['Responsibility'];
 }   
?>

<nav class="navbar navbar-fixed-top " id="richienav">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="img/richielogo.png" width="40" height="40" ></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <?php
          if($uid!= 0 ){
        ?>
        <ul class="nav navbar-nav">
         
                <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" ></span>&nbsp; Setup<span class="caret  "></span></a>
            <ul class="dropdown-menu" id ="mnusetup" >
      
             
            </ul>
          </li>


                <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Transaction <span class="caret"></span></a>
            <ul class="dropdown-menu" id ="mnutransaction">
             
            </ul>
          </li>


          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class=" glyphicon glyphicon-duplicate"></span>&nbsp;Report <span class="caret"></span></a>
            <ul class="dropdown-menu" id="mnureports">
            
            </ul>
          </li>
        </ul>
        <?php 
          }
        ?>
        <!-- <form class="navbar-form navbar-left">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
          </div>
          
        </form> -->
        <ul class="nav navbar-nav navbar-right">
          <?php 

            if($uid == 0 ){
              echo '<li><button type="submit" 
  data-toggle="modal" data-target="#myModal"
               class="btn btn-info">Login</button></li>';
            }else{
          ?>
  <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
              <!-- <img src="img\home32.png"  width="26" height = "28"/> -->
               <?php echo $Responsibility;?> </a>

            
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php
            echo $pic;
            ?>" width="30" height = "30"/> <?php echo $Completename;?> <span class="caret"></span></a>

            <ul class="dropdown-menu">
           
              <li><a href="#" data-toggle="modal" data-target="#myModal1" >Change Password</a></li>
              
              <li role="separator" class="divider"></li>
              <li><a href="logout.php">Log-out</a></li>
            </ul>
          </li>

          <?php 
            }
          ?>
        </ul>
      </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>