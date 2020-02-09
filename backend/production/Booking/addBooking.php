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
include_once '../CuiVe/Model.php';
include_once '../ChuyenXe/Model.php';
include_once '../Car/carModel.php';
include_once '../Label/Model.php';
$database = new Database();
$db = $database->getConnection();
$Booking = new Booking($db);
$CuiVe = new Cuive($db);
$Chuyen =  new Chuyen($db);
$Car =  new Car($db);
$Label40 =  new label40($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
if(
    !empty($data->start_time)||
    !empty($data->id_tuyen)||
    !empty($data->id_chuyen)
){

    $xe = 0;
    $type= 0;
    $stmt = $Chuyen->getOneByID($data->id_chuyen);
    $num = $stmt->rowCount();
    
    // check if more than 0 record found
    if($num > 0 && $num < 2 ){
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $xe = $id_xe;

    }else{
        // set response code - 201 created
        http_response_code(200);
        // tell the user
        echo json_encode(array("message" => 10));
        return false;
    }
    $stmt = $Car->getOneByID($xe);
    $num = $stmt->rowCount();
    //echo $xe;die;
    // check if more than 0 record found
    if($num > 0 && $num < 2 ){
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $type = $number_of_seats;

    }else{
        // set response code - 201 created
        http_response_code(200);
        // tell the user
        echo json_encode(array("message" => 10));
        return false;
    }
    $Booking->start_time = $data->start_time;
    //echo($data->start_time);die;
    $Booking->id_xe = $xe;
    $Booking->id_tuyen = $data->id_tuyen;
    $Booking->id_chuyen = $data->id_chuyen;
    $Booking->bus_type = $type;
    //var_dump($Booking);die;
    if($Booking->create()){
        // create the product
        $CuiVe->start_time = $data->start_time;
        $CuiVe->id_tuyen = $data->id_tuyen;
        $CuiVe->id_chuyen = $data->id_chuyen;
        $stmt_label = $Label40->getAll();
        $num_label = $stmt_label->rowCount();
        if($num_label > 0){
            for ($i = 1; $i <= $type; $i++) {
                $row = $stmt_label->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $CuiVe->seat_num = $i;
                $CuiVe->label =  $label;
    
                if($CuiVe->create()){
                }
                // if unable to create the product, tell the user
                else{
                    // set response code - 503 service unavailable
                    http_response_code(200);
                    // tell the user
                    echo json_encode(array("message" => 3));
                    return false;
                }
            }
        }else{
            // set response code - 503 service unavailable
            http_response_code(200);
            // tell the user
            echo json_encode(array("message" => 4));
        }
        
        
    }else{
        http_response_code(200);
        echo json_encode(array("message" => 2));
    }
    http_response_code(200);
    echo json_encode(array("message" => 1));   
}
else{
    http_response_code(200);

    echo json_encode(array("message" => 0));
}
?>