<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// database connection will be here
// include database and object files
include_once '../../database.php';
include_once './bookingModel.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Booking = new Booking($db);

// query products
$stmt = $Booking->getAll();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    
    // products array
    $Bookings_arr=array();
    $Bookings_arr["records"]=array();
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
            "type_of_car" => $type_of_car,
            "customer_name" => $customer_name,
            "customer_phone" => $customer_phone,
            "arrival_place" => $arrival_place,
            "departure_place" => $departure_place,
            "pickup_place" => $pickup_place,
            "place_of_guest" => $place_of_guest,
            "NCC" => $NCC,
            "proceeds" => $proceeds,
            "proceeds_currency" => $proceeds_currency,
            "revenue" => $revenue,
            "revenue_currency" => $revenue_currency,
            "profit" => $profit,
            "partner" => $partner,
            "seller" => $seller,
            "note" =>  $note,
            "user_id" => $user_id,
            "date_create" => $date_create,
            "date_update" => $date_update,
            "arrival_place_id" => $arrival_place_id,
            "departure_place_id" => $departure_place_id,
            "NCC_id" => $NCC_id,
            "partner_id" => $partner_id,
            "type_of_car_id" => $type_of_car_id
        );
        array_push($Bookings_arr["records"], $Booking_item);
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($Bookings_arr["records"]);
}else{
    $NCCs_arr["records"]=array();
    http_response_code(200);
    echo json_encode($NCCs_arr["records"]);
}
 
// no products found will be here