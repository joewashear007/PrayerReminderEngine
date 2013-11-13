<?php
class DailyChallenge{
	const TABLE = "DailyChallenge";
	
	protected $database;
	function __construct(){
		$this->database = new Database();
	}
	//---------------------- necessary functions -----------------------------
	public function Run(&$Person){
		$row = $this->_GetRandomRow($Person);
		$query = "SELECT `Id`, `Challenge`, `Details` FROM `".DailyChallenge::TABLE."` WHERE `Id`= ".$row;
		if(!$this->database->runQuery($query))
				return NULL;
		if ($this->database->numRows > 0){
			$results = $this->database->getFirstResult();
			echo "DailyChallenge: ".$results["Challenge"];
			$msg = "Challenge: ".$results["Challenge"];
			if (!empty($results["Details"])){
				$msg.=" --- ".$results["Details"];
			}
			$Person->SendTextMsg("DailyChallenge", $msg);
			$this->SetAsAttempted($Person, $results['Id']);
		} else {
			echo "Error! Db rows: ".$this->database->numRows;
			$Person->SendTextMsg("DailyChallenge", "Error Getting Daily Challenge");
		}
	}
	public function Insert($UserId, $Challenge, $Details = ""){
		$query = "INSERT INTO `".DailyChallenge::TABLE."` (`UserId`, `Challenge`, `Details` )";
		$query.= "VALUES ('".$UserId."', '".$Challenge."', '".$Details."')";
		$this->database->runUpdateQuery($query);
	}
	public static function GetAvailableArguments(){
		return array("Start", "Check");
	}
	public function SetAsAttempted(&$Person, $id){
		$query = "UPDATE `".DailyChallenge::TABLE."` SET `LastGiven` = '".$Person->GetUserDate();
		$query.= "', `TimesAttempted` = `TimesAttempted`+1  WHERE `Id` = ".$id;
		$this->database->runUpdateQuery($query);
	}
	public function MarkAsComplete(&$Person){
		$query = "UPDATE `".DailyChallenge::TABLE."` SET `TimesComplete` = `TimesComplete`+1 WHERE `UserId` = ".$Person->UserId." AND `LastGiven` = ".$Person->GetUserDate();
		$this->database->runUpdateQuery($query);
	}
	//-------------------------------- custom functions ------------------------------
	private function _GetRandomRow(&$Person){
		$query = "SELECT `Id` FROM `".DailyChallenge::TABLE."` WHERE `UserId` = ".$Person->UserId." OR `UserId` = -1";
		if(!$this->database->runQuery($query))
				return 1;
		if ($this->database->numRows > 0){
			$result = $this->database->getResultsAssoc();
			$row = rand() % ($this->database->numRows );
			$randId = $result[$row]['Id'];
			return $randId;
		} else {
			return 1;
		}		
	}
}
?>