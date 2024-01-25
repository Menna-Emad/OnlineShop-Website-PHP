<?php
include_once __DIR__."\..\database\config.php";
class Validation{
    private $name;
    private $value;
    public function __construct($name,$value) {
        $this->name= $name;
        $this->value=$value;
    }

    //fe b2a tary2a tanya badl ma amshy 3la property property w ashofha required wla laa laa a3mel function wahda
//hnshel el parameter value w name ely kant fe el required fn 3lshan kda kda ehna hatnha ka property fe el class 3lshan n2dar nakhod object aw instance mn class el validation
     public function required():string
     {
              return (empty($this->value))? "$this->name is Required":"";
     }

     public function regex($pattern)
     {
        //lw reg3 true yb2a el pattern motab2 ll regular exp lw false yb2a msh motab2
         return(preg_match($pattern,$this->value))? "" : "$this->name Is Invalid";
     }


     //lw 3ayz a3rf el aga de unique wla laa f kda da mot3al2 bl database f ely motghyar hena el query
     //bs leha kam parameter aw variable el table w column esmo ehh w value ely gwa el column
      public function unique($table): string//elname hena equal el table
      {
            $query ="SELECT * FROM `$table` WHERE  `$this->name` = `$this->value`";
            
            $config = new config;//b3d ma 3mlna include l config file kda akno mawgod class el config f a2dar akhod mno object ely hwa config
           $result= $config->runDQL($query);//kda htrg3ly ya array mlyana aw fadya
           return (empty($result))? "": "this $this->name is already exists";
      }
      // bttcheck el pass sah wla laaa aw ay value b2a han7otha f badl kelmt password hn7ot variable tany
    //   public function confirmed($password,$passwordConfirmation)
    //   {
    //     return ($password==$passwordConfirmation)?"":"password not cofirmed";
    //   }
    public function confirmed($valueConfirmation)
    {
      return ($this->value==$valueConfirmation)?"":"$this->name not cofirmed";
    }







    //de kda tary2t kol property ba3mlha validation aw bashofha mawgoda wla laa
    // private $email;

    // /**
    //  * Get the value of email
    //  */ 
    // public function getEmail()
    // {
    //     return $this->email;
    // }

    // /**
    //  * Set the value of email
    //  *
    //  * @return  self
    //  */ 
    // public function setEmail($email)
    // {
    //     $this->email = $email;

    //     return $this;
    // }
//da bashof el email mawgod wla laa fe el data base 
 //btshof el email de leha kyma wla laa lw mlhash tdrab error
//    public function emailRequired() : string
  
//    {
        // return (empty($this->email)) ? "Email is Required" : "";
        //elempty htrg3 true lw email fady else htrg3 false lw mlyan
//    }

   
 }