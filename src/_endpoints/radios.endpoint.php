<?php
/* This endpoint contains radio methods. */

// Methods for endpoint:
switch (strtolower($method))
{

  // POST method
  case "post":
  
    // Check if the ID is given
    if(isset($id) && !empty($id))
    {
      // Check if the ID is in the correct format (numeric)
      if(is_numeric($id))
      {

        // Check if there are parameters sent
        if($parameters)
        {
          // Check if the location is set
          if($location)
          {
            // Location set - check for location parameter
            $err = [];
            if(sizeof($parameters)!=1)
            {
              $err = "Parameters amount incorrect!";
            }
            else
            {
              if(!array_key_exists("location",$parameters)) { $err[] = "location"; } else { $radioLocation = $parameters["location"]; }
            }

            // If no errors - proceed on setting the radio location
            if(empty($err))
            {
              // Check if radio ID exists
              $getSQL = "SELECT * FROM radios WHERE id='{$id}'";
              $getRadio = $mysqli->query($getSQL);
              if($getRadio->num_rows)
              {
                // Check if location is allowed
                $allowedLocations = explode(",",$getRadio->fetch_assoc()["allowed_locations"]);
                if(in_array("\"".$radioLocation."\"",$allowedLocations))
                {
                  // Location allowed - set radio location
                  $setLocSQL = "UPDATE radios SET location='{$radioLocation}' WHERE id='{$id}'";
                  $setLoc = $mysqli->query($setLocSQL);
                  if($setLoc)
                  {
                    $output = array("status"=>"200 OK","msg"=>"Location set: " . $radioLocation);
                  }
                  else
                  {
                    $output = array("status"=>-1,"msg"=>"Failed to set location!");
                  }
                }
                else
                {
                  // Location not allowed !
                  $output = array("status"=>"403 FORBIDDEN","msg"=>"Location ".$radioLocation." not allowed!");
                  // echo 'Location: ' . $radioLocation . ' NOT allowed!';
                }
                // print_r($allowedLocations);
                // die;
              }
              else
              {
                $output = array("status"=>-1,"msg"=>"Radio ID: " . $id . " does not exist!");
              }
            }
            else
            {
              $output = array("status"=>-1,"msg"=>$err);
            }
          }
          else
          {
            // Location is not given - check for alias and allowed_locations parameters
            $err = [];
            if(sizeof($parameters)!=2)
            {
              $err[] = "Parameters amount incorrect!";
            }
            else
            {
              if(!array_key_exists("alias",$parameters)) { $err[] = "alias"; } else { $radioAlias = $parameters["alias"]; }
              if(!array_key_exists("allowed_locations",$parameters)) { $err[] = "allowed_locations"; } else { $radioAllowerLocations = "\"" . implode("\",\"",$parameters["allowed_locations"]) . "\""; }
            }

            // If no errors - proceed on setting the radio details
            if(empty($err))
            {
              // Check if radio already exists
              $checkSQL = "SELECT * FROM radios WHERE id='{$id}'";
              $checkID = $mysqli->query($checkSQL);
              if($checkID->num_rows)
              {
                // Product already exists - update required
                $sql = "UPDATE radios SET alias='{$radioAlias}' , allowed_locations='{$radioAllowerLocations}' WHERE id='{$id}'";
                $updateRadio = $mysqli->query($sql);
                if($updateRadio)
                {
                  $output = array("status"=>"200 OK","msg"=>array("alias"=>$radioAlias,"allowed_locations"=>$radioAllowerLocations));
                }
                else
                {
                  $output = array("status"=>-1,"msg"=>"Radio update failed!");
                }
              }
              else
              {
                // Product does not exists - creating required
                $sql = "INSERT INTO radios SET id='{$id}', alias='{$radioAlias}' , allowed_locations='{$radioAllowerLocations}' ";
                $createRadio = $mysqli->query($sql);
                if($createRadio)
                {
                  $output = array("status"=>"200 OK","msg"=>array("alias"=>$radioAlias,"allowed_locations"=>$radioAllowerLocations));
                }
                else
                {
                  $output = array("status"=>-1,"msg"=>"Radio creation failed!");
                }
              }
            }
            else
            {
              $output = array("status"=>-1,"msg"=>"Invalid parameters: " . implode(", ",$err) . " !");
            }
          }
        }
        else
        {
          $output = array("status"=>-1,"msg"=>"Invalid parameters!");
        }

      }
      else
      {
        $output = array("status"=>-1,"msg"=>"Invalid ID format!");
      }
    }
    else
    {
      $output = array("status"=>-1, "msg"=>"Invalid target! Please specify a radio ID!");
    }
    break;

  // GET method
  case "get":
  
    if(isset($id) && !empty($id))
    {
      if(isset($location)&&!empty($location))
      {
        $result = '';
        $sql = "SELECT location FROM {$endpoint} WHERE id='".$id."'";
        $rs = $mysqli->query($sql);
        if($rs->num_rows)
        {
          // Check if location exists
          $result = $rs->fetch_assoc()["location"];
          if($result!==null)
          {
            $output = array("status"=>"200 OK", "msg"=>"Location: ".$result);
          }
          else
          {
            $output = array("status"=>"404 NOT FOUND", "msg"=>"Location not available!");
          }
          // while($row = $rs->fetch_assoc())
          // {
          //   $result = $row;
          // }
        }
        else
        {
          $output = array("status"=>"200 OK", "msg"=>"Target not found!");
        }
      }
      else
      {
        $result = [];
        $sql = "SELECT alias,location FROM {$endpoint} WHERE id='".$id."'";
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
        $output = array("status"=>"200 OK", "msg"=>$result);
        // $output = array("status"=>1, "msg"=>"GET all info for id:".$id);
      }
    }
    else
    {
      $output = array("status"=>-1, "msg"=>"Invalid target! Please specify a radio ID!");
    }
    break;

  // Default method
  default:
    $output = array("status"=>-1, "msg"=>"Unknown method: ".$method);

}
echo json_encode($output);