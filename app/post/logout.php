<?php

session_start();
unset($_SESSION['user']);
//lw fe cookie esmha remember me ems7ha
if(isset($_COOKIE['remember_me'])){
setcookie('remember_me','',time()-100,'/');
}
header('loacation:../../login.php');