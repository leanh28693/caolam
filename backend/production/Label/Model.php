<?php
class label40{
    // database connection and table name
    private $conn;
    private $table_name = "quanly_label_bus41";
    // object properties
public $id;
public $label;

// public $email;
// constructor with $db as database connection
public function __construct($db){
    $this->conn = $db;
}
// read products
function getAll(){

    // select all query
    $query = "SELECT * FROM ".$this->table_name." ORDER BY id ASC" ;
    
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
function getByParams($start_time,$id_tuyen,$id_chuyen){
    $query = "SELECT * FROM ".$this->table_name." WHERE start_time = ".$start_time." and id_tuyen =".$id_tuyen." and id_chuyen =".$id_chuyen." ORDER BY id desc" ;
    //echo $query;die;
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
function AddCustommerByID($id){
    // select all query
        $query = "UPDATE ".$this->table_name." SET customer_info = '".json_encode($this->customer_info,JSON_UNESCAPED_UNICODE )."' , status = 1 WHERE id = ".$id."" ;
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
$query = "DELETE FROM " . $this->table_name . " WHERE id = ".$id;
$stmt = $this->conn->prepare( $query );
try{
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
        id=:id, id_lichtrinh=:id_lichtrinh, start_time=:start_time, id_tuyen=:id_tuyen, id_chuyen=:id_chuyen, seat_num=:seat_num, label=:label, customer_info=:customer_info";

// prepare query

$stmt = $this->conn->prepare($query);

// sanitize
$this->id=htmlspecialchars(strip_tags($this->id));
$this->id_lichtrinh=htmlspecialchars(strip_tags($this->id_lichtrinh));
$this->start_time=htmlspecialchars(strip_tags($this->start_time));
$this->id_tuyen=htmlspecialchars(strip_tags($this->id_tuyen));
$this->id_chuyen=htmlspecialchars(strip_tags($this->id_chuyen));
$this->seat_num=htmlspecialchars(strip_tags($this->seat_num));
$this->label=htmlspecialchars(strip_tags($this->label));
$this->customer_info=htmlspecialchars(strip_tags($this->customer_info));

// bind values
$stmt->bindParam(":id", $this->id);
$stmt->bindParam(":id_lichtrinh", $this->id_lichtrinh);
$stmt->bindParam(":start_time", $this->start_time);
$stmt->bindParam(":id_tuyen", $this->id_tuyen);
$stmt->bindParam(":id_chuyen", $this->id_chuyen);
$stmt->bindParam(":seat_num", $this->seat_num);
$stmt->bindParam(":label", $this->label);
$stmt->bindParam(":customer_info", $this->customer_info);
//var_dump($stmt);die;
// execute query
if($stmt->execute()){
    return true;
}
return false;
}
}