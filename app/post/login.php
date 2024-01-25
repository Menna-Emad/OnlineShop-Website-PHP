<?php
//lazm had ykon 3aml login 3lshan y2dar ydkhol 3la el saf7a de
//hal gy mn saf7t el login
//hal fe el post gy feh key esmo login
//y3ny lw fe error y3ny msh gy mn el post ely feh key esmo login
session_start();
if(!isset($_POST['login'])){
    header('location:../../layouts/errors/404.php');die;
}//lw el if de mt722tsh kda y3ny gy mn el login
include_once "../requests/Validation.php";
include_once "../models/User.php";
 //validation
  //email=>required ,regex,
 $emailValidation=new Validation('email',$_POST['email']);
 $_SESSION['email-required']=$emailValidation->required();
 //lw mlyana el mafrod el error yt3rd fe saf7t el login el tanya f hakhzn el errors fe session msh array zy kol mara
 //leh 3lshan el errors de haroh a3rdha fe saf7a tanya
if(empty($_SESSION['email-required'])){
     $emailPattern="/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
     $_SESSION['email-regex']=$emailValidation->regex($emailPattern);
}

 //password=>required,regex
 $passwordValidation=new Validation('password',$_POST['password']);
 $_SESSION['password-required']=$passwordValidation->required();
 //lw mlyana el mafrod el error yt3rd fe saf7t el login el tanya f hakhzn el errors fe session msh array zy kol mara
 //leh 3lshan el errors de haroh a3rdha fe saf7a tanya
if(empty($_SESSION['password-required'])){
     $passwordPattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$/";
     $_SESSION['password-regex']=$passwordValidation->regex($passwordPattern);
}


 //if no errors
 if(
    (isset($_SESSION['password-regex']) && $_SESSION['password-regex']=="" ) &&
   (isset($_SESSION['password-required']) && $_SESSION['password-required']=="" ) &&
   (isset($_SESSION['email-required']) && $_SESSION['email-required']=="") && 
   (isset($_SESSION['email-regex'])&& $_SESSION['email-regex']=="")
) {
   //search in db
   $userObject=new User;
   $userObject->setEmail($_POST['email']);
   $userObject->setPassword($_POST['password']);
  $result= $userObject->login(); //ely hyrg3 ya one user||no user
  if($result){
     //lma nt2kd en el validation sah 
 //search in db
 //correct credentionals
 //fetch_all t7awel el result ely rag3a de y2ema tkon array aw object 
 //lw el haga ely rag3alk mn db haga wahda nstkhdm object lakn lw hagat kter btrg3ha array
$user=$result->fetch_object();
if ($user->status==1){
      //home
      //w hwa rayh ll index hyakhod el user m3ah
      //ehna lesa mkhznen el user de fe el session
      //hn7ot el cookie
      //htfdal mawgoda sana
      //w kda ay had rayh 3la el home ba3ml remeber me
      //f lazm ahot condition en lw galk fe el post key esmo remeber me
      if(isset($_POST['remember_me'])){
      setcookie('remember_me',$_POST['email'],time()+(24*60*60)*30*12,'/');
      }
      $_SESSION['user']=$user;
      header('location:../../index.php');die;
}elseif($user->status==0){
        //check code
        //lazm wna ryha el check code bl email ely shylo fe el session msh haroh b edy fadya
        $_SESSION['user-email']=$_POST['email'];
        header('location:../../check-code.php');die;
}else{
        //2 block
        //error
        $_SESSION['block']="sorry ,your account is blocked";
}
 ////status=>1=>home
 //status=>0=>check code page
 //status=>2=>alert with block message

  }else{
    $_SESSION['failed-attempt']="Failed Attempt";
  }

 }

 header('location:../../login.php');


 //wrong email or pass=>display error message