<?php
$title = "Home";
include_once "layouts/header.php";
include_once "layouts/nav.php";
include_once "app/models/Product.php";
include_once "app/models/Brand.php";

$categoryObject->setStatus(1);
$categoriesResult = $categoryObject->read();

$productObject = new Product;
$productObject->setStatus(1);
$recentProResults = $productObject->recentpro();
$mostRatedproResults=$productObject->mostrated();

$brandObject=new Brand;
$brandsResults=$brandObject->read();

?>

    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/breadcrumb1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown"></h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn"></p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="shop.php">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/breadcrumb2.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown"></h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn"></p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="shop.php">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/breadcrumb3.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown"></h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn"></p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="shop.php">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/offer-1.png" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="shop.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/offerr-2.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="shop.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
        <div class="row px-xl-5 pb-3">
        <?php
            if ($categoriesResult) {
                $categoriess = $categoriesResult->fetch_all(MYSQLI_ASSOC);
                foreach ($categoriess as $index => $categoryy) {
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="shop.php?cat=<?=$categoryy['id']?>">
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 80px;">
                            <img class="img-fluid" src="img/<?=$categoryy['image']?>" alt="">
                        </div>
                        <div class="flex-fill pl-3">
                            <h6><?=$categoryy['name_en']?></h6>
                            <small class="text-body"></small>
                        </div>
                    </div>
                </a>
            </div>
            <?php }
                ?> 
                 <?php }else{
                echo "<div class='alert alert-warning text-center width 100%'>No Categories yet</div>";
            }
              
        
            ?> 
        </div>
    </div>
    <!-- Categories End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span></h2>
        <div class="row px-xl-5">
        <?php
            if($recentProResults){
                $recentproducts = $recentProResults->fetch_all(MYSQLI_ASSOC);

                foreach ($recentproducts as $index => $recentproduct) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4" >
                    
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/<?=$recentproduct['image']?>" alt="" >
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="product-details.php?id=<?=$recentproduct['id']?>"><?=$recentproduct['name_en']?></a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5><?=$recentproduct['price']?>EGP</h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                        <?php
                                                    for($i=1;$i<=5;$i++){
                                                        if($i<=$recentproduct['value']){
                                                            echo "<small class='fa fa-star text-primary'></small>";
                                                        }else{
                                                            echo "<small class='far fa-star text-primary'></small>";
                                                        }
                                                    }
                                                    ?>
                           
                            <!-- <small>()</small> -->
                        </div>
                    </div>
                </div>
            </div>
            <?php }
                ?>
            <?php }else{
                echo "<div class='alert alert-warning text-center width 100%'>No products yet</div>";
            }
              
        
            ?>
           
        </div>
    </div>
    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="img/offer-1.png" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="shop.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="img/offerr-2.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="shop.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Most Rated Products</span></h2>
        <div class="row px-xl-5">
        <?php
            if($mostRatedproResults){
                $mostRatedproducts = $mostRatedproResults->fetch_all(MYSQLI_ASSOC);

                foreach ($mostRatedproducts as $index => $mostRatedproduct) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/<?=$mostRatedproduct['image']?>" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                           
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="product-details.php?id=<?=$mostRatedproduct['id']?>"><?=$mostRatedproduct['name_en']?></a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5><?=$mostRatedproduct['price']?>EGP</h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                        <?php
                                                    for($i=1;$i<=5;$i++){
                                                        if($i<=$mostRatedproduct['value']){
                                                            echo "<small class='fa fa-star text-primary'></small>";
                                                        }else{
                                                            echo "<small class='far fa-star text-primary'></small>";
                                                        }
                                                    }
                                                    ?>
                           
                            <!-- <small>()</small> -->
                        </div>
                    </div>
                </div>
            </div>
            <?php }
                ?>
            <?php }else{
                echo "<div class='alert alert-warning text-center width 100%'>No products yet</div>";
            }
              
        
            ?>
            
           
        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <?php
                    if($brandsResults){
                        $brandspro=$brandsResults->fetch_all(MYSQLI_ASSOC);
                        foreach($brandspro as $index=> $brandpro){
                    
                    ?>
                    <div class="bg-light p-4">
                        <img src="img/<?=$brandpro['image']?>" alt="">
                    </div>
                  <?php
                        }
                    }
                  ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->


    <?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";

?>


   


