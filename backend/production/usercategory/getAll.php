<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// database connection will be here
// include database and object files
include_once '../../database.php';
include_once './userCategoryModel.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user_category = new UserCategory($db);
try {
// query products
$stmt = $user_category->getAll();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    
    // products array
    $user_category_arr=array();
    $user_category_arr["records"]=array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $user_category_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "date_create" => $date_create
        );
        array_push($user_category_arr["records"], $user_category_item);
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($user_category_arr["records"]);
}
}catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => 0));
}
// no products found will be here