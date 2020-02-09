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
    $stmt = $Booking->getOneByID($data->id);
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // products array
        $Booking_arr=array();
        $Booking_arr["records"]=array();
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
            $Booking_item = array(
                "id" => $id,
                "flag" => $flag,
                "date" => $date,
                "time" => $time,
                "type_of_car_id" => $type_of_car_id,
                "customer_name" => $customer_name,
                "customer_phone" => $customer_phone,
                "arrival_place_id" => $arrival_place_id,
                "departure_place_id" => $departure_place_id,
                "NCC_id" => $NCC_id,
                "partner_id" => $partner_id,
                "pickup_place" => $pickup_place,
                "place_of_guest" => $place_of_guest,
                "proceeds" => $proceeds,
                "proceeds_currency" => $proceeds_currency,
                "revenue" => $revenue,
                "revenue_currency" => $revenue_currency,
                "profit" => $profit,
                "note" => $note,
                "user_id" => $user_id,
                "partner" => $partner,
                "cost" => $cost,
                "car_of_supplier" => $car_of_supplier

            );
            array_push($Booking_arr["records"], $Booking_item);
        }
        // set response code - 200 OK
        http_response_code(200);
        // show products data in json format
        echo json_encode($Booking_arr["records"]);
    }else{
        http_response_code(200);
        echo json_encode(array("message" => 0));
    }
}else{
    http_response_code(200);
    echo json_encode(array("message" => 0));
}

?>