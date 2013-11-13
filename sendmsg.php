<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


include_once "/home2/jjprogra/public_html/pray/prayer.php";
$PE = new PrayerEng();
//$PE->SaintOfTheDay();
//$PE->PersonOfTheDay();



$PE->Run();

?>