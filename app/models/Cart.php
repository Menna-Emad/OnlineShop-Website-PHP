<?php
include_once __DIR__ . '\..\database\config.php';
include_once __DIR__ . '\..\database\operations.php';

class Cart extends config implements operations
{
    private $product_id;
    private $user_id;
    private $quantity;
    private $name_en;
    private $price;
    private $image;
    

    public function create()
    {
        $query = "INSERT INTO carts (product_id,user_id,quantity,name_en,price,image)
       VALUES ('$this->product_id','$this->user_id','$this->quantity',
       '$this->name_en','$this->price','$this->image')";
        return $this->runDML($query);
    }
    public function read()
    {
        $query = "SELECT * , (price*quantity) AS totalprice FROM `carts`";
        return $this->runDQL($query);
    }
    public function delete()
    {
       $query="DELETE FROM carts WHERE product_id=".$_POST['product_id']."";
       return $this->runDML($query);
    }
    public function update()
    {
       
    }

   public function gettotalPrice()
   {
      
       $query="SELECT SUM(price*quantity) AS subtotal FROM `carts`";
       return $this->runDQL($query);
  }

  public function getNumofproInCart()
  {
    $query="SELECT user_id, COUNT(product_id) AS NumbOfProductsInCart FROM carts Right JOIN users ON users.id=carts.user_id;";
    return $this->runDQL($query);
  }

  

    /**
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

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

   
}
