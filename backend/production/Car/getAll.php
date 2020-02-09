<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// database connection will be here
// include database and object files
include_once '../../database.php';
include_once './carModel.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Car = new Car($db);

// query products
$stmt = $Car->getAll();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    
    // products array
    $Cars_arr=array();
    $Cars_arr["records"]=array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $Car_item = array(
            $id,
            $license_plates,
            $number_of_seats,
            $description
        );
        array_push($Cars_arr["records"], $Car_item);
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($Cars_arr["records"]);
}else{
    $NCCs_arr["records"]=array();
    http_response_code(200);
    echo json_encode($NCCs_arr["records"]);
}
 
// no products found will be here