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
$Model = new label40($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
//var_dump($data);die;
// make sure data is not empty
if(!empty($data->params)){
    $flag =  true;
        foreach ($data->params as $row) {
            if($Model->updateLabel($row[1],$row[0])){
                
            }else{
                $flag = false;
                break;
            }
        }
        if($flag){
            http_response_code(200);
            echo json_encode(array("message" => 1));
        }else{
            http_response_code(200);
            echo json_encode(array("message" => 2));
        }
    
     
}else{
    http_response_code(200);
    echo json_encode(array("message" => 0));
}
?>