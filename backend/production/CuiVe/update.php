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
$ModelCustomer = new Customer($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
//var_dump($data);die;
// make sure data is not empty
if(!empty($data->name)){
    if(
        !empty($data->phone)||
        !empty($data->id_tuyen)||
        !empty($data->id_chuyen)||
        !empty($data->start_time)||
        !empty($data->seat_choosing)
    ){
        $ModelCustomer->name = $data->name;
        $ModelCustomer->phone = $data->phone;
        $ModelCustomer->address = $data->address;
        $ModelCustomer->id_tuyen = $data->id_tuyen;
        $ModelCustomer->id_chuyen = $data->id_chuyen;
        $ModelCustomer->start_time = $data->start_time;
        
        if($ModelCustomer->getOneByParams($data->phone,$data->id_tuyen,$data->id_chuyen,$data->start_time) == false){
            // create the product
            // set product property values\
            $seat_list = "";
            $seat_list_id=array();
            $Model->customer_info = array(
                "name"=>$data->name,
                "phone"=>$data->phone,
                "address"=>$data->address,
            );
            $flag  = true;
                for($i=0; $i < count($data->seat_choosing);$i++){
                    $seat_list = $seat_list."".$data->seat_choosing[$i]->label."  ";
                    array_push($seat_list_id, $data->seat_choosing[$i]->id);
                    if($Model->AddCustommerByID($data->seat_choosing[$i]->id)){
                    }
                    // if unable to create the product, tell the user
                    else{
                        $flag = false;
                        break;
                    }
                }    
            $ModelCustomer->seat = $seat_list;
            $ModelCustomer->id_seat = implode( ",", $seat_list_id);
            if($ModelCustomer->create()){
                if($flag){
                    // set response code - 400 bad request
                http_response_code(200);
                // tell the user
                echo json_encode(array("message" => 1,'value'=>'thành công đặt vé'));
                }else{
                // set response code - 400 bad request
                http_response_code(200);
                // tell the user
                echo json_encode(array("message" => 2,'value'=>'không update được thông tin vào ghế'));
                }
            }
            // if unable to create the product, tell the user
            else{
        
                // set response code - 503 service unavailable
                http_response_code(200);
        
                // tell the user
                echo json_encode(array("message" => 2,'value'=>'không tạo được customer'));
            }
        }else{
            http_response_code(200);
            echo json_encode(array("message" => 2,'value'=>'khách hàng đã đặt vé trước'));
        }
            
    }
     // tell the user data is incomplete
    else{
        // set response code - 400 bad request
        http_response_code(200);
        // tell the user
        echo json_encode(array("message" => 0,'value'=>'thiếu thông tin'));
    }
}else{
    http_response_code(200);
    echo json_encode(array("message" => 0,'value'=>'chưa có tên khách hàng'));
}
?>