<?php
class DbConfig 
{	
	private $_host = '3.111.82.189';
	private $_username = 'vgn';
	private $_password = '@Vgnadglobal360!@';
	private $_database = 'vgn_devlopment_01';
	protected $conn;
	public function __construct()
	{
		if (!isset($this->conn)) {
			$this->conn = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
			
			if ($this->conn->connect_error) {
				die('Cannot connect to database server: ' . $this->conn->connect_error);
			}			
		}	
	}
	# Public method to get the connection
	public function getConnection()
	{
		return $this->conn;
	}
}