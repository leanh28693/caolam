<?php
// required headers
header("Access-Control-Allow-Origin: *");
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
$stmt = $Register->login();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    // get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->username)|| 
    !empty($data->password) 
){
    $user = $Register->readOne($data->username);
    if($user){
        if($user['password'] == $data->password){
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
                    "username" => $username,
                    "email" => $email,
                    "firstname" => $first_name,
                    "lastname" => $last_name,
                    "address" => $address,
                    "phone" => $phone,
                    "department" => $department,
                    "token" => $token
                );
                
                array_push($users_arr["records"], base64_encode(json_encode($user_item)));
            }
            
            // set response code - 200 OK
            http_response_code(200);
            // show products data in json format
            echo json_encode($users_arr["records"]);
        }else{
                http_response_code(200);
                echo json_encode(array("message" => 'password not correct'));
        }
    }else{
        echo json_encode(array("message" => 'user not defined'));
    }
}else{
    http_response_code(404);
    echo json_encode(array("message" => 'user or pass not correct'));
}
}
 
// no products found will be here