<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

?>

<html>
<head>
<title>Add a Prayer</title>
<script src="jquery.js"></script>

<script>
	$(document).ready(function(){		
	});
</script>
</head>
<body>
<h1> Add a new prayer</h1>
<form action="addprayer.php" method="post">
	
	<input type="radio" name="type" value="person" id="person" />
	<label for="person">Person</label>
	<br>
	
	<input type="radio" name="type" value="event" id="event" />
	<label for="event">Event</label>
	<br>
	<span id="form">
		<label for=name>Name</label><br>
		<input name=name type=test size=50 placeholder=name maxsize=250 required=true id=name />
		<br>
		<label for=detailsName>Details (Optional) </label><br>
		<textarea rows=5 cols=25 id=detailsName name=details></textarea>
	</span>

	<br>
	<input type=submit>
</form>

<hr>
<h3> A Person to Pray For:</h3> <p>

<?php

function GetDayFromFile($jsonp){
    if($jsonp[0] !== '[' && $jsonp[0] !== '{'){ 
       $jsonp = substr($jsonp, strpos($jsonp, '('));
    }
	$s = trim($jsonp,'();');
	$w = substr($s, (strpos($s, "\"day\"")+9), (strpos($s, "\"Mass_R1\"") - strpos($s, "\"day\"")-11) );
	$r = strip_tags($w);
	//echo $r;
	return $r;
}
$dayJsonp = file_get_contents('http://www.universalis.com/Europe.England/jsonpmass.js?callback=?');
$day = GetDayFromFile($dayJsonp);
echo "Received: ".$day;


/*

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
				return $results;
			}
		}
		
	function getResultsAssoc($results){
			if(!$results)
				return false;
			$data = array();
			while ($row = $results->fetch_assoc()){
				$data[] = $row;
			}
			return $data;
		}

	$cxn = createCxn();
	//Get a random row from the table
	$query = "SELECT COUNT('id') FROM `prayers`";
	$result = getResultsAssoc(runUpdateQuery($cxn, $query));
	$rows = $result[0]["COUNT('id')"];
	$row = rand() % $rows;
	
	//Get the data
	$query = "SELECT `name`, `details` FROM `prayers` WHERE `id`= ".$row;
	$result = getResultsAssoc(runUpdateQuery($cxn, $query));
	$result = $result[0];
	$msg = "Person: ".$result['name'];
	if( !empty($result['details']) )
		$msg .= "\n Details:".$result['details'];
	echo $msg;
	
	*/
/*



    AT&T – cellnumber@txt.att.net
    Verizon – cellnumber@vtext.com
    T-Mobile – cellnumber@tmomail.net
    Sprint PCS - cellnumber@messaging.sprintpcs.com
    Virgin Mobile – cellnumber@vmobl.com
    US Cellular – cellnumber@email.uscc.net
    Nextel - cellnumber@messaging.nextel.com
    Boost - cellnumber@myboostmobile.com
    Alltel – cellnumber@message.alltel.com

	
	
*/


?>
</p>
</body>
</html>