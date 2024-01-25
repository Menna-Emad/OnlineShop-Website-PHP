<?php
$title = "Register";
include_once "layouts/header.php";
include_once "app/middleware/guest.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
include_once "app/requests/Validation.php";
include_once "app/models/User.php";
include_once "app/services/mail.php";


if($_POST){
    //validation rules
    //first_name->reqired,string
    //lastname_name
    //gender->reguired,('f','m')
    //email->required,@ .->regular experession(pattern),unique msh mawgod 3ndy fe el database
    //phone-> required , regular expression(pattern),unique
    //password->required, regular expression, =password_confirmation


    //hnbtdy hena nakhod object mn class validation
    //awl haga el email
    //mehtaga a3mel el validation de nested y3ny mo3tamd 3la ba3do
    
  $emailValidation= new Validation('email',$_POST['email']);//lazm nmrrlo parameter ely hya el value w el name el name hya el email w el value hn7otha fe post 3lshan hnakhodha mn el user f hn7ot el email de fe el post
  $emailRequiredResult= $emailValidation->required();//de btrg3 ya string mlyan ya string fady
  $emailPattern="/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
  //lw fadya yb2a y3ml el pattern tb lw msh fadya msh hyroh ydawr fe el database 3leha
  if(empty($emailRequiredResult)){
    $emailRegexResult= $emailValidation->regex($emailPattern);
    if(empty($emailRegexResult)){
    $emailUniqueResult=$emailValidation->unique('users');//users de esm el table
      
    }
  }
   //ll phone validation
  $phoneValidation= new Validation('phone',$_POST['phone']);//lazm nmrrlo parameter ely hya el value w el name el name hya el email w el value hn7otha fe post 3lshan hnakhodha mn el user f hn7ot el email de fe el post
  $phoneRequiredResult= $phoneValidation->required();//de btrg3 ya string mlyan ya string fady
  $phonePattern="/^01[0-2,5,9]{1}[0-9]{8}$/";
  //lw fadya yb2a y3ml el pattern tb lw msh fadya msh hyroh ydawr fe el database 3leha
  if(empty($phoneRequiredResult)){
    $phoneRegexResult= $phoneValidation->regex($phonePattern);
    if(empty($phoneRegexResult)){
    $phoneUniqueResult=$phoneValidation->unique('users');//users de esm el table
      
    }
  }
      // password validation
  $passwordValidation= new Validation('password',$_POST['password']);//lazm nmrrlo parameter ely hya el value w el name el name hya el email w el value hn7otha fe post 3lshan hnakhodha mn el user f hn7ot el email de fe el post
  $passwordRequiredResult= $passwordValidation->required();//de btrg3 ya string mlyan ya string fady
  $passwordPattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$/";
  //lw fadya y3ny mafesh moshkela feha yb2a y3ml el pattern tb lw msh fadya msh hyroh ydawr fe el database 3leha
  if(empty($passwordRequiredResult)){
    $passwordRegexResult= $passwordValidation->regex($passwordPattern);
    if(empty($passwordRegexResult)){
    $passwordConfirmationResult=$passwordValidation->confirmed($_POST['password_confirmation']);//users de esm el table
      
    }
  }


  if(
  (isset($passwordConfirmationResult)&& $passwordConfirmationResult=='')
  &&(isset($phoneUniqueResult)&& $phoneUniqueResult=='')
  &&(isset($emailUniqueResult)&& $emailUniqueResult=='')
  ){
    //no password validation errors , no email validation errors , no phone validation errors
    //insert user into in db
       //hash password
       //generate code
       //insert user el mas2ol 3n insert user hwa model el user f hakhod mn class el user object
       $userObject = new User;
       //lazm ady ll object da ely hwa $this->first_name masln byanat 3lshan da kda object fady msh shayel haga
       //w el byanat de gyaly fe el super global post
       //$userObject->first_name=$_POST['first_name'] w hakaza bs kda ghalat leh?
       //3lshan el property ely esmo el firstname da ehna hateno private fe class el user f htnlo el setter w el getter 3lshan n2dar n callo makan bara
       //f hnstkhdm el setter bta3o
       $userObject->setFirstname($_POST['first_name']);
       $userObject->setLastname($_POST['last_name']);
       $userObject->setEmail($_POST['email']);
       $userObject->setPhone($_POST['phone']);
       $userObject->setGender($_POST['gender']);
       $userObject->setBirthdate($_POST['birthdate']);
       //bs hnshfro gwa el setter 3lshan ykon fe el method nafso
       $userObject->setPassword($_POST['password']);
       //ha generate code b2a rad de b generate rakm random f ana 3yza 5 digit yb2a el min kam w l max kam
       $code=rand(10000,99999);
       $userObject->setCode($code);
       //hndah b2a 3la method ely btdakhl el user gwa el db ely hya create
       //tb create de kan bt return eh el runDML w el dml btrg3 true aw false
       $result= $userObject->create();
       //lw feh result hy7at fe el db
       if($result){
        //lw fe result ha send mail bl code w hawdeh 3la el saf7a bta3t el check
        //send mail with the code
        //mail to =>$_POST['email']
        // mail from=>ay email
        //mail subject=>verification code
        //mail body=>hello name , your verification code is:  thank u.
        //header to check code page
        $subject ="verification code";
        $body= "hello {$_POST['first_name']} {$_POST['last_name']} <br>your verification code is :<br> $code </br> thank you</br>";
        $mail = new mail($_POST['email'],$subject,$body);
        $mailResult =$mail->send();
        if ($mailResult){
               //header to check code page
               //store email in session 3lshan akhdo awdeh ll check code page
               //aw momkn ab3to fe el url f hn3ml el form bta3 el check code no3ha get msh post 3lshan ab3at feha el email mn gher ma ahot el email fe session
               //msh hn7oto fe el session 3lshan ana msh mehtaga ahot el email fe el session w afdal mashya feh fe kol el sf7at
               $_SESSION['user-email']=$_POST['email'];
               header('location:check-code.php?page=register');die;
        }else{
               $error="<div class='alert alert-danger'> Try Again Laterrr </div>";
        }

       }else{
        $error="<div class='alert alert-danger'> Try Again Later</div>";

       }


       //what's next?
       //how to verify?
       //send mail with code
       //header to check code page 

  }
}





?>

<!-- registeration -->
<section>
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <!-- <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3> -->
                       <!-- lw el error da mawgod etba3o -->
                       <?php if(isset($error)){echo $error;} ?>
                        <form method="post">

                            <div class="row">
                                <div class="col-md-6 mb-4">

                                    <div class="form-outline">
                                    <label class="form-label" for="first_name">First Name</label>
                                        <input name="first_name" type="text"  class="form-control form-control-lg" placeholder="First Name" value="<?php if(isset($_POST['first_name'])){echo $_POST['first_name'];}?>"/>
                                      
                                    </div>

                                </div>
                                <div class="col-md-6 mb-4">

                                    <div class="form-outline">
                                    <label class="form-label" for="last_name">Last Name</label>
                                        <input name="last_name" type="text" class="form-control form-control-lg" placeholder="Last Name" value="<?php if(isset($_POST['last_name'])){echo $_POST['last_name'];}?>" />
                                       
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 d-flex align-items-center">

                                    <div class="form-outline datepicker w-100">
                                    <label for="birthdate" class="form-label">Birthday</label>
                                        <input name=" birthdate" type="text" class="form-control form-control-lg" placeholder="Birthday Date" value="<?php if(isset($_POST['birthdate'])){echo $_POST['birthdate'];}?>"  />
                                       
                                    </div>

                                </div>
                                <div class="col-md-6 mb-4">

                                    <h6 class="mb-2 pb-1">Gender: </h6>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="f" checked <?=(isset($_POST['gender'])&& $_POST['gender']=='f')?'checked': ''?>/>
                                        <label class="form-check-label" >Female</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="m" <?=(isset($_POST['gender'])&& $_POST['gender']=='m')?'checked': ''?> />
                                        <label class="form-check-label" >Male</label>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 pb-2">

                                    <div class="form-outline">
                                    <label class="form-label">Email</label>
                                        <input name="email" type="email"  class="form-control form-control-lg" placeholder="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>" />
                                        <!-- lw fadya yb2a mafesh lw mlyana yb2a fe error-->
                                   <?= empty($emailRequiredResult)? "":"<div class='alert alert-danger'>$emailRequiredResult</div>";?>
                                   <!-- hal fe regular exp res -->
                                   <?= empty($emailRegexResult)? "":"<div class='alert alert-danger'>$emailRegexResult</div>";?>
                                   <?= empty($emailUniqueResult)? "":"<div class='alert alert-danger'>$emailUniqueResult</div>";?>  

                                    </div>

                                </div>
                                <div class="col-md-4 mb-4 pb-2">

                                    <div class="form-outline">
                                    <label class="form-label" for="phone">Phone Number</label>
                                        <input name="phone" type="number" class="form-control form-control-lg" placeholder="Phone Number" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}?>"/>
                                        <?= empty($phoneRequiredResult)? "":"<div class='alert alert-danger'>$phoneRequiredResult</div>";?>
                                   <!-- hal fe regular exp res -->
                                   <?= empty($phoneRegexResult)? "":"<div class='alert alert-danger'>$phoneRegexResult</div>";?>
                                   <?= empty($phoneUniqueResult)? "":"<div class='alert alert-danger'>$phoneUniqueResult</div>";?> 
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">

                                    <div class="col-md-25 mb-4 pb-2">

                                        <div class="form-outline">
                                        <label class="form-label" for="password">Password</label>
                                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                                            <?= empty($passwordRequiredResult)? "":"<div class='alert alert-danger'>$passwordRequiredResult</div>";?>
                                   <!-- hal fe regular exp res -->
                                   <?= empty($passwordRegexResult)? "":"<div class='alert alert-danger'> Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character </div>";?>
                                  
                                        </div>

                                   

                                    <!-- <select class="select form-control-lg">
                                        <option value="1" disabled>Choose option</option>
                                        <option value="2">Subject 1</option>
                                        <option value="3">Subject 2</option>
                                        <option value="4">Subject 3</option>
                                    </select>
                                    <label class="form-label select-label">Choose option</label> -->

                                </div>
                            </div>
                            </div>
                                    <div class="col-md-10 mb-4 pb-2">

                                        <div class="form-outline">
                                        <label class="form-label" for="password">Password_confirmation</label>
                                            <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password" />
                                            <?= empty($passwordConfirmationResult)? "":"<div class='alert alert-danger'>$passwordConfirmationResult</div>";?>
                                        </div>

                                    </div>

                            <div class="button-box mt-5">
                                <button class="btn btn-primary btn-lg" type="submit">register</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of registeration -->

<?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
?>