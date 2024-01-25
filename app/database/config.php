<?php

class config{
    private $hostname="localhost";
    private $username="root";
    private $password="";
    private $database="nti_ecommerce";
    private $con;

    public function __construct() {
       $this-> con =new mysqli($this->hostname,$this->username,$this->password,$this->database);
    }//el function da 3obara 3n local function f mynf3sh el con astkhdmo fe ay makan bra el function de f a3mel eh 3lshan akhkleh yostakhdm fe ay makan gwa el class
    //b3mlo k property aw attribute a3rfo gwa el class 3lshan a2dar astkhdmo



    //hn3ml 2 functions dml w dql el dml ely bykon feha insert w delete w update w dql bykon feha select
    //f ha3mlha 3lshan da code msh hytghyar f hn3ml mno inheritance 3lshan a2dar astkhdmo w msh hnghyar haga feh fe kol el classes ely fe el models 3lshan el models ms h hy3ml haga gher el 2 functions dol bs 
    public function runDML(string $query):bool //hena el fn hyshel query da el input
    // 3lshan kol mara el query httghyar 3la hasb el estkhdam 
    //w el output hykon ya true aw false f htkon bool
    {
        //f kda ha2dar aklem el property con de mn hena 3ady 3lshan mb2tsh local gwa el function bs
        $result= $this->con->query($query);//el method ely btnfz query 3la el database esmha query elmethod de gwa class Msqli ely fe el con fo2 f lma bakhod object mn el class da ba2dar at3aml m3 ay property gwa el class w class Mysqli da class builtin gwa el php f 3eft en fe method gwaha esmha query hya de ely estkhdmnaha aw ndaht 3leha tb leh el method de 3lshan de lma btdeha query bt run el query de y3ny btdeha ya true aw false 
         if($result){
               return true;
         }else{
             return false;
         }
    }
//lakn hena el output hykon array 3lshan ba3ml select f el select herg3ly 3la hy2t array
    public function runDQL(string $query)
    {
        $result=$this->con->query($query);
        if(isset($result->num_rows)&& $result->num_rows > 0){
       
            return $result;
        }
        return [];
    }
    // f ay model mn dol wers el 2 methods dol y3ny ay model y2dar ynady 3la rundml aw el rundql
}