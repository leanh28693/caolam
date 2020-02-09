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
 
$database = new Database();
$db = $database->getConnection();
 
$Model = new Chuyen($db);
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)){
    // query products
    $stmt = $Model->getOneByID($data->id);
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // products array
        $Model_arr=array();
        $Model_arr["records"]=array();
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
            $Model_item = array(
                "id" => $id,
                "id_tuyen" => $id_tuyen,
                "id_xe" => $id_xe,
                "start_time" => $start_time
            );
            array_push($Model_arr["records"], $Model_item);
        }
        // set response code - 200 OK
        http_response_code(200);
        // show products data in json format
        echo json_encode($Model_arr["records"]);
    }else{
        http_response_code(404);
        echo json_encode(array("message" => 0));
    }
}

?>