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
include_once './bookingModel.php';
$database = new Database();
$db = $database->getConnection();
$Booking = new Booking($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
//var_dump($data);die;
// make sure data is not empty
$decoded = json_decode(base64_decode($data->token));
if(!empty($data->id)){
    if(
        !empty($decoded->id) 
    ){
        // set product property values
        $Booking->flag = $data->flag;
        $Booking->date = $data->date;
        $Booking->time = $data->time;
        $Booking->type_of_car = $data->type_of_car;
        $Booking->customer_name = $data->customer_name;
        $Booking->customer_phone = $data->customer_phone;
        $Booking->arrival_place = $data->arrival;
        $Booking->departure_place = $data->departure;
        $Booking->pickup_place = $data->pickup_place;
        $Booking->place_of_guest = $data->place_of_guest;
        $Booking->NCC = $data->NCC;
        $Booking->proceeds = $data->proceeds;
        $Booking->proceeds_currency = $data->proceeds_currency;
        $Booking->revenue = $data->revenue;
        $Booking->revenue_currency = $data->revenue_currency;
        $Booking->cost = $data->cost;
        $Booking->profit = floatval($data->revenue) - floatval($data->cost);
        $Booking->partner = $data->partner;
        $Booking->seller = $decoded->username;
        $Booking->note = $data->note;
        $Booking->user_id = $decoded->id;
        $Booking->arrival_place_id = $data->arrival;
        $Booking->departure_place_id = $data->departure;
        $Booking->NCC_id = $data->NCC;
        $Booking->car_of_supplier = $data->car;
        $Booking->partner_id = $data->partner;
        $Booking->type_of_car_id = $data->type_of_car;

            // create the product
            if($Booking->updateByID($data->id)){
                // set response code - 201 created
                http_response_code(201);
        
                // tell the user
                echo json_encode(array("message" => "1"));
            }
            // if unable to create the product, tell the user
            else{
        
                // set response code - 503 service unavailable
                http_response_code(503);
        
                // tell the user
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
}else{
    http_response_code(404);
    echo json_encode(array("message" => 0));
}

?>