<?php
$title="forget password";
include_once "layouts/header.php";
include_once "app/middleware/guest.php";
include_once "app/models/User.php";
include_once "app/requests/Validation.php";
include_once "app/services/mail.php";


if($_POST){
 //validation
  //email=>required ,regex,
  $errors=[];
 $emailValidation=new Validation('email',$_POST['email']);
$emailRequiredResult=$emailValidation->required();
 //lw mlyana el mafrod el error yt3rd fe saf7t el login el tanya f hakhzn el errors fe session msh array zy kol mara
 //leh 3lshan el errors de haroh a3rdha fe saf7a tanya
if(empty($emailRequiredResult)){
     $emailPattern="/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
     $emailRegExResult=$emailValidation->regex($emailPattern);
     if(!empty( $emailRegExResult)){
      $errors['email-regex']= $emailRegExResul;
     }
}else{
  $errors['email-required']=$emailRequiredResult;
}
   //search on email in db
   if(empty($errors)){
    $userObject=new user;
    $userObject->setEmail($_POST['email']);
    $result=$userObject->getUserByEmail();
   if($result){
    //correct email
    $user=$result->fetch_object();//user variable has all user data in db
    //if exists=>generate code,save code in db,send code,header check-code.php
    $code=rand(10000,99999);
    $userObject->setCode($code);
   $updateResult= $userObject->updateCodeByEmail();
   if($updateResult){
        //save code
        //send code
        // header check-code.php
        $subject ="forget password code";
        $body= "hello {$_POST['first_name']} {$_POST['last_name']} <br>your forget password code is :<br> $code <br> thank you";
        $mail = new mail($_POST['email'],$subject,$body);
        $mailResult =$mail->send();
        if ($mailResult){
               //header to check code page
               //store email in session 3lshan akhdo awdeh ll check code page
               //aw momkn ab3to fe el url f hn3ml el form bta3 el check code no3ha get msh post 3lshan ab3at feha el email mn gher ma ahot el email fe session
               //msh hn7oto fe el session 3lshan ana msh mehtaga ahot el email fe el session w afdal mashya feh fe kol el sf7at
               $_SESSION['user-email']=$_POST['email'];
               header('location:check-code.php?page=forget');die;
        }else{
               $errors['try-again']="Try Again Later";
        }
   }else{
    $errors['some-wrong']="something went wrong";
   }
   }else{
    //wrong email
     //if not exist=>error(this doesn't match our records) 
     $errors['email-wrong']="this doesn't match our records";
   }
   }
  
  
}
?>


<form method="post">
  <div class="form-group">
    <input type="email" name="email" class="form-control" placeholder="Enter your email address">
    <?php
    // hal el erors mlyana
    if(!empty($errors)){
        foreach($errors as $key =>$value){
            echo "<div class='alert alert-danger'>$value </div>";
        }
    }
    ?>
  </div>
  <div class="button-box mt-5">
  <button class="btn btn-primary btn-lg" type="submit">Verify email address</button>
  </div>
</form>


























<?php 

include_once "layouts/footer-scripts.php";