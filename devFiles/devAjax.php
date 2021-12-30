<?php 

    $con = new mysqli('localhost', 'root', 'xXdBLnejWq3h9s', 'mapApp');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_POST['name'])){

        $operation = $_POST['selection'];
        $name = $_POST['name'];
        $code = $_POST['bcode'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];

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

            case 'edit':
                $editQuery = $con -> query(
                    "UPDATE coordinatesTest 
                     SET bname = '$name' bcode = '$code' description = '$description' image = '$image' lat = '$lat' lon = '$lon'
                     WHERE bcode = $bcode");
                if($editQuery){
                    echo "New Record Created Successfully";
                }
                else{
                    echo "New Record Failed";
                }
                break;

            case 'delete':
                echo "Don't try to delete my shit, man";
                break;

        }

    }
    else
    {
        echo 'Query Failed';
    }



?>
