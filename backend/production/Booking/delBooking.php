<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 1728000");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../../database.php';
 
// instantiate product object
include_once './bookingModel.php';
 
$database = new Database();
$db = $database->getConnection();
 
$Booking = new Booking($db);
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)){
    // query products
    $decoded = json_decode(base64_decode($data->token));
    //echo(empty($decoded->token));die;
    if(isset($decoded->token) && !empty($decoded->token)){
        //echo($Booking->del($data->id));die;
        if($Booking->del($data->id)){
            echo json_encode(array("message" => '1'));
        }else{
            echo json_encode(array("message" => '0'));
        } 
    }else{
        echo json_encode(array("message" => '2'));
    }
     
}else{
    echo json_encode(array("message" => '3'));
}

?>