<?php
//hn3ml class l kol table fe el database esm el gadwal mofrad w ybd2 capital da standard ps4 
 //awl haga lazm ykon 3aml connection 3lshan yklm el table ely fe el database
    //lazm 3lshan el connection de ttm lazm akhod object mn class el config
    //lazm ageb class el config da fe el saf7a de 3lshan a3ml extend mno 3lshan class user twres el constructor y3ny inheritance
    //tb eshm3na inheritance 3lshan el connection sabt 
     //relative path ->read only menf3sh a3ml midify l file not fixed bytghyar
    //   absolute path->read &write or aktb feh code w el path da sabt fixed

    include_once __DIR__."\..\database\config.php";//hnstkhdm absolute path w dir da bygeb directory of folder ely ana wa2ef feh y3ny el dir de htgbly l had folder el path k absolute path
    include_once __DIR__."\..\database\operations.php";
    //extends kda wrest connection
class User extends config implements operations{
    //table el user shayel 13 column w msh hyzedo wla hy2elo f lazm a3rfhom gwa el class k private attribute aw property
    private $id;
    private $first_name;
    private $last_name;
    private $phone;
    private $email;
    private $password;
    private $gender;
    private $email_verified_at;
    private $status;
    private $code;
    private $birthdate;
    private $image;
    private $created_at;
    private $updated_at;
    //tyb hena ana 3mla l kol el attributes private tyb lw get ay file w 3yza a pass el attributes de henak henf3 laa aked
    //3lshan n3rf nklmha fe el global f lazm a3ml l kol wahda setter w getter 3lshan n3rf nklmha fe ay class tany
    public function create()
   {   //hena 3lshan andah 3la el create ely hya el insert
    //ba3ml variable asmeh query akteb feh el query mn table el user w adkhl feh el name w el values bto3ha
    //tyb el values kda kda homa property mn fo2 mn class el user f ha7thom tb leh fe single quotes 3lshan a2ol en de string
      $query ="INSERT INTO users (first_name,last_name,email,phone,password,birthdate,gender,code)
       VALUES ('$this->first_name','$this->last_name','$this->email',
       '$this->phone','$this->password','$this->birthdate','$this->gender',$this->code)";
      //w b3den barg3 ehh hena b run dql ely mas2ol 3n el insert w el mafrod en hwa bool y3ny ya btrg3 true aw false w a passelo variable el query

      return $this->runDML($query);
   }
   public function read()
   {
    
   }
   public function update()
   {
       $image=NULL;
       if(!empty($this->image)){
        $image =" , image ='$this->image' ";
       }

    $query="UPDATE users SET first_name ='$this->first_name',last_name='$this->last_name',
    phone ='$this->phone', gender='$this->gender' $image WHERE email= '$this->email'";
    return $this->runDML($query);
   }
   public function delete()
   {
    
   }

   public function checkCode()
   {
    //$this->email da el email ely gy mn el object ely fe file checkpage
    $query="SELECT * FROM `users` WHERE email='$this->email' AND code=$this->code";
    return $this->runDQL($query);
   }

   public function makeUserVerified()
   {
    $query="UPDATE `users` SET email_verified_at='$this->email_verified_at' , status=$this->status 
    WHERE email='$this->email'";
    return $this->runDML($query);
   }
    

   public function login()
   {
        $query="SELECT * FROM users WHERE email ='$this->email' AND password='$this->password'";
        return $this->runDQL($query);
   }
    

   public function getUserByEmail()
   {
    $query= "SELECT * FROM users WHERE email = '$this->email'";
    return $this->runDQL($query);
   }

   public function updateCodeByEmail()
   {
    $query="UPDATE `users` SET code ='$this->code' WHERE email = '$this->email' " ;
    return $this->runDML($query);
   }

   public function updatePasswordByEmail()
   {
    $query="UPDATE `users` SET password ='$this->password' WHERE email = '$this->email' ";
    return $this->runDML($query);
   }

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
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->first_name;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->first_name = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->last_name;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->last_name = $lastname;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = sha1($password);

        return $this;
    }

    /**
     * Get the value of gender
     */ 
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */ 
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of email_verified_at
     */ 
    public function getEmail_verified_at()
    {
        return $this->email_verified_at;
    }

    /**
     * Set the value of email_verified_at
     *
     * @return  self
     */ 
    public function setEmail_verified_at($email_verified_at)
    {
        $this->email_verified_at = $email_verified_at;

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
     * Get the value of birthdate
     */ 
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set the value of birthdate
     *
     * @return  self
     */ 
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }
}
