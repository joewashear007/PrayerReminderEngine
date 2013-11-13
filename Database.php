<?php
/*	This class has not been updated
 * look into how the cxn are done!
 * 
 * 
 * 
 */ 
	class Database{
		protected $cxn;
		public $results, $numRows;
		
		function __construct(array $cxnData = NULL) {
			$this->results 		= NULL;
			$this->cxn	   		= NULL;
			$this->numRows 		= 0;
			
			if(!is_null($cxnData)){
				$this->setCxn($cxnData);
			} else if($this->_isCxnStored()){
				$this->cxn = &$this->_getStoredCxn();
			} else {
				$this->cxn = null;
			}
		}
		public function setCxn(array $data, $store = true){
			try {
				$this->_createCxn($data['host'], $data['user'], $data['pass'], $data['db']);
				if($store) $this->_storeCxn();
			} catch (Exception $e){
				$this->log($e->getMessage());
			}
		
		}
		public function getLastIndex(){
			return $this->cxn->insert_id;
		}
		protected function log($message){
			echo "<br>Log: ".$message;			
		}
		// ------------------ Run Query ------------------------------------------------
		public function runQuery($query){
			$this->log($query);
			if ($this->cxn){
				$this->results = $this->cxn->query($query);
				if (!$this->results) {
					$this->log("FAIL");
				    $this->log('Invalid query: ' . $this->cxn->error . "\n");
				    $this->log('<br>Whole query: ' . $query);
				    return FALSE;
				}
				$this->numRows = $this->results->num_rows;
				return TRUE;
			}
		}
		public function runUpdateQuery($query){
			//$query = $this->cxn->real_escape_string($query);
			$this->log($query);
			if ($this->cxn){
				$this->results = $this->cxn->query($query);
				if (!$this->results) {
					$this->log("FAIL");
				    $this->log('Invalid query: ' . $this->cxn->error . "\n");
				    $this->log('<br>Whole query: ' . $query);
				    return FALSE;
				}
				$this->numRows = $this->cxn->affected_rows;
				return TRUE;
			}
		}
		
		//--------------------- Get Results Functions ------------------------
		public function getResults(){
			if(!$this->results)
				return false;
			else
				return $this->results;
		}
		public function getResultsAssoc(){
			if(!$this->results)
				return false;
			$data = array();
			while ($row = $this->results->fetch_assoc()){
				$data[] = $row;
			}
			return $data;
		}
		public function getResultsIndex(){
			if(!$this->results)
				return false;
			$data = array();
			while ($row = $this->results->fetch_row()){
				$data[] = $row;
			}
			return $data;
		}
		public function getFirstResult() {
			if(!$this->results)
				return false;
			$firstResult = $this->results->fetch_assoc();
			return $firstResult;
		}
		
		//----------------------- PRIVATE FUNCTIONS --------------------------------------------
		private function _createCxn($HOST, $USER, $PASS, $DB){
			try {
				$this->cxn =  new mysqli($HOST, $USER, $PASS, $DB );
			} catch (exception $e){
				echo $e->getMessage();
			}
			if (!$this->cxn) {
		    	$this->message = 'Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error();
		    	return FALSE;
			} else return TRUE;		
		}
		private function closeCxn(){
			$this->cxn->close();
		}
		private function & _getCxn(){
			return $this->cxn;
		}
		protected function _storeCxn(){
			$GLOBALS['Database']['cxn'] = & $this->cxn;
		}
		protected function &_getStoredCxn(){
			if($this->_isCxnStored())		
			return $GLOBALS['Database']['cxn'];
		else
			return false;
		}
		protected function _isCxnStored(){
			return isset($GLOBALS['Database']['cxn']);
		}

	}
?>
