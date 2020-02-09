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
include_once './Model.php';
include_once '../customer/Model.php';
$database = new Database();
$db = $database->getConnection();
 
$Model = new Cuive($db);
$Customer_Model = new Customer($db);
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->id) || !empty($data->titket_id)){
   
    if($Customer_Model->del($data->id)){
        $flag = true;
        foreach($data->titket_id as $row){
            if($Model->updateCustomerByID($row)){
               
            }else{
                $flag = false;
            break;
            } 
        }
        if($flag){
            http_response_code(200);
            echo json_encode(array("message" => '0',"value"=>"delete thành công"));
        }else{
            http_response_code(200);
            echo json_encode(array("message" => '1',"value"=>"không update được titket"));
        }
       
    }else{
        http_response_code(200);
        echo json_encode(array("message" => '2',"value"=>"không xóa được customer"));
    }
     
}else{
    http_response_code(200);
    echo json_encode(array("message" => '3',"value"=>"thiếu request params"));
}

?>