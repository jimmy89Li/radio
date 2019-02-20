<?php
//Errorhandling
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Set timezone
date_default_timezone_set("Europe/Copenhagen");

//Set header
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

//Rewrite handling
$request = explode("/",$_SERVER["REQUEST_URI"]);
array_shift($request);

$method = (count($request)>0) ? strtolower($request[0]) : '';
$endpoint = (count($request)>1) ? strtolower($request[1]) : '';
$id = (count($request)>2 && is_numeric($request[2])) ? $request[2] : '';
if(strpos($id,"?")) { $id = explode("?",$id)[0]; }
$location = (count($request)>3 && strpos($request[3],"location")!==false) ? strtolower($request[3]) : '';
if(strpos($location,"?")!==false) { $location = explode("?",$location)[0]; }
$parms = $_SERVER["QUERY_STRING"] ? $_SERVER["QUERY_STRING"] : '';
$parameters = (file_get_contents("php://input")) ? json_decode(file_get_contents("php://input"),true) : array();

if(isset($endpoint) && !empty($endpoint))
{
  // Includes
  include_once "_inc/db.php";
  include_once "_inc/endpointhandler.php";
}
else
{
  echo json_encode(array("status"=>-1, "msg"=>"Method specification invalid! Access API methods via: /METHOD/ENDPOINT/TARGET (ie: /GET/radios/100)"));
}
