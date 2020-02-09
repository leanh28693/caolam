<?php
class Car{
    // database connection and table name
    private $conn;
    private $table_name = "quanly_xe";
    // object properties
public $id;
public $description;
public $number_of_seats;
public $license_plates;
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
function getOneByname($name){
    // select all query
    $query = "SELECT * FROM ".$this->table_name." WHERE license_plates = '".$name."'" ;
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row >0){
        //echo('true');die;
        return true;
    }
    //echo('false');die;
    return false;
}
function updateByID($id){
// select all query
    $query = "UPDATE ".$this->table_name." SET number_of_seats = '".$this->number_of_seats."', license_plates = '".$this->license_plates."', description = '".$this->description."' WHERE id = ".$id."" ;

// prepare query statement
$stmt = $this->conn->prepare($query);
// execute query
//var_dump($stmt);die;
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
        description=:description, number_of_seats=:number_of_seats, license_plates=:license_plates";

// prepare query

$stmt = $this->conn->prepare($query);

// sanitize
$this->description=htmlspecialchars(strip_tags($this->description));
$this->number_of_seats=htmlspecialchars(strip_tags($this->number_of_seats));
$this->license_plates=htmlspecialchars(strip_tags($this->license_plates));
// $this->email=htmlspecialchars(strip_tags($this->email));

// bind values
$stmt->bindParam(":description", $this->description);
$stmt->bindParam(":number_of_seats", $this->number_of_seats);
$stmt->bindParam(":license_plates", $this->license_plates);
//var_dump($stmt);die;
// execute query
if($stmt->execute()){
    return true;
}

return false;
 
}
}