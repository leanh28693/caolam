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
include_once './bookingModel.php';

include_once '../CuiVe/Model.php';
// instantiate database and product object
$database = new Database();

$db = $database->getConnection();

// initialize object
$Booking = new Booking($db);

$CuiVe = new Cuive($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
// query products

if($data->start_time != null && $data->id_tuyen != null && $data->id_chuyen != null){
    $stmt = $Booking->getByParams($data->start_time, $data->id_tuyen, $data->id_chuyen);
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0 && $num < 2){
        // products array
        $Booking_item = null;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $Booking_item = array(
                "id" => $id,
                "start_time" => $start_time,
                "id_tuyen" => $id_tuyen,
                "id_chuyen" => $id_chuyen,
                "bus_type" => $bus_type,
                "id_cui_ve" => $id_cui_ve,
            );
        
        
        $CuiVe_arr = array();
        $CuiVe_arr["records"]=array();    
        $stmt = $CuiVe->getByParams($start_time,$id_tuyen,$id_chuyen);
        $num = $stmt->rowCount();
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
            extract($row1);
            $Model_item = array(
                "id" => $id,
                "start_time" => $start_time,
                "id_tuyen" => $id_tuyen,
                "id_chuyen" => $id_chuyen,
                "seat_num" => $seat_num,
                "label" => $label,
                "customer_info" => json_decode($customer_info),
                "status" => $status
            );
            array_push($CuiVe_arr["records"], $Model_item);
        }
        // set response code - 200 OK
        http_response_code(200);
        // show products data in json format
        echo json_encode($CuiVe_arr["records"]);

    }else{
        http_response_code(200);
        // show products data in json format
        echo json_encode(array("message" => '0'));
    }
    
}else{
    http_response_code(200);
    // show products data in json format
    echo json_encode(array("message" => '2'));
}

 
// no products found will be here