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
            'id' =>$id,
            'start_time' => $start_time,
            'id_tuyen' => $id_tuyen,
            'id_chuyen' => $id_chuyen,
            'license_plates' => $license_plates,
            'tuyen' => $tuyen,
            'gio' => $gio
        );
        array_push($Models_arr["records"], $Model_item);
        
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($Models_arr["records"]);
}else{
    http_response_code(200);
    echo json_encode(array("message" => 0));
}
 
// no products found will be here