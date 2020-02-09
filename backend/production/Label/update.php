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
include_once '../customer/Model.php';
$database = new Database();
$db = $database->getConnection();
$Model = new Cuive($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
//var_dump($data);die;
// make sure data is not empty
if(!empty($data->name)){
    if(
        !empty($data->phone)||
        !empty($data->seat_choosing)
    ){
        // set product property values
        $Model->customer_info = array(
            "name"=>$data->name,
            "phone"=>$data->phone,
            "address"=>$data->address,
        );
        $flag  = true;
            for($i=0; $i < count($data->seat_choosing);$i++){
                if($Model->AddCustommerByID($data->seat_choosing[$i]->id)){
                }
                // if unable to create the product, tell the user
                else{
                    $flag = false;
                    break;
                }
            }
        if($flag){
            // set response code - 400 bad request
        http_response_code(200);
        // tell the user
        echo json_encode(array("message" => 1));
        }else{
        // set response code - 400 bad request
        http_response_code(200);
        // tell the user
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
}else{
    http_response_code(200);
    echo json_encode(array("message" => 0));
}
?>