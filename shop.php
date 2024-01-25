<?php
$title = "Store";
include_once "layouts/header.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
include_once "app/models/Product.php";
include_once "app/models/Subcategory.php";
include_once "app/models/Cart.php";
include_once "app/models/Wishlist.php";

$productObject = new Product;
$productObject->setStatus(1);


//if we have products acc to url y3ny query string
if ($_GET) {
    if (isset($_GET['sub'])) {
        if (is_numeric($_GET['sub'])) {
            //check if id exists in your db
            $subcategoryObject->setId($_GET['sub']);
            $subcategoriesData = $subcategoryObject->searchOnId();
            if ($subcategoriesData) {
                $productObject->setSubcategory_id($_GET['sub']);
                $productResult = $productObject->getProdBySub();
            } else {
                header('location:layouts/errors/404.php');
            }
        } else {
            header('location:layouts/errors/404.php');
        }
       }elseif(isset($_GET['name_en'])){
        $searchproData=$productObject->searchby(); 
        if($searchproData){
            $productObject->setName_en($_GET['name_en']);
            $productResult=$productObject->getprobySearch();
        }else{
         $error="<div class='alert alert-danger'>NO Results</div>";
        }
     

        }elseif(isset($_GET['cat'])){
        if (is_numeric($_GET['cat'])) {
            //check if id exists in your db
            $categoryObject->setId($_GET['cat']);
            $categoriesData = $categoryObject->searchOnId();
            if ($categoriesData) {
                $productObject->setCategory_id($_GET['cat']);
                $productResult = $productObject->getProdByCat();
            } else {
                header('location:layouts/errors/404.php');
            }
        } else {
            header('location:layouts/errors/404.php');
        }
        
    }elseif(isset($_GET['sortby'])){
         if($_GET['sortby']== 'latest'){    
            $productResult=$productObject->sortbyRecent();

         }elseif($_GET['sortby']=='rating'){
            $productResult=$productObject->sortbyrating();
         }else{
            header('location:layouts/errors/404.php');
         }
    }else{
        header('location:layouts/errors/404.php');
    }
    //productResult=get specific products 
} else {
    $productResult = $productObject->read(); //all products
}


$categoryObject = new Category;
$categoryObject->setStatus(1);
$categoriesResult = $categoryObject->read();

$subcategoryObject = new Subcategory;
$subcategoryObject->setStatus(1);

if(isset($_SESSION['user'])){
    if($_POST){
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
}else{
 $error="<div class='alert alert-danger'> you can't add to cart unless you aren't login</div>";
}

if(isset($_SESSION['user'])){
    if(isset($_POST['add_to_wishlist'])){
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

$per_page_record = 15;  // Number of entries to show in a page.   
// Look for a GET variable page if not found default is 1.  
 

   
    if (isset($_GET['page'])) {    
        $Page  = $_GET['page'];    
    }    
    else {    
      $Page=1;    
    }  
    

?>

   

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by category</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <?php
                         $numofproresult=$productObject->numOfProByCat();
                         if ($numofproresult) {
                            $productnumbers = $numofproresult->fetch_all(MYSQLI_ASSOC);
                            foreach($productnumbers as $key =>$productnumber){
                        ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input"  id="price-all">
                            <label class="custom-control-label" for="price-all"><?= $productnumber['category_name'] ?></label>
                            <span class="badge border font-weight-normal"><?=$productnumber['NumbOfProducts']?></span>
                        </div>
                      <?php
                      }
                    }?> 
                    </form>
                </div>
                <!-- Price End -->
                
                <!-- Color Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Brands</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <?php
                        $numofproresult=$productObject->numOfProByBrand();
                        if ($numofproresult) {
                           $productnumbers = $numofproresult->fetch_all(MYSQLI_ASSOC);
                           foreach($productnumbers as $key =>$productnumber){
                        ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input"  id="color-all">
                            <label class="custom-control-label" for="price-all"><?= $productnumber['brand_name'] ?></label>
                            <span class="badge border font-weight-normal"><?=$productnumber['NumbOfBrands']?></span>
                        </div>
                      <?php
                      }
                      }?> 
                    </form>
                </div>
                <!-- Color End -->

               
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <!-- <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div> -->
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                    
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="shop.php?sortby=latest"  class="dropdown-item">Latest</a>
                                        <a href="shop.php?sortby=rating" class="dropdown-item" >Best Rating</a>
                                    </div>
                                    
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <?php
                     if ($productResult) {
                        $products = $productResult->fetch_all(MYSQLI_ASSOC);
                        foreach ($products as $index => $product) {

                     ?> 
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/<?= $product['image'] ?>" alt="">
                                <div class="product-action">
                                    <!-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a> -->
                                    <form  method="post">
                                    <input type="hidden" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" required >
                                              <input type="hidden" name="product_id" value="<?= $product['id']?>">
                                              <input type="hidden" name="product_name" value="<?= $product['name_en']?>">
                                              <input type="hidden" name="product_price" value="<?= $product['price']?>">
                                               <input type="hidden" name="product_image" value="<?= $product['image']?>">
                                               <button type="submit" class="btn btn-outline-dark btn-square"><i class="fa fa-shopping-cart"></i></button>
                                    </form>
                                    <form method="post">
                                    <input type="hidden" name="product_id" value="<?= $product['id']?>">
                                    <input type="hidden" name="product_name" value="<?= $product['name_en']?>">
                                    <input type="hidden" name="product_price" value="<?= $product['price']?>">
                                    <input type="hidden" name="product_image" value="<?= $product['image']?>">
                                    <button type="submit" name="add_to_wishlist" class="btn btn-outline-dark btn-square" ><i class="far fa-heart"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="product-details.php?id=<?=$product['id']?>"><?= $product['name_en'] ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5><?= $product['price'] ?></h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                <?php
                                                    for($i=1;$i<=5;$i++){
                                                        if($i<=$product['reviews_avg']){
                                                            echo 
                                                            "<small class='fas fa-star'></small>";
                                }else{
                                    echo 
                            "<small class='far fa-star'></small>";
                            }
                        }
                            ?>
                                    <small>(<?=$product['reviews_count']?> Reviews)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                         }
                      }else{ echo $error="<div class='alert alert-warning'>NO Search Results</div>";}?> 
                    <div class="col-12">
                             
                        <nav> 
                          <ul class="pagination justify-content-center">
                            
                          <?php
                         
                            $productpagination= $productObject->pagination();
                            $productspag=$productpagination;
                            $total_records=mysqli_fetch_array($productspag)[0];
                            echo "</br>"; 
                            $total_pages = ceil($total_records / $per_page_record);     
                            $firstPage = 1;
                            $nextPage=$Page+1;
                            $previousPage=$Page-1;
                          
                           if($Page != $firstPage) { ?>
		<li class="page-item">
		  <a class="page-link" href="shop.php?page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
			<span aria-hidden="true">First</span>			
		  </a>
		</li>
		<?php } ?>
		<?php if($Page >= 2) { ?>
			<li class="page-item"><a class="page-link" href="shop.php?page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
		<?php } ?>
		<li class="page-item active"><a class="page-link" href="shop.php?page=<?php echo $Page ?>"><?php echo $Page ?></a></li>
		<?php if($Page != $total_pages) { ?>
			<li class="page-item"><a class="page-link" href="shop.php?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
			<li class="page-item">
			  <a class="page-link" href="shop.php?page=<?php echo $total_pages ?>" aria-label="Next">
				<span aria-hidden="true">Last</span>
			  </a>
			</li>
		<?php } ?>
                          </ul>
                        
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->


    <?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
?>