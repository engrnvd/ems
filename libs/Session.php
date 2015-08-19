<?php 

// Session class manipulates the $_SESSION super global.
// It deals with:
// 1: User related functions: login, logout, authentication etc
// 2: Messages from page to page: setting a message in $_SESSION, showing it etc
class Session{
	public $message;
	public $msgType;

	function __construct(){
		session_start();
		$this->checkMessage();
	}
	public function checkMessage(){
		if(isset($_SESSION['message']) && isset($_SESSION['msgType'])){
			$this->message = $_SESSION['message'];
			$this->msgType = $_SESSION['msgType'];
			unset($_SESSION['message']);
			unset($_SESSION['msgType']);
		}else{
			$this->message = "";
			$this->msgType = "";
		}
	}
	public function setMessage($msg="" , $msgType = 'info'){
		// msg type could be any of these:
		// success, info, warning, danger
		// <div class="alert alert-success" role="alert">...</div>
		// <div class="alert alert-info" role="alert">...</div>
		// <div class="alert alert-warning" role="alert">...</div>
		// <div class="alert alert-danger" role="alert">...</div>
		$_SESSION['message'] = $this->message = $msg;
		$_SESSION['msgType'] = $this->msgType = $msgType;
	}
	public function outputMessage() {
		// returns a <p> tag with content = $message & class attribute = $msgType
		if (!empty ( $this->message ) ) { 
			echo "<p class='session_msg alert alert-{$this->msgType}' role='alert'>{$this->message}";
			echo "<span id='session_msg_disclaimer' '>Click in the box to dismiss</span></p>";
			$this->setMessage("");
		} else {
			echo "";
		}
	}

}

$session = new Session();

?>