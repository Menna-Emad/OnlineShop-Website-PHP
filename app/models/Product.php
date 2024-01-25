<?php
include_once __DIR__ . '\..\database\config.php';
//3add el models ely 3ndy y2daro y3mlo kam no3 operation fe el table bt3hom
//insert update delete select
//lakn el 4 operations btkhtlf mn class l class 3la hasb el table lw kan user aw product f hn3ml interface  feha 4 operation w el interface de bykon feha abstraction
//abstract methods without body ba3rf el prototype lakn m3rfsh el implementation htem ezay
include_once __DIR__ . '\..\database\operations.php';
class Product extends config implements operations
{

   private $id;
   private $name_en;
   private $name_ar;
   private $price;
   private $code;
   private $desc_en;
   private $desc_ar;
   private $quantity;
   private $status;
   private $subcategory_id;
   private $brand_id;
   private $category_id;
   private $image;
   private $created_at;
   private $updated_at;



   public function create()
   {
   }
   public function read()

   {
      $per_page_record = 15;  // Number of entries to show in a page.   
// Look for a GET variable page if not found default is 1.        
$Page=isset($_GET['page'])?(int)$_GET['page']:1;
$Page=$Page<1?1:$Page;
    
//determine the sql LIMIT starting number for the results on the displaying page  
 $start_from = ($Page-1) * $per_page_record; 
      $query = "SELECT * FROM `product_details` WHERE `status`=1 ORDER BY `name_en` LIMIT $start_from, $per_page_record ";
      return $this->runDQL($query);
   }

   public function pagination(){
      $query="SELECT COUNT(*) FROM product_details";
      return $this->runDQL($query);
   }
   public function update()
   {
   }
   public function delete()
   {
   }

   public function getProdBySub()
   {
      $query = "SELECT * FROM product_details WHERE subcategory_id=$this->subcategory_id
      AND status=$this->status ORDER BY price ASC , quantity DESC , name_en ASC";
      return $this->runDQL($query);
   }
   public function getProdByCat()
   {
      $query = "SELECT * FROM product_details WHERE category_id=$this->category_id
      AND status=$this->status ORDER BY price ASC , quantity DESC , name_en ASC";
      return $this->runDQL($query);
   }

   public function searchOnId()
   {
      $query = "SELECT * FROM product_details WHERE id=$this->id";
      return $this->runDQL($query);
   }

   public function getReviews()
   {
      $query = "SELECT
                review.* ,
                CONCAT(users.first_name ,' ',users.last_name) AS full_name ,
                users.image
                FROM review
                JOIN users
                ON users.id=review.user_id
                WHERE 
                review.product_id=$this->id";
      return $this->runDQL($query);
   }

   public function recentpro()
   {
      $query = "SELECT * FROM products LEFT JOIN review ON products.id=review.product_id ORDER BY products.created_at DESC LIMIT 4";
      return  $this->runDQL($query);
   }

   public function mostrated()
   {
      $query="SELECT * FROM `products` JOIN review ON products.id=review.product_id WHERE review.value>=3";
      return $this->runDQL($query);
   }

   public function sortbyRecent()
   {
      $query = "SELECT * FROM product_details ORDER BY product_details.created_at DESC";
      return  $this->runDQL($query);
   }
   public function sortbyrating()
   {
      $query="SELECT * FROM `product_details` JOIN review ON product_details.id=review.product_id WHERE review.value>=3";
      return $this->runDQL($query);
   }
   

   public function numOfProByCat()
   {
      $query = "SELECT categories.name_en AS category_name,
      COUNT(products.id) AS NumbOfProducts
      FROM products
      RIGHT JOIN categories
      ON categories.id=products.category_id
      GROUP BY categories.name_en;";
      return $this->runDQL($query);
   }

   public function numOfProByBrand()
   {
      $query = " SELECT brands.name_en AS brand_name,
      COUNT(products.brand_id) AS NumbOfBrands
      FROM products
      LEFT JOIN brands
      ON products.brand_id=brands.id
      GROUP BY brands.name_en";
      return $this->runDQL($query);
   }

   public function searchby()
   {
      $query="SELECT * FROM product_details WHERE CONCAT(name_en,brand_name_en,category_name_en,subcategory_name_en) LIKE '%".$_GET['name_en']."%';";
     
      return $this->runDQL($query);
   }
   public function getprobySearch()
   {
      $query="SELECT * FROM product_details WHERE name_en='$this->name_en'
      OR brand_name_en='$this->name_en'OR category_name_en='$this->name_en'OR subcategory_name_en='$this->name_en'";
      return $this->runDQL($query);
   }

   //query in view in db

   //    CREATE VIEW product_details AS(
   //       SELECT
   //           `products`.*,
   //           COUNT(`reviews`.`product_id`) AS `reviews_count`,
   //           IF(
   //               ROUND(AVG(`reviews`.`value`)) IS NULL,
   //               0,
   //               ROUND(AVG(`reviews`.`value`))
   //           ) AS `reviews_avg`,
   //           `subcategories`.`name_en` AS `subcategory_name_en`,
   //           `brands`.`name_en` AS `brand_name_en`,
   //           `categories`.`id` AS `category_id`,
   //           `categories`.`name_en` AS `category_name_en`
   //       FROM
   //           `products`
   //       LEFT JOIN reviews ON products.id = reviews.product_id
   //       LEFT JOIN subcategories ON `subcategories`.`id` = `products`.`subcategory_id`
   //       LEFT JOIN `categories` ON `categories`.`id` = `subcategories`.`category_id`
   //       LEFT JOIN `brands` ON `brands`.`id` = `products`.`brand_id`
   //       WHERE
   //           `products`.`status` = 1
   //       GROUP BY
   //           `products`.`id`
   //   )

   /**
    * Get the value of id
    */
   public function getId()
   {
      return $this->id;
   }

   /**
    * Set the value of id
    *
    * @return  self
    */
   public function setId($id)
   {
      $this->id = $id;

      return $this;
   }

   /**
    * Get the value of name_en
    */
   public function getName_en()
   {
      return $this->name_en;
   }

   /**
    * Set the value of name_en
    *
    * @return  self
    */
   public function setName_en($name_en)
   {
      $this->name_en = $name_en;

      return $this;
   }

   /**
    * Get the value of name_ar
    */
   public function getName_ar()
   {
      return $this->name_ar;
   }

   /**
    * Set the value of name_ar
    *
    * @return  self
    */
   public function setName_ar($name_ar)
   {
      $this->name_ar = $name_ar;

      return $this;
   }

   /**
    * Get the value of price
    */
   public function getPrice()
   {
      return $this->price;
   }

   /**
    * Set the value of price
    *
    * @return  self
    */
   public function setPrice($price)
   {
      $this->price = $price;

      return $this;
   }

   /**
    * Get the value of code
    */
   public function getCode()
   {
      return $this->code;
   }

   /**
    * Set the value of code
    *
    * @return  self
    */
   public function setCode($code)
   {
      $this->code = $code;

      return $this;
   }

   /**
    * Get the value of desc_en
    */
   public function getDesc_en()
   {
      return $this->desc_en;
   }

   /**
    * Set the value of desc_en
    *
    * @return  self
    */
   public function setDesc_en($desc_en)
   {
      $this->desc_en = $desc_en;

      return $this;
   }

   /**
    * Get the value of desc_ar
    */
   public function getDesc_ar()
   {
      return $this->desc_ar;
   }

   /**
    * Set the value of desc_ar
    *
    * @return  self
    */
   public function setDesc_ar($desc_ar)
   {
      $this->desc_ar = $desc_ar;

      return $this;
   }

   /**
    * Get the value of quantity
    */
   public function getQuantity()
   {
      return $this->quantity;
   }

   /**
    * Set the value of quantity
    *
    * @return  self
    */
   public function setQuantity($quantity)
   {
      $this->quantity = $quantity;

      return $this;
   }

   /**
    * Get the value of status
    */
   public function getStatus()
   {
      return $this->status;
   }

   /**
    * Set the value of status
    *
    * @return  self
    */
   public function setStatus($status)
   {
      $this->status = $status;

      return $this;
   }

   /**
    * Get the value of subcategory_id
    */
   public function getSubcategory_id()
   {
      return $this->subcategory_id;
   }

   /**
    * Set the value of subcategory_id
    *
    * @return  self
    */
   public function setSubcategory_id($subcategory_id)
   {
      $this->subcategory_id = $subcategory_id;

      return $this;
   }

   /**
    * Get the value of brand_id
    */
   public function getBrand_id()
   {
      return $this->brand_id;
   }

   /**
    * Set the value of brand_id
    *
    * @return  self
    */
   public function setBrand_id($brand_id)
   {
      $this->brand_id = $brand_id;

      return $this;
   }

   /**
    * Get the value of image
    */
   public function getImage()
   {
      return $this->image;
   }

   /**
    * Set the value of image
    *
    * @return  self
    */
   public function setImage($image)
   {
      $this->image = $image;

      return $this;
   }

   /**
    * Get the value of created_at
    */
   public function getCreated_at()
   {
      return $this->created_at;
   }

   /**
    * Set the value of created_at
    *
    * @return  self
    */
   public function setCreated_at($created_at)
   {
      $this->created_at = $created_at;

      return $this;
   }

   /**
    * Get the value of updated_at
    */
   public function getUpdated_at()
   {
      return $this->updated_at;
   }

   /**
    * Set the value of updated_at
    *
    * @return  self
    */
   public function setUpdated_at($updated_at)
   {
      $this->updated_at = $updated_at;

      return $this;
   }

   /**
    * Get the value of category_id
    */
   public function getCategory_id()
   {
      return $this->category_id;
   }

   /**
    * Set the value of category_id
    *
    * @return  self
    */
   public function setCategory_id($category_id)
   {
      $this->category_id = $category_id;

      return $this;
   }
}
