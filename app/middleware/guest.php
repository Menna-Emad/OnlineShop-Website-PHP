<?php
//allow guest and prevent auth users

if(isset($_SESSION['user'])){
  header('location:index.php');die;
}