<?php
class Chuyen{
    // database connection and table name
    private $conn;
    private $table_name = "quanly_chuyen_xe";
    // object properties
public $id;
public $id_tuyen;
public $id_xe;
public $start_time;
public $date_create;
// public $email;
// constructor with $db as database connection
public function __construct($db){
    $this->conn = $db;
}
// read products
function getAll(){

    // select all query
    //$query = "SELECT * FROM ".$this->table_name." ORDER BY id DESC" ;
    $query = "SELECT c.id,start_time,t.name as id_tuyen,license_plates as id_xe,c.date_create FROM ".$this->table_name." c
    left join quanly_tuyen_xe t on t.id = c.id_tuyen
    left join quanly_xe x on x.id = c.id_xe";
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
function getByParam($id_tuyen){

    // select all query
        $query = "SELECT * FROM ".$this->table_name." WHERE id_tuyen = ".$id_tuyen." ORDER BY id DESC" ;
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();
    return $stmt;
}
function updateByID($id){
// select all query
    $query = "UPDATE ".$this->table_name." SET id_tuyen = '".$this->id_tuyen."', id_xe = '".$this->id_xe."', start_time = '".$this->start_time."' WHERE id = ".$id."" ;

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
        id_tuyen=:id_tuyen, id_xe=:id_xe, start_time=:start_time";

// prepare query

$stmt = $this->conn->prepare($query);

// sanitize
$this->id_tuyen=htmlspecialchars(strip_tags($this->id_tuyen));
$this->id_xe=htmlspecialchars(strip_tags($this->id_xe));
$this->start_time=htmlspecialchars(strip_tags($this->start_time));
// $this->email=htmlspecialchars(strip_tags($this->email));

// bind values
$stmt->bindParam(":id_tuyen", $this->id_tuyen);
$stmt->bindParam(":id_xe", $this->id_xe);
$stmt->bindParam(":start_time", $this->start_time);
//var_dump($stmt);die;
// execute query
if($stmt->execute()){
    return true;
}

return false;
 
}
}