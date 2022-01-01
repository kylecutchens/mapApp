<?php 

    $con = new mysqli('localhost', 'root', 'xXdBLnejWq3h9s', 'mapApp');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_POST['name'])){

        $operation = 'insert';
        $name = $_POST['name'];
        $code = $_POST['bcode'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];

        $Result = 'Query Failed';

         switch ($operation) {

                       
            case 'insert':
                
                $selectQuery = $con -> query("INSERT INTO coordinatesTest VALUES ($name, $code, $description, $image, $lat, $lon)");
                if($selectQuery){
                   echo "New Record Created Successfully";
                }
                else{
                   echo "New Record Failed";
                }
                break;
/*
            case 'edit':
                $editQuery = $con -> query(
                    "UPDATE coordinatesTest 
                     SET bname = '$name' bcode = '$code' description = '$description' image = '$image' lat = '$lat' lon = '$lon'
                     WHERE bcode = $bcode");
                if($editQuery){
                   echo "Record Updated Successfully";
                }
                else{
                   echo "New Record Failed";
                }
                break;

            case 'delete':
               echo "Don't try to delete my shit, man";
                break;
*/        

        }  

        echo 'Information Received: ' . $name . ', ' . $code . ', ' . $description . ', ' . $image . ', ' . $lat . ', ' . $lon;
        
    }
    else
    {
       echo 'Query Failed: ' .  mysqli_error($con);
    }



?>
