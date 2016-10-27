<?php

	require_once("Rest.inc.php");
	
	class Server extends REST {
	
		public $data = "";
		
		const DB_SERVER = "localhost";
		const DB_USER = "root";
		const DB_PASSWORD = "";
		const DB = "";
		
		private $db = NULL;
	
		public function __construct(){
			parent::__construct();
			//$this->dbConnect();
		}
		
		private function dbConnect(){
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysql_select_db(self::DB,$this->db);
		}
		
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			
			if((int)method_exists($this, $func) > 0)
			{
				$this->$func();
			}
			else
			{
				$this->response('',406);
			}
		}
		
		private function login(){
			
			
			if($this->get_request_method() != "POST"){
				$result = array('status' => "Failed", "msg" => "Method not allowed");
				$this->response($this->json($result),406);
			}
			
			
			$email = $this->_request['email'];
			$password = $this->_request['pwd'];
			
			$result = array('status' => "Success", "msg" => "Hai ".$email);
			$this->response($this->json($result),200);
			
			$error = array('status' => "Failed", "msg" => "Invalid Email address or Password");
			$this->response($this->json($error), 400);
		}
				
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	$server = new Server;
	$server->processApi();
?>