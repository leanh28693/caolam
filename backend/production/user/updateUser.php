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
include_once './userModel.php';
$database = new Database();
$db = $database->getConnection();
$User = new User($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
//var_dump($data);die;
// make sure data is not empty
if(!empty($data->password)){
    if(
        !empty($data->username) &&
        !empty($data->department) &&
        !empty($data->user_category)
    ){
        // set product property values
        $User->id = $data->id;
        $User->frsname = $data->frsname;
        $User->lastname = $data->lastname;
        $User->department = $data->department;
        $User->address = $data->address;
        $User->username = $data->username;
        $User->password = $data->password;
        $User->user_category = $data->user_category;
        $User->phone = $data->phone;
        $User->email = $data->email;

            // create the product
            if($User->updateByID($data->id)){
        
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
    if(
        !empty($data->username) &&
        !empty($data->department) &&
        !empty($data->user_category)
    ){
        // set product property values
        $User->frsname = $data->frsname;
        $User->lastname = $data->lastname;
        $User->department = $data->department;
        $User->address = $data->address;
        $User->username = $data->username;
        $User->user_category = $data->user_category;
        $User->phone = $data->phone;
        $User->email = $data->email;
            // create the product
            if($User->updateByID($data->id)){
        
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
}

?>