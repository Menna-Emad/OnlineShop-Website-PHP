<?php
$title = "check code";
include_once "layouts/header.php";
include_once "app/middleware/guest.php";
include_once "app/models/User.php";

$availablePages=['register','forget'];
//if url has query string
if($_GET){
    if(isset($_GET['page'])){
      //el haga ely batdawr 3leha fe el array
      if(!in_array($_GET['page'],$availablePages)){
        header('location:layouts/errors/404.php');die;
      }

    }else{
      header('location:layouts/errors/404.php');die;
    }
}else{
  header('location:layouts/errors/404.php');die;
}

//hbtdy akarn el code ely user katbo bl code ely mawgod bl database
//mehtag a3rf el shakhs ely mdkhl el code da meen f lazm a3rf ya el email aw el phone
//3lshan el check code mt3rfsh ana meen
if ($_POST) {
  //code=>post
  //email=>session
  //validation
  //code=>required, integer,digits:5,
  //lw el code msh fady y3ny mlyan mafesh error
  //lw fady yb2a feh error
  $errors = [];
  if (empty($_POST['code'])) {
    $errors['required'] = "<div class='alert alert-danger'> code is required </div>";
    //tyb hwa lw mafesh error y3ny mlyan roh shofholy 5 digits wla laa
  } else {
    //en el code length =5
    if (strlen($_POST['code'])!= 5) {
      $errors['digits'] = "<div class='alert alert-danger'> code must be 5 digits </div>";
    }
  }

  //hadwr 3la el code da fe el db lma ykon el errors fadya lw fadya roh dawr 3la el code fe el db
  //tyb meen el table el mas2ol 3n eno yklm el db hwa el model user
  if (empty($errors)) {
    //akhdt object mn el user w ndaht 3la method setcode w hatet feh el code ely gayely mn el post
    $userobject = new User;
    $userobject->setCode($_POST['code']);
    $userobject->setEmail($_SESSION['user-email']);
    //el result ely htrg3 de mlyana aw fadya 3lshan method el check code da ht rundql y3ny select
    $result = $userobject->checkCode();
    if ($result) {
      //correct code
      $userobject->setStatus(1); //mtdynlo 1 asln ely hya halto verified
      //3lshan ana m3rfsh ely dakhl da dakhl b anhy time zone f hwa7d el timezone ely hwa africa
      date_default_timezone_set('Africa/Cairo');
      $userobject->setEmail_verified_at(date('Y-m-d H:i:s'));
      //update 2 colums el status b 1 y3ny verified w el verified at y3ml el date
      //tyb 3yza a3ml update ll email bs ely mtkhzn bl session ely dakhl byh msh el column kolo aw el users kolohm
      $updateResult = $userobject->makeUserVerified();
      if ($updateResult){
        //header
        //3lshan m7tfzsh bl session f adelo el key
        if ($_GET['page'] == 'register') {
          unset($_SESSION['user-email']);
          header('location:login.php');
          die;
        } elseif ($_GET['page'] == 'forget') {
          header('location:reset-password.php');
          die;
        }
      } else {
        $errors['something'] = "<div class='alert alert-danger'> something went wrong</div>";
      }
    } else {
      //wrong code
      $errors['wrong'] = "<div class='alert alert-danger'> wrong code </div>";
    }
  }
}
?>
<div class="container py-5 h-100">
  <div class="row justify-content-center align-items-center h-100">
    <div class="col-12 col-lg-9 col-xl-7">
      <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
        <div class="card-body p-4 p-md-5">
        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5"><?=$title?></h3>
          <form method="post">
            <div class="form-group">
              <div class="col-md-6 mb-4">
                <input type="number" min="10000" max="99999" name="code" class="form-control" placeholder="Enter your verficication code">
                <?php
                // hal el erors mlyana
                if (!empty($errors)) {
                  foreach ($errors as $key => $value) {
                    echo $value;
                  }
                }
                ?>
              </div>
            </div>
            <div class="button-box mt-5">
              <button class="btn btn-primary btn-lg" type="submit"><?= $title ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



























<?php

include_once "layouts/footer-scripts.php";
