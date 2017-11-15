<?php
require_once 'config.php';
require_once 'functions/general_functions.php';
//session_start();

Class Email_reader {

	// imap server connection
	public $conn;

	// inbox storage and inbox message count
//	private $inbox;
	private $msg_cnt;

	// email login credentials
	private $pass//	=GetCredentials()
		;
//	private $server = $_SESSION['IMAP_HOST'];
	private $server// = 'imap.gmail.com'
		;
//	private $user   = $_SESSION['IMAP_USER'];
	private $user  // = 'testinvoice2@gmail.com'
		;
//	private $pass   = $decrypted_imap_pass;
//	private $port   = $_SESSION['IMAP_PORT']; // adjust according to server settings
	private $port   //= '993'
		;

	// connect to the server and get the inbox emails
	function __construct() {
	$this->server = $_SESSION['IMAP_HOST'];
		$this->user   = $_SESSION['IMAP_USER'];
		$this->pass   = GetCredentials();
		$this->port   = $_SESSION['IMAP_PORT']; // adjust according to server settings
	
	
		$this->connect();
		$this->inbox();
	}

	// close the server connection
	function close() {
		$this->inbox = array();
		$this->msg_cnt = 0;

		imap_close($this->conn);
	}

	// open the server connection
	// the imap_open function parameters will need to be changed for the particular server
	// these are laid out to connect to a Dreamhost IMAP server
	function connect() {
// echo  '{'.$this->server.'/ssl},'. $this->user.','. $this->pass;
insert_break();

		$this->conn = imap_open('{'.$this->server.'/ssl}', $this->user, $this->pass);
	
//		$this->conn = imap_open('{'.$this->server.'/notls}', $this->user, $this->pass);

//list folders
//var_dump ( imap_list($this->conn, "{imap.gmail.com/ssl}", "*")); 

	}

	function change_folder($folder){
		$this->close();
		$this->conn = imap_open('{'.$this->server.'/ssl}'.$folder, $this->user, $this->pass);
		$this->inbox();
	}
	



	// move the message to a new folder
	function move($msg_index, $folder='INBOX.Processed') {
		// move on server
		imap_mail_move($this->conn, $msg_index, $folder);
		imap_expunge($this->conn);

		// re-read the inbox
		$this->inbox();
	}

	// get a specific message (1 = first email, 2 = second email, etc.)
	function get($msg_index=NULL) {
		if (count($this->inbox) <= 0) {
			return array();
		}
		elseif ( ! is_null($msg_index) && isset($this->inbox[$msg_index])) {
			return $this->inbox[$msg_index];
		}

		return $this->inbox[0];
	}

	// read the inbox
	function inbox() {
		$this->msg_cnt = imap_num_msg($this->conn);

		$in = array();
		for($i = 1; $i <= $this->msg_cnt; $i++) {
			$in[] = array(
					'index'     => $i,
					'header'    => imap_headerinfo($this->conn, $i),
					'body'      => imap_body($this->conn, $i),
					'structure' => imap_fetchstructure($this->conn, $i)
					);
		}

		$this->inbox = $in;
	}

	function output() {
		return $this->inbox;
		}


}

?>
