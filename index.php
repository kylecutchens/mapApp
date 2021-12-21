<!DOCTYPE html>
<html lang='en'>

<head>

	<title> Mercer University Campus Map </title>

	<header class="header">


		<link rel="stylesheet" type="text/css" href="style.css">
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

		<div id='header-container' class='header-container'>

			<img class='logo' src='images/misc/logo.png' alt='Mercer University Logo'>

			<input type='text' class='filterBar textInput' id='filterbar' data='filterDisplay' placeholder='Search for buildings here'>
			<div class='display' id='filterDisplay'></div>


		</div>

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

		</div>


		<script> </script>
	</header>

<body>

	<div id='test'>

	</div>


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


	<div style="display: none" id='totalCoords'><?php echo json_encode(utf8ize($r)); ?></div>
	<input hidden id='coordinate' value='' />
	<input hidden id='coordinate2' value='' />







	<div id="map" class='map'></div>

	<div class='buttonHolder' id='buttonHolder'>

		<button id='directions' class='utilityButton'>
			<div class='infoBox'>

			<p>Directions</p>

			</div>
			<img class='buttonIcon' src='images/icons/directions.png' alt='Directions'>

		</button>


		<button id='filters' class='utilityButton'>
			<div class='infoBox'>

			<p>More Filters</p>

			</div>
			<img class='buttonIcon' src='images/icons/filters.png' alt='More Filters'>


		</button>


		<button id='accessibility' class='utilityButton'>
			<div class='infoBox'>

			<p>Accessibility</p>

			</div>
			<img class='buttonIcon' src='images/icons/accessibility.png' alt='Accessibility Info'>

		</button>


		<button id='resources' class='utilityButton'>
			<div class='infoBox'>

			<p>More Resources</p>

			</div>
			<img class='buttonIcon' src='images/icons/resources.png' alt='More Resources'>

		</button>


		<button id='information' class='utilityButton'>
			<div class='infoBox'>

			<p>About</p>

			</div>
			<img class='buttonIcon' src='images/icons/more.png' alt='About'>

		</button>



	</div>

	<div id='detailsBar' class='detailsBar'>

		<div>

			<div><img class=img-holder id='locationImage' src=''></div>
			<button class='details-pane-close'>x</button>
			<div class='details-pane-title'></div>

		</div>

		<div class='details-pane-content'></div>
	</div>

	<script type="text/javascript" src="scripts.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCA8OXkLqtVF7X51RpqSBL5MjTPZqTNdIo&v=beta&callback=myMap"> </script>

</body>

</html>