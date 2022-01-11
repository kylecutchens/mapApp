<?php 

        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $con = new mysqli('localhost', 'root', 'xXdBLnejWq3h9s', 'mapApp');
   
    //if(isset($_POST['name'])){

        $operation = $_POST['operation'];
        $name = $_POST['name'];
        $code = $_POST['bcode'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];

    //get the max index, convert to usable data, add 1
        $indx = $con -> query('SELECT MAX(indx) FROM coordinatesTest');
        $indx = $indx -> fetch_array();
        $maxIndx = intval($indx[0]);
        $maxIndx = $maxIndx + 1;


    if(isset($_POST['name'])){
         switch ($operation) {

                       
            case 'insert':
                
               $selectQuery = $con -> query("INSERT INTO `coordinatesTest` (`bname`, `bcode`, `description`, `image`, `lat`, `lon`, `indx`) $('$name', '$code', '$description', '$image', '$lat', '$lon', '$maxIndx');"); 
        
                if($selectQuery){
                   echo "New Record Created Successfully ";
                }
                else{
                   echo 'Query Failed: ' .  mysqli_error($con);
                }
                break;

            case 'edit':
                
                $editQuery = $con -> query(
                    "UPDATE `coordinatestest` 
                    SET `bname`='[$name]',`bcode`='[$code]',`description`='[$description]',`image`='[$image]',`lat`='[$lat]',`lon`='[$lon]' 
                    WHERE bcode = '[$bcode]'");

                if($editQuery){
                   echo "Record Updated Successfully";
                }
                else{
                   echo 'Query Failed: ' .  mysqli_error($con);
                }
                break;

            case 'delete':
               echo "Don't try to delete my shit, man";
                break;       

            echo 'Information Received: ' . $name . ', ' . $code . ', ' . $description . ', ' . $image . ', ' . $lat . ', ' . $lon . ', ' . $maxIndx;
            
         }
        }
        else{
            echo "Query Failed" . mysqli_error($con);
        }