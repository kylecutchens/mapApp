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

		<button id='directions' class='utilityButton' data='directionsDiv'>
			<div class='infoBox'>
				<h2>Directions</h2>
			</div>
			<img class='buttonIcon' src='images/icons/directions.png' alt='Directions'>
		</button>

		<button id='filters' class='utilityButton' data='filtersDiv'>
			<div class='infoBox'>
				<h2>More Filters</h2>
			</div>
			<img class='buttonIcon' src='images/icons/filters.png' alt='More Filters'>
		</button>

		<button id='accessibility' class='utilityButton' data='accessibilityDiv'>
			<div class='infoBox'>
				<h2>Accessibility</h2>
			</div>
			<img class='buttonIcon' src='images/icons/accessibility.png' alt='Accessibility Info'>
		</button>

		<button id='resources' class='utilityButton' data='resourcesDiv'>
			<div class='infoBox'>
				<h2>More Resources</h2>
			</div>
			<img class='buttonIcon' src='images/icons/resources.png' alt='More Resources'>
		</button>

		<button id='information' class='utilityButton' data='informationDiv'>
			<div class='infoBox'>
				<h2>About</h2>
			</div>
			<img class='buttonIcon' src='images/icons/more.png' alt='About'>
		</button>

	</div>


	<div class='utilityDiv-holder'>

		<div class='utilityDiv' id='directionsDiv'>

			<img class='closeButton' data='directionsDiv' src='images/icons/close.png'>

			<h3>Directions</h3>

			<div style='position:absolute'>
				<input type='text' class='textInput directionsBar' id='originBar' data='originDisplay' placeholder="Enter Starting Point">
				<div class='display' id='originDisplay'></div>
			</div>

			<div style='position:absolute; bottom:30px'>
				<input type='text' class='textInput directionsBar' id='destBar' data='destDisplay' placeholder="Enter Destination">
				<div class='display' id='destDisplay'></div>
			</div>

		</div>

		<div class='utilityDiv' id='filtersDiv'>

			<img class='closeButton' data='filtersDiv' src='images/icons/close.png'>

		</div>

		<div class='utilityDiv' id='accessibilityDiv'>

			<img class='closeButton' data='accessibilityDiv' src='images/icons/close.png'>

		</div>

		<div class='utilityDiv' id='resourcesDiv'>

			<img class='closeButton' data='resourcesDiv' src='images/icons/close.png'>

		</div>

		<div class='utilityDiv' id='informationDiv'>

			<img class='closeButton' data='informationDiv' src='images/icons/close.png'>

		</div>

	</div>


	<div id='detailsBar' class='detailsBar'>

		<div>

			<div><img class=img-holder id='locationImage' src=''></div>
			<button class='details-pane-close'>x</button>
			<div class='details-pane-title'></div>

		</div>

		<div class='details-pane-content'></div>
	</div>

    <div id='toolsBar' class='detailsBar details-pane-visible' style='width: 350px; opacity: 1'>



    </div>


	<script type="text/javascript" src="devScripts.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCA8OXkLqtVF7X51RpqSBL5MjTPZqTNdIo&v=beta&callback=myMap"> </script>

</body>

</html>