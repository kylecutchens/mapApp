<?php 

//code for putting up/taking down markers on the fly

    $con = new mysqli('localhost', 'root', 'xXdBLnejWq3h9s', 'mapApp');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $input = $_POST['input'];

    if (isset($input)){

        $filterQuery = $con -> query("SELECT bcode FROM coordinates WHERE bname LIKE '%". $input ."%'");

       while($row = mysqli_fetch_assoc($filterQuery)){
           $r[] = $row['bcode']; 
       }}
    else 
    echo "query failed";

    echo json_encode($r);
?>