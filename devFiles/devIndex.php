<!DOCTYPE html>
<html lang='en'>

<head>

	<title> Mercer University Campus Map </title>

	<header class="header">


		<link rel="stylesheet" type="text/css" href="devStyle.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>


		<!-- defunct code for directions search bar. Use only for reference

		<div class="col" style='background-color: lightgrey'>
			<p id='input'> Please Enter Origin Location </p>
			  
			<input type="text" autocomplete="off" id="search" placeholder="Select Origin" />
			<br>
			<input type='button' id='confirm' value='Confirm Location'>
			<br />
			
			<div id="display"></div>
			<div id='message'></div>



			<div class="col" style='background-color: white'>
				<p id='input'> Please Enter Destination Location </p>

				<input type="text" autocomplete="off" id="search2" placeholder="Select Destination" />
				<br>
				<input type='button' id='confirm2' value='Confirm Location'>
				<br />
				
				<div id="display2"></div>
				<div id='message2'></div>
			</div>

	--->


		<?php

		/*code for connecting to phpmyadmin database. */

		$con = new mysqli('localhost', 'root', 'xXdBLnejWq3h9s', 'mapApp');

		if ($con->connect_error) {
			die('could not connect to mySQL: ' . $con->connect_error);
		}

		$centerData = $con->query("SELECT * FROM coordinates WHERE bcode = 'UC'");

		if ($centerData) {
			$center = $centerData->fetch_assoc();
		} else
			die("SELECT CENTER FAILED");

		?>



		<?php

		global $con;

		function utf8ize($input)
		{

			if (is_array($input)) {
				foreach ($input as $k => $v) {
					$input[$k] = utf8ize($v);
				}
			} else if (is_string($input)) {
				return utf8_encode($input);
			}
			return $input;
		};

		$markerData = $con->query("SELECT * FROM coordinates ORDER BY indx");

		$r = array();
		$count = 0;

		while ($row = mysqli_fetch_assoc($markerData)) {

			$r[] = $row;
			$count = $count + 1;
		}

		?>

		<input type='text' style='z-index: 20;' class='filterBar textInput' id='filterbar' data='filterDisplay' placeholder='Search for buildings here'>
		<div class='display' style='z-index: 20;' id='filterDisplay'></div>

		<div style="display: none" id='totalCoords'><?php echo json_encode(utf8ize($r)); ?></div>
	</header>

<body>
	<div id="map" class='map'></div>

	<div id='toolsBar' class='detailsBar details-pane-visible' style='width: 35vh; opacity: 1; background-color:#333'>

		<div id='selector' class='selector'>

			<button class='selectorButton' data='insert'>Insert</button>
			<button class='selectorButton' data='edit'>Edit</button>
			<button class='selectorButton' data='delete'>Delete</button>

		</div>

		<div id='toolDiv'>

			<h3 class='formTitle'>Insert New Marker</h3>

			<div id='toolForm' class='form' data='insert'>

				<div class='preSelect'>
					<div class='textHolder'>
						<h1>Select Marker to Begin</h1>
					</div>
				</div>

				<input id='name' class='formBar' placeholder="Building Name">
				<input id='bcode' class='formBar' placeholder="Building Code">
				<textarea id='description' class='formBar' placeholder="Description"></textarea>
				<input id='image' class='formBar' placeholder="Image Location">
				<input id='lat' class='formBar' placeholder="Latitude">
				<input id='lon' class='formBar' placeholder="Longitude">

				<button class='submit'>Submit</button>

			</div>

		</div>

	</div>


	<script type="text/javascript" src="devScripts.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCA8OXkLqtVF7X51RpqSBL5MjTPZqTNdIo&v=beta&callback=myMap"> </script>

</body>

</html>