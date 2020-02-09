<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
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
    !empty($data->id)
){
 
    if($Register->updateFlagByID($data->id)){
        echo json_encode(array("message" => 'successfull'));
    }else{
        echo json_encode(array("message" => 0));
    }
 
    
}
?>