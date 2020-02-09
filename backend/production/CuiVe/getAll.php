<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// database connection will be here
// include database and object files
include_once '../../database.php';
include_once './Model.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Model = new Chuyen($db);

// query products
$stmt = $Model->getAll();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    
    // products array
    $Models_arr=array();
    $Models_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        extract($row);
        $Model_item = array(
            $id,
            $id_tuyen,
            $id_xe,
            $start_time
        );
        array_push($Models_arr["records"], $Model_item);
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($Models_arr["records"]);
}else{
    $NCCs_arr["records"]=array();
    http_response_code(200);
    echo json_encode($NCCs_arr["records"]);
}
 
// no products found will be here