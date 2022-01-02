<?php 

    $con = new mysqli('localhost', 'root', 'xXdBLnejWq3h9s', 'mapApp');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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


        $Result = 'Query Failed';

         switch ($operation) {

                       
            case 'insert':
                
               $selectQuery = $con -> query("INSERT INTO `coordinatesTest` (`bname`, `bcode`, `description`, `image`, `lat`, `lon`, `indx`) VALUES ('$name', '$code', '$description', '$image', '$lat', '$lon', '$maxIndx');"); 
              // $selectQuery = 'piss and shit and also fuck';
                if($selectQuery){
                   echo "New Record Created Successfully ";
                }
                else{
                   echo 'Query Failed: ' .  mysqli_error($con);
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
                   echo 'Query Failed: ' .  mysqli_error($con);
                }
                break;

            case 'delete':
               echo "Don't try to delete my shit, man";
                break;
*/        

        } 

        echo 'Information Received: ' . $name . ', ' . $code . ', ' . $description . ', ' . $image . ', ' . $lat . ', ' . $lon . ', ' . $maxIndx;
        
            //}
  //  else
  //  {
 //      echo 'Query Failed: ' .  mysqli_error($con);
  //  }
