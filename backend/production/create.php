<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 1728000");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../database.php';
 
// instantiate product object
include_once '../register.php';
 
$database = new Database();
$db = $database->getConnection();
 
$Register = new Register($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->phone) &&
    // !empty($data->email) &&
    !empty($data->birthday)
){
 
    // set product property values
    $Register->name = $data->name;
    $Register->phone = $data->phone;
    // $Register->email = $data->email;
    $Register->birthday = $data->birthday;
    if($Register->readOne($data->phone) == false){
        // create the product
        if($Register->create()){
    
            // set response code - 201 created
            http_response_code(201);
    
            // tell the user
            echo json_encode(array("message" => "Information was created."));
        }
    
        // if unable to create the product, tell the user
        else{
    
            // set response code - 503 service unavailable
            http_response_code(503);
    
            // tell the user
            echo json_encode(array("message" => 0));
        }
    }else{
        echo json_encode(array("message" => 0));
    }
    
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => 0));
}
?>