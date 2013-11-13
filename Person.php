<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Person{
	public $UserId;
	public $carrier;
	public $number;
	public $timezone;
	private $database;
	
	function __construct($id){
		$this->database = new Database();
		$this->_LoadUserFromId($id);
	}
	private function _LoadUserFromId($UserId){
		$query = "SELECT * FROM `".PrayerEng::USERS."` WHERE `Id` = ".$UserId;
		if(!$this->database->runQuery($query))
				return false;
		if ($this->database->numRows > 0){
			$results = $this->database->getFirstResult();
			$this->UserId = $UserId;
			$this->carrier = $results["Carrier"];
			$this->number = $results["Number"];
			$this->timezone = $results["Timezone"];
			return true;
		}else {
			return false;
		}
	}
	
	public function GetUsersTime($time = "now"){
		$timezone = new DateTimeZone(timezone_name_from_abbr($this->timezone));
		$date = new DateTime($time, $timezone);
		return $date->format("H");
	}
	public function GetUserDate($time = "now"){
		$timezone = new DateTimeZone(timezone_name_from_abbr($this->timezone));
		$date = new DateTime($time, $timezone);
		return $date->format("Y-m-d");
	}
	public function ScriptsToRun($hour = "now"){
		if(!isset($hour) || !is_numeric($hour)){
			$hour = $this->GetUsersTime();
		}
		$query = "SELECT `Task` FROM `".PrayerEng::SCHEDULE. "` WHERE `Hour` = ".$hour." AND `UserId` = ".$this->UserId;
		if(!$this->database->runQuery($query))
				return false;
		if ($this->database->numRows > 0){
			$results = $this->database->getResultsAssoc();
			$tasks = array();
			foreach($results as $r){
				$tasks[] = $r['Task'];
			}
			return $tasks;
		}else {
			return false;
		}
	}
	public function SendTextMsg($subject, $msg){
		$to      = $this->number.'@'.$this->carrier;
		$subject = $subject;
		$message = $msg;
		mail($to, $subject, $message, null, '-fprayer@joesboxoftricks.com');
	}
	//-----------------------------------------------------------
	//------------------- Private   -----------------------------
	//-----------------------------------------------------------

}

?>
