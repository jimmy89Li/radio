<?php
//<description>
//This endpoint contains radio methods.
//</description>

if($_SERVER["REQUEST_METHOD"]==='POST') { $method='POST'; }

//Methods for endpoint:
switch (strtolower($method))
{

  //GET method
  case "get":
  
    if(isset($id) && !empty($id))
    {
      if(isset($location)&&!empty($location))
      {
        $result = [];
        $sql = "SELECT location FROM {$endpoint} WHERE id='".$id."'";
        $rs = $mysqli->query($sql);
        if($rs->num_rows)
        {
          while($row = $rs->fetch_assoc())
          {
            $result[] = $row;
          }
        }
        else
        {
          $result = "Target not found!";
        }
        $output = array("status"=>1, "msg"=>$result);
      }
      else
      {
        $result = [];
        $sql = "SELECT * FROM {$endpoint} WHERE id='".$id."'";
        $rs = $mysqli->query($sql);
        if($rs->num_rows)
        {
          while($row = $rs->fetch_assoc())
          {
            $result[] = $row;
          }
        }
        else
        {
          $result = "Target not found!";
        }
        $output = array("status"=>1, "msg"=>$result);
        // $output = array("status"=>1, "msg"=>"GET all info for id:".$id);
      }
    }
    else
    {
      $output = array("status"=>-1, "msg"=>"Invalid target! Please specify a radio ID!");
    }
    break;

  //POST method
  case "post":

    $output = array("status"=>1, "msg"=>"POST");
    break;

  //Default method
  default:
    $output = array("status"=>-1, "msg"=>"Unknown method: ".$method);

}
echo json_encode($output);