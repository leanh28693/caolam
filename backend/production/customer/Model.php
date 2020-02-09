<?php
class Customer{
    // database connection and table name
    private $conn;
    private $table_name = "quanly_customer";
    // object properties
public $id;
public $name;
public $phone;
public $address;
public $id_tuyen;
public $id_chuyen;
public $start_time;
public $id_seat;
public $seat;
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
function getOneByname($start_time,$id_tuyen){
    // select all query
    $query = "SELECT * FROM ".$this->table_name." WHERE start_time = '".$start_time."' and id_tuyen = '".$id_tuyen."'" ;
    
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
function getByParam($id_tuyen,$id_chuyen,$start_time){

    // select all query
        $query = "SELECT * FROM ".$this->table_name." WHERE  id_tuyen = ".$id_tuyen." and id_chuyen = ".$id_chuyen." and start_time = ".$start_time." ORDER BY id DESC" ;
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    return $stmt;
}
function getOneByParams($phone,$id_tuyen,$id_chuyen,$start_time){

    // select all query
        $query = "SELECT * FROM ".$this->table_name." WHERE phone = ".$phone." and id_tuyen = ".$id_tuyen." and id_chuyen = ".$id_chuyen." and start_time = ".$start_time." ORDER BY id DESC" ;
    
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
    $query = "UPDATE ".$this->table_name." SET id_tuyen = '".$this->id_tuyen."', id_chuyen = '".$this->id_chuyen."', start_time = '".$this->start_time."' WHERE id = ".$id."" ;

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
        name=:name, phone=:phone, address=:address, id_tuyen=:id_tuyen , id_chuyen=:id_chuyen , start_time=:start_time , id_seat=:id_seat , seat=:seat";

// prepare query

$stmt = $this->conn->prepare($query);

// sanitize
$this->name=htmlspecialchars(strip_tags($this->name));
$this->phone=htmlspecialchars(strip_tags($this->phone));
$this->address=htmlspecialchars(strip_tags($this->address));
$this->id_tuyen=htmlspecialchars(strip_tags($this->id_tuyen));
$this->id_chuyen=htmlspecialchars(strip_tags($this->id_chuyen));
$this->start_time=htmlspecialchars(strip_tags($this->start_time));
$this->id_seat=htmlspecialchars(strip_tags($this->id_seat));
$this->seat=htmlspecialchars(strip_tags($this->seat));
// bind values
$stmt->bindParam(":name", $this->name);
$stmt->bindParam(":phone", $this->phone);
$stmt->bindParam(":address", $this->address);
$stmt->bindParam(":id_tuyen", $this->id_tuyen);
$stmt->bindParam(":id_chuyen", $this->id_chuyen);
$stmt->bindParam(":start_time", $this->start_time);
$stmt->bindParam(":id_seat", $this->id_seat);
$stmt->bindParam(":seat", $this->seat);
//var_dump($stmt);die;
// execute query
if($stmt->execute()){
    return true;
}

return false;
 
}
}