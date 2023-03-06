<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../config/database.php';
include_once '../../models/city.php';

$database = new Database();
$db = $database->getConnection();

$city = new City($db);
$data = json_decode(file_get_contents("php://input"));

$city->id = $data->id;

if($city->delete()){

    http_response_code(200);

    echo json_encode(array("message" => "Data deleted. I wonder if it was important."), JSON_UNESCAPED_UNICODE);

} 

else {

    http_response_code(503);

    echo json_encode(array("message" => "Data could not be deleted. Maybe you saved utterly important data."), JSON_UNESCAPED_UNICODE);
}

?>
