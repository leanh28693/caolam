<?php
// required headers
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 1728000");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../../database.php';
 
// instantiate product object
include_once './Model.php';
 
$database = new Database();
$db = $database->getConnection();
 
$Model = new Chuyen($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 //var_dump($data);die;
// make sure data is not empty
if(
    !empty($data->name) 
){
    // set product property values
    $Model->name = $data->name;
    $Model->description = $data->description;
    
    if($Model->getOneByname($data->name) == false){
        // create the product
        if($Model->create()){
            // set response code - 201 created
            http_response_code(200);
    
            // tell the user
            echo json_encode(array("message" => 1));
        }
        // if unable to create the product, tell the user
        else{
    
            // set response code - 503 service unavailable
            http_response_code(200);
    
            // tell the user
            echo json_encode(array("message" => 3));
        }
    }else{
        echo json_encode(array("message" => 2));
    }
    
}
 // tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => 0));
}
?>