<?php
include_once "app/models/Category.php";
include_once "app/models/Subcategory.php";
include_once "app/models/Cart.php";
include_once "app/models/Product.php";
include_once "app/models/Wishlist.php";

$categoryObject = new Category;
$categoryObject->setStatus(1);
$categoriesResult = $categoryObject->read();

$subcategoryObject = new Subcategory;
$subcategoryObject->setStatus(1);

$cartObject= new Cart;
$numberofproData=$cartObject->getNumofproInCart();

if($numberofproData){
    $numberofpro=$numberofproData->fetch_object();                
}

$wishlistObject=new Wishlist;
$numberofproDataa=$wishlistObject->getNumofproInWishlist();
if($numberofproDataa){
  $numberofproductss=$numberofproDataa->fetch_object();
}



?>
<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <!-- <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div> -->
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <?php
                    //hal el shakhs 3aml login y3ny el session key esmo user
                    if (isset($_SESSION['user'])) {
                    ?>
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown"><?= $_SESSION['user']->first_name . ' ' . $_SESSION['user']->last_name ?></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="profile.php" class="dropdown-item" type="button">Profile</a>
                            <a href="app/post/logout.php" class="dropdown-item" type="button">Logout</a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Welcome</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="login.php" class="dropdown-item" type="button">Login</a>
                            <a href="register.php" class="dropdown-item" type="button">Register</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="btn-group mx-2">
                    <!-- <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button> -->
                    <!-- <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">CAD</button>
                        </div> -->
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- <button class="dropdown-item" type="button">FR</button> -->
                        <button class="dropdown-item" type="button">AR</button>
                        <!-- <button class="dropdown-item" type="button">RU</button> -->
                    </div>
                </div>
            </div>
            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;"></span>
                </a>
                
                
                <a href="cart.php" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;"><?=$numberofpro->NumbOfProductsInCart?></span>
                </a>
                
            
            </div>
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Online</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="shop.php" method="get">
                <div class="input-group">
                    <input type="text" name="name_en" value="<?php if(isset($_GET['name_en'])){echo $_GET['name_en'];}?>"class="form-control" placeholder="Search for products">
                    
                    <div class="input-group-append">
                        <!-- <span class="input-group-text bg-transparent text-primary"> -->
                            <button type="submit" class="btn btn-warning">Search</button>
                        <!-- </span> -->
                    </div>
                </div>
            </form>
        </div>
        <!-- <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Customer Service</p>
                <h5 class="m-0">+012 345 6789</h5>
            </div> -->
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <?php
                    if ($categoriesResult) {
                        $categories = $categoriesResult->fetch_all(MYSQLI_ASSOC);
                        foreach ($categories as $key => $category) {


                    ?>
                            <div class="nav-item dropdown dropright">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?= $category['name_en'] ?><i class="fa fa-angle-right float-right mt-1"></i></a>
                                <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                    <?php
                                    $subcategoryObject->setCategory_id($category['id']);
                                    $subResult = $subcategoryObject->getSubByCats();
                                    if ($subResult) {
                                        $subcategories = $subResult->fetch_all(MYSQLI_ASSOC);

                                        foreach ($subcategories as $index => $subcategory) {
                                    ?>
                                            <a href="shop.php?sub=<?= $subcategory['id'] ?>" class="dropdown-item"><?= $subcategory['name_en'] ?></a>
                                    <?php

                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>

                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Online</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="shop.php" class="nav-item nav-link">Shop</a>

                        <div class="nav-item dropdown">
                            <!-- <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div> -->
                        </div>
                        <!-- <a href="contact.html" class="nav-item nav-link">Contact</a> -->
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="wishlist.php" class="btn px-0">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;"><?=$numberofproductss->NumbOfProductsInWishlist?></span>
                        </a>
                        <a href="cart.php" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;"><?=$numberofpro->NumbOfProductsInCart?></span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->