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
include_once './carModel.php';
 
$database = new Database();
$db = $database->getConnection();
 
$Car = new Car($db);
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)){
    // query products
    $stmt = $Car->getOneByID($data->id);
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // products array
        $Car_arr=array();
        $Car_arr["records"]=array();
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
            $Car_item = array(
                "id" => $id,
                "description" => $description,
                "license_plates" => $license_plates,
                "number_of_seats" => $number_of_seats
            );
            array_push($Car_arr["records"], $Car_item);
        }
        // set response code - 200 OK
        http_response_code(200);
        // show products data in json format
        echo json_encode($Car_arr["records"]);
    }else{
        http_response_code(404);
        echo json_encode(array("message" => 0));
    }
}

?>