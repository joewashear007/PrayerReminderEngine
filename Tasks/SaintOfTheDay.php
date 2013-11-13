<?php

class SaintOfTheDay{
	const TABLE = "SaintOfTheDay";
	
	protected $database;
	function __construct(){
		$this->database = new Database();
	}
	//---------------------- necessary functions -----------------------------
	public function Run(&$Person){
		$saint = $this->_checkSaintoftheDay();
		if (!$saint){
			$saint = $this->_fetchSaintoftheDay();
			$this->_insertSaintoftheDay($saint);
		}
		$Person->SendTextMsg("Saint of the Day", $saint);
	}
	public function Insert(){
	
	}
	//--------------------- custom functions ------------------------------
	private function _checkSaintoftheDay(){
		$today = date("Y-m-d");
		$query = "SELECT `Saint` FROM `".SaintOfTheDay::TABLE."` WHERE `Date` = '".$today."'";
		if(!$this->database->runQuery($query))
				return false;
		if ($this->database->numRows > 0){
			$result = $this->database->getFirstResult();
			return $result["Saint"];
		}else {
			return false;
		}
	}
	private function _fetchSaintoftheDay(){
		$jsonp = file_get_contents('http://www.universalis.com/Europe.England/jsonpmass.js?callback=?');
		if($jsonp[0] !== '[' && $jsonp[0] !== '{'){ 
		   $jsonp = substr($jsonp, strpos($jsonp, '('));
		}
		$s = trim($jsonp,'();');
		$w = substr($s, (strpos($s, "\"day\"")+9), (strpos($s, "\"Mass_R1\"") - strpos($s, "\"day\"")-11) );
		$saint = strip_tags($w);
		$saint = trim(preg_replace("/&#?[a-z0-9]+;/i", "", $saint));
		return $saint;
	}
	private function _insertSaintoftheDay($value){
		$query = "INSERT INTO `".SaintOfTheDay::TABLE."` (`Saint`, `Date`) VALUES ('".$value."', CURDATE())";
		$this->database->runUpdateQuery($query);
	}
}
?>