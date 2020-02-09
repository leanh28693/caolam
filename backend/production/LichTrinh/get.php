<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 1728000");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// database connection will be here
// include database and object files
include_once '../../database.php';
include_once './Model.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Model = new Chuyen($db);
$data = json_decode(file_get_contents("php://input"));
// query products
$stmt = $Model->getOneByID($data->id);
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
            'id_xe' => $id_xe,
            'id_chuyen' => $id_chuyen,
            'id_tuyen' => $id_tuyen,
            'bus_type' => $bus_type,
            'id_cui_ve' => $id_cui_ve,
            'license_plates' => $license_plates,
            'tuyen' => $tuyen,
            'date' => $date,
            'gio' => $gio,
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