<?php
$title = "product details";
include_once "layouts/header.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
include_once "app/models/Product.php";
include_once "app/models/Cart.php";

if ($_GET) {
    if (isset($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            //check if id exists in your db
            $productObject = new Product;
            $productObject->setId($_GET['id']);
            $productObject->setStatus(1);
            $productData = $productObject->searchOnId();
            if ($productData) {
                $product = $productData->fetch_object();
            } else {
                header('location:layouts/errors/404.php');
                die;
            }
        } else {
            header('location:layouts/errors/404.php');
            die;
        }
    } else {
        header('location:layouts/errors/404.php');
        die;
    }
} else {
    header('location:layouts/errors/404.php');
    die; //all products
}
//productResult=get specific products 
if (isset($_SESSION['user'])) {
    if (isset($_POST['addtocart'])) {
        $cartObject = new Cart;
        $cartObject->setProduct_id($_POST['product_id']);
        $cartObject->setQuantity($_POST['quantity']);
        $cartObject->setName_en($_POST['product_name']);
        $cartObject->setPrice($_POST['product_price']);
        $cartObject->setImage($_POST['product_image']);
        $cartObject->setUser_id($_SESSION['user']->id);
        $result = $cartObject->create();

        $sucess = "<div class='alert alert-success'>your product is added to your cart</div>";
    }
} else {
    $error = "<div class='alert alert-danger'> you can't add to cart unless you aren't login</div>";
}


$productResult = $productObject->read();

if(isset($_SESSION['user'])){
    if(isset($_POST['addtowishlist'])){
    $wishlistObject=new Wishlist;
    $wishlistObject->setProduct_id($_POST['product_id']);
    $wishlistObject->setName_en($_POST['product_name']);
   $wishlistObject->setPrice($_POST['product_price']);
   $wishlistObject->setImage($_POST['product_image']);
   $wishlistObject->setUser_id($_SESSION['user']->id);
    $result= $wishlistObject->create();

    $sucess="<div class='alert alert-success'>your product is added to your wishlist</div>";

}
}else{
 $error="<div class='alert alert-danger'> you can't add to cart unless you aren't login</div>";
}
?>


<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="img/<?= $product->image ?>" alt="Image">
                    </div>

                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3><?= $product->name_en ?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <?php for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $product->reviews_avg) {
                                echo
                                "<small class='fas fa-star'></small>";
                            } else {
                                echo
                                "<small class='far fa-star'></small>";
                            }
                        } ?>
                    </div>
                    <small class="pt-1">(<?= $product->reviews_count ?> Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4"><?= $product->price ?> EGP</h3>
                <p class="mb-4"><?= $product->desc_en ?></p>
                <p class="mb-4"><?= $product->desc_ar ?></p>
                <div class="d-flex mb-3">
                    <!-- <strong class="text-dark mr-3">Sizes:</strong> -->
                    <!-- <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-1" name="size">
                                <label class="custom-control-label" for="size-1">XS</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-2" name="size">
                                <label class="custom-control-label" for="size-2">S</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-3" name="size">
                                <label class="custom-control-label" for="size-3">M</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-4" name="size">
                                <label class="custom-control-label" for="size-4">L</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-5" name="size">
                                <label class="custom-control-label" for="size-5">XL</label>
                            </div>
                        </form> -->
                </div>
                <!-- <div class="d-flex mb-4">
                        <strong class="text-dark mr-3">Colors:</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-1" name="color">
                                <label class="custom-control-label" for="color-1">Black</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-2" name="color">
                                <label class="custom-control-label" for="color-2">White</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-3" name="color">
                                <label class="custom-control-label" for="color-3">Red</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-4" name="color">
                                <label class="custom-control-label" for="color-4">Blue</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-5" name="color">
                                <label class="custom-control-label" for="color-5">Green</label>
                            </div>
                        </form>
                    </div> -->
                <div class="d-flex align-items-center mb-4 pt-2">
                    <form method="post">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            
                            <input type="number" name="quantity" value="1" min="1" max="<?=$product->quantity?>" required class="form-control bg-secondary border-0 text-center" >
                            
                        </div>


                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <input type="hidden" name="product_name" value="<?= $product->name_en ?>">
                        <input type="hidden" name="product_price" value="<?= $product->price ?>">
                        <input type="hidden" name="product_image" value="<?= $product->image ?>">
                        <button type="submit" name="addtocart"class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                            <button type="submit" name="addtowishlist" class="btn btn-primary px-3"><i class="far fa-heart mr-1"></i> Add To
                            Wishlist</button>
                    </form>
                </div>
                <div>
                    <?php
                    if ($product->quantity == 0) {
                        $message = "Out of Stock";
                        $color = "danger";
                    } elseif ($product->quantity >= 1 && $product->quantity <= 5) {
                        $message = "In Stock($product->quantity)";
                        $color = "warning";
                    } else {
                        $message = "In Stock";
                        $color = "success";
                    }
                    ?>
                    <p> Available: <span class="text-<?= $color ?>"><?= $message ?></span></p>

                    <div>
                        <ul>
                            <li>Categories</li>
                            <a href=""><?= $product->category_name_en ?></a>
                            <a href="shop.php?sub=<?= $product->subcategory_id ?>"><?= $product->subcategory_name_en ?></a>
                            <a href=""><?= $product->brand_name_en ?></a>
                        </ul>
                    </div>
                </div>
                <!-- <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div> -->
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3"><?= $product->name_en ?> Description</h4>
                        <p><?= $product->desc_en ?></p>
                        <p><?= $product->desc_ar ?></p>
                    </div>
                    <!-- <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Additional Information</h4>
                            <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul> 
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul> 
                                </div>
                            </div>
                        </div> -->
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $reviewsResult = $productObject->getReviews();
                                if ($reviewsResult) {
                                    $reviews = $reviewsResult->fetch_all(MYSQLI_ASSOC);
                                    foreach ($reviews as $key => $review) { ?>
                                        <h4 class="mb-4"><?= $product->reviews_count ?> review for <?= $product->name_en ?> </h4>
                                        <div class="media mb-4">
                                            <img src="img/<?= $review['image'] ?>" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                            <div class="media-body">
                                                <h6><?= $review['full_name'] ?><small> - <i><?= $review['value'] ?> Stars</i></small></h6>
                                                <div class="text-primary mb-2">
                                                    <?php
                                                    for ($i = 1; $i <= $review['value']; $i++) {
                                                        echo "<small class='fa fa-star text-primary'></small>";
                                                    }
                                                    for ($i = 1; $i <= 5 - $review['value']; $i++) {
                                                        echo  "<small class='far fa-star text-primary'></small>";
                                                    }
                                                    ?>
                                                </div>
                                                <p><?= $review['comment'] ?></p>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<div class='alert alert-warning'>No Reviews Yet</div>";
                                }
                                ?>
                            </div>
                            <!-- <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" class="form-control" id="email">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
    <div class="row px-xl-5">
        <div class="col">
            <figure class="owl-carousel related-carousel">
                <?php
                if ($productResult) {
                    $products = $productResult->fetch_all(MYSQLI_ASSOC);
                    foreach ($products as $index => $product) {

                ?>
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <a href="product-details.php?id=<?= $product['id'] ?>">
                                    <img class="img-fluid w-100" src="img/<?= $product['image'] ?>" alt="">
                                    <div class="product-action">
                                        <form method="post">
                                            <input type="hidden" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" required>
                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                            <input type="hidden" name="product_name" value="<?= $product['name_en'] ?>">
                                            <input type="hidden" name="product_price" value="<?= $product['price'] ?>">
                                            <input type="hidden" name="product_image" value="<?= $product['image'] ?>">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        </form>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>

                                    </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="product-details.php?id=<?= $product['id'] ?>"><?= $product['name_en'] ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5><?= $product['price'] ?></h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i < $product['reviews_avg']) {
                                            echo "<small class='fa fa-star text-primary'></small>";
                                        } else {
                                            echo "<small class='far fa-star text-primary'></small>";
                                        }
                                    }
                                    ?>
                                    <small>(<?= $product['reviews_count'] ?> Reviews)</small>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } ?>
            </figure>
        </div>
    </div>
</div>
<!-- Products End -->




<?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php"
?>