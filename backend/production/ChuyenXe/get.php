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

include_once './Model.php';

// instantiate database and product object
$database = new Database();

$db = $database->getConnection();

// initialize object
$Model = new Chuyen($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
// query products
//var_dump($data);die;
if($data->id_tuyen != null){
    $stmt = $Model->getByParam($data->id_tuyen);
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // products array
        $Models_arr=array();
        $Models_arr["records"]=array();
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
            extract($row);
            $Model_item = array(
                $id,
                $id_tuyen,
                $id_xe,
                $start_time
            
            );
            array_push($Models_arr["records"], $Model_item);
        }
        // set response code - 200 OK
        http_response_code(200);
        // show products data in json format
        echo json_encode($Models_arr["records"]);
    }else{
        http_response_code(200);
        $Models_arr=array();
        $Models_arr["records"]=array();
        echo json_encode($Models_arr["records"]);
    }
}else{
    http_response_code(200);
        // show products data in json format
        echo 'param didnt included';
}

 
// no products found will be here