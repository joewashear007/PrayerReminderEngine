<?php
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
	
	$name = $_POST['name'];
	$details = $_POST['details'];
	$type = $_POST['type'];
	if (strlen($name) < 1){
		echo "There is no name given!!! Quiting";
		exit();
	}
	$query = "INSERT INTO `Prayers` (`name`, `details`, `type`) 
VALUES ('".$name."','".$details."','".$type."')";
	$cxn = createCxn();
	if(!$cxn){
		echo "Can't create Connection! Quitting";
		exit();
	}
	if( !runUpdateQuery($cxn, $query) ){
		echo "Failed to run query! Quitting";
		exit();
	}
	
	echo "<h1>Success!</h1><p>The prayer has been added to the database!</p>";

?>
