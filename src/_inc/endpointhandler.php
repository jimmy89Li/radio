<?php
//Check if the endpoint is a valid endpoint - i.e. does the endpoint file exist?
if (file_exists("_endpoints/".$endpoint.".endpoint.php") && is_readable("_endpoints/".$endpoint.".endpoint.php")) {
    //Include endpoint
    include_once "_endpoints/".$endpoint.".endpoint.php";
} else {
    $output = array("status"=>-1, "msg"=>"Invalid endpoint: '".$endpoint."'");
    return json_encode($output);
}