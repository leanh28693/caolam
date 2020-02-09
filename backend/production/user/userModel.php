<?php
class User{
    // database connection and table name
    private $conn;
    private $table_name = "register";
    // object properties
    public $id;
    public $frsname;
    public $lastname;
    public $department;
    public $user_category;
    public $address;
    public $username;
    public $password;
    public $category;
    public $phone;
    public $token;
    // public $email;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function getAll(){
    
        // select all query
        $query = "SELECT * FROM ".$this->table_name." ORDER BY id DESC" ;
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }
  // used when filling up the update product form
function readOne($username){
 
    // query to read single record
    $query = "SELECT
                *
            FROM
                " . $this->table_name . " p
                
            WHERE
                p.username = ".$username."
            LIMIT
                0,1";
    
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
 
    // execute query
    $stmt->execute();
    
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($row);die;
    return $row;
}
function getOneByID($id){
        // select all query
        $query = "SELECT * FROM ".$this->table_name." WHERE id = ".$id."" ;
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }    
function updateByID($id){
        // select all query
        if(empty($this->password)|| strlen($this->password) < 6){
            $query = "UPDATE ".$this->table_name." SET first_name = '".$this->frsname."',last_name = '".$this->lastname."',username = '".$this->username."',email = '".$this->email."',phone = '".$this->phone."',address = '".$this->address."',department = '".$this->department."',user_category = '".$this->user_category."' WHERE id = ".$id."" ;
        }else{
            $query = "UPDATE ".$this->table_name." SET first_name = '".$this->frsname."',last_name = '".$this->lastname."',username = '".$this->username."',password = '".$this->password."',email = '".$this->email."',phone = '".$this->phone."',address = '".$this->address."',department = '".$this->department."',user_category = '".$this->user_category."' WHERE id = ".$id."" ;
        }
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }    
// used when filling up the update product form
function del($id){
 
    // query to read single record
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ".$id;
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    
    try{
        //var_dump($stmt);die;
        // execute query
        if($stmt->execute()){
            return true;
        }
    }catch (Exception $e){
        echo($e);
    }
        return false;
}
    // create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                first_name=:frsname, last_name=:lastname, username=:username, password=:password, email=:email, phone=:phone, address=:address, department=:department, user_category=:user_category,token=:token";
 
    // prepare query
    
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->frsname=htmlspecialchars(strip_tags($this->frsname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->address=htmlspecialchars(strip_tags($this->address));
    $this->department=htmlspecialchars(strip_tags($this->department));
    $this->user_category=htmlspecialchars(strip_tags($this->user_category));
    $this->token=htmlspecialchars(strip_tags($this->token));
    // bind values
    $stmt->bindParam(":frsname", $this->frsname);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":department", $this->department);
    $stmt->bindParam(":user_category", $this->user_category);
    $stmt->bindParam(":token", $this->token);
    //var_dump($this->frsname);die;
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}