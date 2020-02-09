<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// database connection will be here
// include database and object files
include_once '../database.php';
include_once '../register.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Register = new Register($db);

// query products
$stmt = $Register->readWinner();
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
            "name" => $name,
            "phone" => $phone,
            "birthday" => $row['birthday']
        );
        
        array_push($users_arr["records"], $user_item);
    }
    
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($users_arr["records"]);
}
 
// no products found will be here