<?php
$title = "reset password";
include_once "layouts/header.php";
include_once "app/middleware/guest.php";
//lw 3malt logout hynf3 a3mel reset password laa lazm a3mel login
//f lazm a3mel login 3lshan a3ml reset password 
//f lazm reset password ykon 3aref men ely dakhelo
//f hn2lo lw el session fadya mtdkholsh 3la saf7t el reset 
//el session gya fyha key ely shayel el email
if(empty($_SESSION['user-email'])){
   header('location:login.php');die;
}
include_once "app/requests/Validation.php";
include_once "app/models/User.php";


if($_POST){
  //validation
  //password=>required,regex,confirmed
$_errors=[];
  $passwordValidation=new Validation('password',$_POST['password']);
 $passwordRequiredResult=$passwordValidation->required();
 //lw mlyana el mafrod el error yt3rd fe saf7t el login el tanya f hakhzn el errors fe session msh array zy kol mara
 //leh 3lshan el errors de haroh a3rdha fe saf7a tanya
if(empty($passwordRequiredResult)){
     $passwordPattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$/";
     $passwordRegexResult=$passwordValidation->regex($passwordPattern);
     if(empty($passwordRegexResult)){
   $passwordConfirmResult= $passwordValidation->confirmed($_POST['password_confirmation']);
   if(!empty($passwordConfirmResult)){
    $_errors['password']['confirm']=$passwordConfirmResult;
   }
     }else{
      $_errors['password']['regex']=" Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character ";
     }
}else{
  $_errors['password']['required']=$passwordRequiredResult;
}


//password_confirmation=>required
$confirmPasswordValidation=new Validation('confirm password',$_POST['password_confirmation']);
$confirmPasswordRequiredResult=$confirmPasswordValidation->required();
if(!empty($confirmPasswordRequiredResult)){
  $_errors['confirm']['required']=$confirmPasswordRequiredResult;
}
  
  if(empty($_errors)){
//update user password
 //header to login
 $userObject=new user;
 $userObject->setPassword($_POST['password']);
 $userObject->setEmail($_SESSION['user-email']);
 $result=$userObject->updatePasswordByEmail();
 if($result){
  unset($_SESSION['user-email']);
  $success="your password has been successfully updated";
  header('Refresh:3;url=login.php');
 }else{
  $_errors['password']['wrong']="something went wrong";
 }
  
 
}
}

?>

<div class="container py-5 h-100">
  <div class="row justify-content-center align-items-center h-100">
    <div class="col-12 col-lg-9 col-xl-7">
      <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
        <div class="card-body p-4 p-md-5">
               <?php
               if(isset($success)){
                echo "<div class= alert alert-success>$sucess</div>";
               }
               ?>
          <form method="post">
            <div class="form-group">
              <div class="col-md-6 mb-4">

                <label>password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password">
                <?php
                if(!empty($_errors['password'])){
                foreach($_errors['password']as $key=>$value){
                  echo "<div class='alert alert-danger'> $value </div>";
                }
              }
              ?>
  
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 mb-4">
                <label>Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
              <?php
              if(!empty($_errors['confirm'])){
                foreach($_errors['confirm']as $key=>$value){
                  echo "<div class='alert alert-danger'> $value </div>";
                }
              }
              ?>
              </div>
            </div>
            <div class="button-box mt-5">
              <button type="submit" name="login" class="btn btn-primary btn-lg">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- msh hnkhzn byanat el remember me msh fe el session 3lshan el session momkn ttdmr bl unset aw expiration date 
f hnstkhdm cookie da file betrmy fe computer bta3 el mostakhdm y3ny lw afel el browser bardo btfdal feh el data 
lw el cokkie mtdthash expiration date btt2fel bs lazm ahot expiration date w ana ely bt7km ahot feh 
el server w el browser bytklmo m3 b3d bl http request mbnhom -->
<!-- ely b creat el cookie el server w byroh y3mlha save f el browser
w bams7 el cookie mn set cookie bardo badeha value fadya e l date expired y3ny wa2t 3ada-->
























<?php

include_once "layouts/footer-scripts.php";
?>