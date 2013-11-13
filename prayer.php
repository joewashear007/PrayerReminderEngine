<?php
function __autoload($class){
	$class_lower = strtolower($class);
	$file = getWorkingDir().'/Tasks/'.$class.'.php';
	if(file_exists($file)){
		include_once $file;
	} else {
		$file = getWorkingDir().'/'.$class.'.php';
		if (file_exists($file)){
			include_once $file;
		}else{
			echo "Error: Can't Load: ".$class;
		}
	}
}
function getWorkingDir($htmlPath = false, $file = __FILE__ ){
	$dir			= dirname($file).'/';
	if($htmlPath){
		$rootLenght = strlen($_SERVER['DOCUMENT_ROOT']);
		$dir		= substr($dir, $rootLenght);
	}
	return $dir;
}

// include_once "/home2/jjprogra/public_html/pray/database.php";
// include_once "/home2/jjprogra/public_html/pray/person.php";
// include_once "/home2/jjprogra/public_html/pray/Tasks/SaintOfTheDay.php";
// include_once "/home2/jjprogra/public_html/pray/Tasks/PrayerIntension.php";

function getGET($name){
	if(isset($_GET[$name]))
		return $_GET[$name];
	else 
		return null;
}
function getPOST($name){
	if(isset($_POST[$name]))
		return $_POST[$name];
	else 
		return null;
}

class PrayerEng
{
// //Table Names and Task Names
	// const SAINT_OF_THE_DAY = "SaintOfTheDay";
	// const PRAYER_INTENSION = "PrayerIntension";
	// const GOALS = "Goals";
	const SCHEDULE = "Schedule";
	const USERS = "Users";
	// const EXAM	= "Exam";
	// const VIRTUE_VICE = "VirtuesAndVices";
	// const DAILY_CHALLENGE = "DailyChallenge";
	// const CARRIER = "vtext.com" ;
	
	protected $database;
	// protected $UsersToRun;
	// protected $Number;
	// protected $User; 
	public $UserId; 
	public $CurrentDate;
	public $CurrentPerson;
	
	function __construct() {
		$cxnInfo = array(
		"host" => "localhost",
		"user" => "jjprogra_prayers",
		"pass" => "JJPRO_prayers",
		"db" => "jjprogra_prayers" );

		$this->database	= new Database();
		$this->database->setCxn($cxnInfo);
		
		
		// $Number = "";
		// $User = ""; 
		// $Timezone = "";
	} 
	public function Run(){
		$this->UsersToRun = $this->_LoadUsers();
		//print_r($this->UsersToRun);
		foreach($this->UsersToRun as $User){
			$this->CurrentPerson = $User;
			$tasks = $this->CurrentPerson->ScriptsToRun();
			print_r($tasks);
			if(getGET("test")){
				$tasks[] = getGET("test");
			}
			if($tasks){
				foreach($tasks as $task){
					echo "Running: ".$task;
					try{
						$t = new $task();
						$t->Run($this->CurrentPerson);
					}catch(Exception $e){
						echo "Error!: Class ".$Task." Doesn't Exsit";
					}
				}
			}else{
				echo "No task to Run!";
			}
		}
	}
	private function _LoadUsers(){
		$query = "SELECT `Id` FROM `".PrayerEng::USERS."`";
		if(!$this->database->runQuery($query))
				return false;
		if ($this->database->numRows > 0){
			$results = $this->database->getResultsAssoc();
			$users = array();
			foreach($results as $user){
				//print_r( $user);
				$users[$user["Id"]] = new Person($user["Id"]);
			}
			return $users;
		}else {
			return false;
		}
	}

//---------------------------------------------------------------------------------------------------
// --------------------------------- TASKS ----------------------------------------------------------
//---------------------------------------------------------------------------------------------------	

	public function Exam(){
		$msg = '<a href="jjprograms.com/pray/exam.php?='.$this->CurrentDate.'"&UserId='.$this->UserId.'>Daily Exam</a>';
		$this->_sendTextMsg("Daily Exam", $msg);
	}

	//---------------------------------------------------------------------------------------
	//----------------------------------------- Examination ---------------------------------
	//---------------------------------------------------------------------------------------
	
	public function GetVirtueAndViceList($virtue){
		$query = "SELECT * FROM `".PrayerEng::VIRTUE_VICE."` WHERE `Virtue` = ".$virtue;
		if(!$this->database->runQuery($query))
				return false;
		if ($this->database->numRows > 0){
			$results = $this->database->getResultsAssoc();
			return $results;
		}else {
			return false;
		}
	}
	
	
}
