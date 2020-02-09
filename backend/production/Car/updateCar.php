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
include_once './carModel.php';
$database = new Database();
$db = $database->getConnection();
$Car = new Car($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
//var_dump($data);die;
// make sure data is not empty
if(!empty($data->id)){
    if(
        !empty($data->license_plates)||
        !empty($data->number_of_seats) 
    ){
        // set product property values
        $Car->license_plates = $data->license_plates;
        $Car->description = $data->description;
        $Car->number_of_seats = $data->number_of_seats;
            // create the product
            if($Car->updateByID($data->id)){
                // set response code - 201 created
                http_response_code(200);
        
                // tell the user
                echo json_encode(array("message" => "1"));
            }
            // if unable to create the product, tell the user
            else{
        
                // set response code - 503 service unavailable
                http_response_code(200);
        
                // tell the user
                echo json_encode(array("message" => 0));
            }
    }
     // tell the user data is incomplete
    else{
        // set response code - 400 bad request
        http_response_code(200);
        // tell the user
        echo json_encode(array("message" => 0));
    }
}else{
    http_response_code(200);
    echo json_encode(array("message" => 0));
}
?>