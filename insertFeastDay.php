<?php
/*
script to insert move 
VR lab demo - universioty of toledo
Joseph Livecchi

*/
function createCxn(){
	try {
		$cxn =  new mysqli("localhost", "jjprogra_prayers", "JJPRO_prayers", "jjprogra_prayers");
	} catch (exception $e){
		echo $e->getMessage();
	}
	if (!$cxn) {
		echo  'Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error();
		return FALSE;
	} else return $cxn;		
}
function runUpdateQuery($cxn, $query){
	if ($cxn){
		$results = $cxn->query($query);
		if (!$results) {
			echo ("FAIL");
			echo ('Invalid query: ' . $cxn->error . "\n");
			echo ('<br>Whole query: ' . $query);
			return FALSE;
		}
		$numRows = $cxn->affected_rows;
		return $numRows;
	}
}

if( !array_key_exists('feast', $_GET) ){
	echo "Error the information does not exist!";
	exit();
}
if( empty($_GET['feast'])){
	echo "Error there is no information giving!";
	exit();
}


$feast = $_GET['feast'];
//print_r($_GET);

if( strlen($feast) < 1){
	echo "Error, There was something wrong with your input. Please try again";
	exit();
}
$query = "INSERT INTO `SaintoftheDay` (`Saint`, `Date`) VALUES ('".$feast."', CURDATE())";
$cxn = createCxn();
if(!$cxn){
	echo "Can't create Connection! Quitting";
	exit();
}
if( !runUpdateQuery($cxn, $query) ){
	echo "Failed to run query! Quitting";
	exit();
}

echo "<h1>Success!</h1><p>The move has been added!</p>";


?>