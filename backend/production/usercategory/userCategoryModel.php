<?php
class UserCategory{
    // database connection and table name
    private $conn;
    private $table_name = "user_category";
    // object properties
    public $id;
    public $name;
    public $description;
    public $date_create;
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
function getOneByID($id){
        // select all query
        $query = "SELECT * FROM ".$this->table_name." WHERE id = ".$id."" ;
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
        return $stmt;
    }    
function updateFlagByID($id){
    
        // select all query
        $query = "UPDATE ".$this->table_name." SET ".$name."=".$value." WHERE id = ".$id."" ;
        //echo $query;die;
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
    $query = "detete
                *
            FROM
                " . $this->table_name . " p
            WHERE
                p.id = ".$id."
            LIMIT
                0,1";
    
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
 
    // execute query
    $stmt->execute();
    
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}
    // create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, phone=:phone, birthday=:birthday";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->birthday=htmlspecialchars(strip_tags($this->birthday));
    // $this->email=htmlspecialchars(strip_tags($this->email));
 
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":birthday", $this->birthday);
    // $stmt->bindParam(":email", $this->email);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}