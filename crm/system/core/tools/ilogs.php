<?php
class iLog {
	private $level;
	private $filename;

	function __construct($path='', $level = '') {
		if ($level !='')  {
			$this->level = $level;
		}
		else { 
			$this->level = 'info';
		}
		$this->filename = $path;
	}

	public function debug($message) {
		if($this->level == 'debug') {
			$this->write_log($message);
		}
	}
	public function info($message) {
		if($this->level == 'info' || $this->level == 'debug' ) {
		   $this->write_log($message);
		}
	}
	public function warn($message) {
		if($this->level == 'warn' ||$this->level == 'info' || $this->level == 'debug' ) {
		   $this->write_log($message);
		}
	}
	public function error($message) {
		if($this->level == 'error' || $this->level == 'warn' || $this->level == 'info' || $this->level == 'debug' ) {
		   $this->write_log($message);
		}
	}
	public function request() {
		$headers = getallheaders();
		$this->write_log("REQUEST:");
		$this->write_log($headers);
		$get_params = $_GET;

		if($get_params) {
			$this->write_log("GET parameters:");
			$this->write_log($get_params);
		}
		$post_params = $_POST;
		if($post_params) {
			$this->write_log("POST parameters:");
			$this->write_log($post_params);
		}
	}
	public function session() {
		 $session_params = $_SESSION;
		 if($session_params) {
			$this->write_log("SESSION parameters:");
			$this->write_log($session_params);
		}
	}
	private function write_log($message) {
		//$message can either be a string or an array
		$fd = fopen($this->filename, 'a');
		if(is_array($message)) {
			$this->write_array($message, $fd);
		}
		else {
			$this->write_string($message, $fd);
		}
		fclose($fd);
	}
	private function write_string($message, $fd)  {
		fwrite($fd, '[ '.date('Y-m-d G:i:s').' ] '.$message."\n");
	}
	private function write_array($message, $fd) {
		 foreach($message as $key => $value) {
			if(is_array($value)) {
			   fwrite($fd, $key."{ ");
			   $this->write_array($value, $fd);
			   fwrite($fd, " }\n");
			}
			else {
				$string =  "\t {".$key.': '.$value."}\n ";
				fwrite($fd, $string);
			}
		}
	}
}

?>
