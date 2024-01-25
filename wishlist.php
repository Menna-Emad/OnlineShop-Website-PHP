<?php
$title = "Wishlist";
include_once "layouts/header.php";
include_once "layouts/nav.php";
include_once "app/middleware/auth.php";
include_once "app/models/Wishlist.php";
include_once "app/models/Product.php";



//wishlist->product_id,product_name,quantity,price,user_id
$wishlistObject = new Wishlist;
$wishlistResult = $wishlistObject->read();

if (isset($_POST['product_id'])) {
    $wishlistRemove = $wishlistObject->Delete();
}


if(isset($_POST['product_addtocart'])){
    $cartObject=new Cart;
    $cartObject->setProduct_id($_POST['product_id']);
    $cartObject->setQuantity($_POST['quantity']);
    $cartObject->setName_en($_POST['product_name']);
   $cartObject->setPrice($_POST['product_price']);
   $cartObject->setImage($_POST['product_image']);
   $cartObject->setUser_id($_SESSION['user']->id);
    $result= $cartObject->create();

    $sucess="<div class='alert alert-success'>your product is added to your cart</div>";

}
?>
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                    
                        <!-- <th>Remove</th> -->
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php
                    if ($wishlistResult) {
                        $wishlistproducts = $wishlistResult->fetch_all(MYSQLI_ASSOC);
                        foreach ($wishlistproducts as $key => $wishlistproduct) {

                    ?>
                            <tr>
                                <td class="align-middle"><img src="img/<?= $wishlistproduct['image'] ?>" alt="" style="width: 50px;"> <?=$wishlistproduct['name_en']?></td>
                                <td class="align-middle"><?= $wishlistproduct['price'] ?> EGP</td>
                                
                                <!-- <td class="align-middle"></td> -->
                                <form method="post">
                                    <input type="hidden" name="product_id"  value="<?= $wishlistproduct['product_id'] ?>">
                                    <td class="align-middle"><button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                    </form>
                                    <form method="post">
                                    <input type="hidden" name="quantity" value="1" min="1" max="<?=$wishlistproduct['quantity']?>" required >
                                    <input type="hidden" name="product_id" value="<?= $wishlistproduct['product_id']?>">
                                    <input type="hidden" name="product_name" value="<?= $wishlistproduct['name_en']?>">
                                    <input type="hidden" name="product_price" value="<?= $wishlistproduct['price']?>">
                                    <input type="hidden" name="product_image" value="<?= $wishlistproduct['image']?>">
                                    <td class="align-middle"><button type="submit" name="product_addtocart" class="btn btn-sm btn-danger"><i class="fas fa-shopping-cart"></i></button></td>
                                    </form>
                            </tr>
                        <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">You have no products added in your Wishlist</td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
       
    </div>
</div>
<?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php"
?>