<?php
class Booking{
    // database connection and table name
    private $conn;
    private $table_name = "quanly_lichtrinh";
    // object properties
public $id;
public $start_time;
public $id_xe;
public $id_chuyen;
public $id_tuyen;
public $bus_type;
public $id_cui_ve;
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
function getByParams($start_time,$id_tuyen,$id_chuyen){
        $query = "SELECT * FROM ".$this->table_name." WHERE start_time = ".$start_time." and id_tuyen =".$id_tuyen." and id_chuyen =".$id_chuyen."" ;
        //echo $query;die;
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    return $stmt;
}
function getOneByname($name){
    // select all query
    $query = "SELECT * FROM ".$this->table_name." WHERE name = '".$name."'" ;
    
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
    $query = "UPDATE ".$this->table_name.
    " SET date = '".$this->date.
    "', time = '".$this->time.
    "', type_of_car = '".$this->type_of_car.
    "', customer_name = '".$this->customer_name.
    "', customer_phone = '".$this->customer_phone.
    "', arrival_place = '".$this->arrival_place.
    "', departure_place = '".$this->departure_place.
    "', pickup_place = '".$this->pickup_place.
    "', place_of_guest = '".$this->place_of_guest.
    "', NCC = '".$this->NCC.
    "', proceeds = '".$this->proceeds.
    "', proceeds_currency = '".$this->proceeds_currency.
    "', revenue = '".$this->revenue.
    "', revenue_currency = '".$this->revenue_currency.
    "', profit = '".$this->profit.
    "', partner = '".$this->partner.
    "', seller = '".$this->seller.
    "', note = '".$this->note.
    "', user_id = '".$this->user_id.
    "', arrival_place_id = '".$this->arrival_place_id.
    "', departure_place_id = '".$this->departure_place_id.
    "', NCC_id = '".$this->NCC_id.
    "', car_of_supplier = '".$this->car_of_supplier.
    "', partner_id = '".$this->partner_id.
    "', type_of_car_id = '".$this->type_of_car_id.
    "', flag = '".$this->flag.
    "', cost = '".$this->cost.
    "' WHERE id = ".$id."" ;

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
        start_time=:start_time,
        id_xe=:id_xe,  
        id_tuyen=:id_tuyen, 
        id_chuyen=:id_chuyen,
        bus_type=:bus_type";
// $query = "INSERT INTO
//             " . $this->table_name . "
//         SET
//         start_time=" . $this->start_time . ",
//         id_xe=" . $this->id_xe . ",  
//         id_tuyen=" . $this->id_tuyen . ", 
//         id_chuyen=" . $this->id_chuyen . ",
//         bus_type=" . $this->bus_type . "";

$stmt = $this->conn->prepare($query);
// // sanitize
$this->start_time=htmlspecialchars(strip_tags($this->start_time));
$this->id_xe=htmlspecialchars(strip_tags($this->id_xe));
$this->id_tuyen=htmlspecialchars(strip_tags($this->id_tuyen));
$this->id_chuyen=htmlspecialchars(strip_tags($this->id_chuyen));
$this->bus_type=htmlspecialchars(strip_tags($this->bus_type));
//$this->id_cui_ve=htmlspecialchars(strip_tags($this->id_cui_ve));


// // bind values
$stmt->bindParam(":start_time", $this->start_time);
$stmt->bindParam(":id_xe", $this->id_xe);
$stmt->bindParam(":id_tuyen", $this->id_tuyen);
$stmt->bindParam(":id_chuyen", $this->id_chuyen);
$stmt->bindParam(":bus_type", $this->bus_type);
//$stmt->bindParam(":id_cui_ve", $this->id_cui_ve);
//var_dump($this);
//var_dump($stmt->execute());die;
// execute query
//var_dump($stmt);die;
if($stmt->execute()){
    return true;
}
return false;
}
}