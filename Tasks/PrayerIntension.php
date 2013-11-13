<?php
class PrayerIntension{
	const TABLE = "PrayerIntension";
	
	protected $database;
	function __construct(){
		$this->database = new Database();
	}
	//---------------------- necessary functions -----------------------------
	public function Run(&$Person){
		$row = $this->_GetRandomRow($Person);
		$query = "SELECT `Intension`, `Details` FROM `".PrayerIntension::TABLE."` WHERE `Id`= ".$row;
		if(!$this->database->runQuery($query))
				return NULL;
		if ($this->database->numRows > 0){
			$results = $this->database->getFirstResult();
			echo "PrayerIntension: ".$results["Intension"];
			$msg = "Pray for: ".$results["Intension"];
			if (!empty($results["Details"])){
				$msg.=" --- ".$results["Details"];
			}
			$Person->SendTextMsg("PrayerIntension", $msg);
		} else {
			echo "Error! Db rows: ".$this->database->numRows;
			$Person->SendTextMsg("PrayerIntension", "Error Getting Intension to Prayer For");
		}
	}
	public function Insert($UserId, $Intension, $Details = "", $Type = "Person", $DateEnd = "" ){
		$query = "INSERT INTO `".PrayerIntension::TABLE."` (`UserId`, `Intension`, `Details`, `Type`, `DateEnd` )";
		$query.= "VALUES ('".$UserId."', '".$Intension."', '".$Details."', '".$Type ."', '".$DateEnd."')";
		$this->database->runUpdateQuery($query);
	}
	//-------------------------------- custom functions ------------------------------
	private function _GetRandomRow(&$Person){
		$query = "SELECT `Id` FROM `".PrayerIntension::TABLE."` WHERE `UserId` = ".$Person->UserId." OR `UserId` = -1";
		if(!$this->database->runQuery($query))
				return 1;
		if ($this->database->numRows > 0){
			$result = $this->database->getResultsAssoc();
			$row = rand() % ($this->database->numRows +1);
			$randId = $result[$row]['Id'];
			return $randId;
		} else {
			return 1;
		}		
	}
}
?>