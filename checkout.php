<?php
$title= 'Checkout';
include_once "layouts/header.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
include_once "app/middleware/auth.php";


include_once "app/models/User.php";
include_once "app/models/Cart.php";

$userObject = new user;
$userObject->setEmail($_SESSION['user']->email);


$cartObject = new Cart;
$cartResult = $cartObject->read();
$cartTotal = $cartObject->gettotalPrice();
?>




    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" value="<?=$user->first_name?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" value="<?=$user->last_name?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" value="<?=$user->email?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" value="<?=$user->phone?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="address">
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="custom-select">
                                <option selected>Egypt</option>
                                
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="Cairo">
                        </div>
                        
                        <!-- <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="newaccount">
                                <label class="custom-control-label" for="newaccount">Create an account</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                            </div>
                        </div> -->
                        
                    </div>
                </div>
                <!--  -->
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                
                <div class="bg-light p-30 mb-5">
                   
                    <div class="border-bottom">
                        <h6 class="mb-3">Products</h6>
                        <?php
                    if ($cartResult) {
                        $cartproducts = $cartResult->fetch_all(MYSQLI_ASSOC);
                        foreach ($cartproducts as $key => $cartproduct) {

                    ?>
                        <div class="d-flex justify-content-between">
                            <p><?=$cartproduct['name_en']?></p>
                            <p><?=$cartproduct['price']?> EGP</p>
                        </div>
                        <?php
                }
            }?>
                        
                    </div>
                   
                
            <?php
                    if ($cartTotal) {
                    $cartsubtotals = $cartTotal->fetch_all(MYSQLI_ASSOC);
                    foreach ($cartsubtotals as $key => $cartsubtotal) {

                ?>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6><?= $cartsubtotal['subtotal'] ?> EGP</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">50 EGP</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <?php $carttotal=$cartsubtotal['subtotal'] +50; ?>
                            <h5><?=$carttotal?> EGP</h5>
                        </div>
                    </div>
                </div>
                <?php
                }
            }?>
                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                    <div class="bg-light p-30">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                <label class="custom-control-label" for="directcheck">Direct Check</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Checkout End -->

<?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
?>
   