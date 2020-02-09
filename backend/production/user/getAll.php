<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// database connection will be here
// include database and object files
include_once '../../database.php';
include_once './userModel.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$User = new User($db);

// query products
$stmt = $User->getAll();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    
    // products array
    $users_arr=array();
    $users_arr["records"]=array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $user_item = array(
            "id" => $id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "phone" => $phone,
            "address" => $address,
            "department" => $department,
            "user_category" => $user_category,
            "username" => $username,
        );
        array_push($users_arr["records"], $user_item);
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($users_arr["records"]);
}
 
// no products found will be here