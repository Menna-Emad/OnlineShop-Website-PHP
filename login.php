<?php
$title = "Login";
include_once "layouts/header.php";
include_once "app/middleware/guest.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
?>

<div class="container py-5 h-100">
  <div class="row justify-content-center align-items-center h-100">
    <div class="col-12 col-lg-9 col-xl-7">
      <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
        <div class="card-body p-4 p-md-5">

          <form action='app/post/login.php' method="post">
            <div class="form-group">
              <div class="col-md-6 mb-4">

                <label>Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email">
                <?php
                if (!empty($_SESSION['email-required'])) {
                  echo $_SESSION['email-required'];
                }
                if (!empty($_SESSION['email-regex'])) {
                  echo $_SESSION['email-regex'];
                }
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 mb-4">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
                <?php
                if (!empty($_SESSION['password-required'])) {
                  echo $_SESSION['password-required'];
                }
                if (!empty($_SESSION['password-regex'])) {
                  echo $_SESSION['password-regex'];
                }
                ?>
              </div>
            </div>

            <div class="button-box">
              <div class="login-toggle-btn">
                <input type="checkbox" name="remember_me">
                <label>Remember me</label>

                <a href="forget-password.php">Forget Password?</a>
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
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
unset($_SESSION['email-required']);
unset($_SESSION['email-regex']);
unset($_SESSION['password-required']);
unset($_SESSION['password-regex']);
?>