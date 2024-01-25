<?php
include_once __DIR__ . '\..\database\config.php';
include_once __DIR__ . '\..\database\operations.php';

class Wishlist extends config implements operations
{
    private $product_id;
    private $user_id;
    private $name_en;
    private $quantity;
    private $price;
    private $image;

    public function create()
    {
        $query = "INSERT INTO wishlists (product_id,user_id,name_en,quantity,price,image)
       VALUES ('$this->product_id','$this->user_id',
       '$this->name_en','$this->quantity','$this->price','$this->image')";
        return $this->runDML($query);
    }
    public function read()
    {
        $query = "SELECT *  FROM `wishlists`";
        return $this->runDQL($query);
    }
    public function delete()
    {
       $query="DELETE FROM wishlists WHERE product_id=".$_POST['product_id']."";
       return $this->runDML($query);
    }
    public function update()
    {
       
    }

    public function getNumofproInWishlist()
    {
      $query="SELECT user_id, COUNT(product_id) AS NumbOfProductsInWishlist FROM wishlists Right JOIN users ON users.id=wishlists.user_id;";
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
}