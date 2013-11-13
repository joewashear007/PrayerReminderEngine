<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once "/home2/jjprogra/public_html/pray/prayer.php";
$PE = new PrayerEng();

$virtues = $PE->GetVirtueAndViceList(1);
$vices = $PE->GetVirtueAndViceList(0);

$UserId = 1;
$timezone = new DateTimeZone(timezone_name_from_abbr("EST"));
$dateObj = new DateTime("now", $timezone);
$date = $dateObj->format("Y-m-d");


?>
<html>
	<head>
		<title>Examination of Conscience</title>
		<meta http-equiv="Content-Type"   content="text/html; charset=utf-8" />
		<script>
		function getQueryParams(qs) {
			qs = qs.split("+").join(" ");
			var params = {},
				tokens,
				re = /[?&]?([^=]+)=([^&]*)/g;

			while (tokens = re.exec(qs)) {
				params[decodeURIComponent(tokens[1])]
					= decodeURIComponent(tokens[2]);
			}

			return params;
		}

		var $_GET = getQueryParams(document.location.search);
		</script>
	</head>
	<body>
		<form action="exam.php" method="get">
		<h2>Vice List</h2>
		<?php
			foreach($vices as $vice){
				echo "<div class=vice>";
				echo '<input type=checkbox class=viceitem id="'.$vice["Name"].'" value="'.$vice["Id"].'">';
				echo '<label for="'.$vice["Name"].'">'.$vice["Name"].'</label>';
				echo "</div>";
			}
		?>
		<h2>Virtue List</h2>
		<?php
			foreach($virtues as $virtue){
				echo "<div class=virtue>";
				echo '<input type=checkbox class=virtueitem id="'.$virtue["Name"].'" value="'.$virtue["Id"].'">';
				echo '<label for="'.$virtue["Name"].'">'.$virtue["Name"].'</label>';
				echo "</div>";
			}
		?>
		<input type=Submit>
		</form>
	</body>
</html>