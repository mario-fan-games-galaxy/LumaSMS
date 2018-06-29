<?php

class MySQLDatabaseDriver extends DatabaseDriver {
	public function __construct(){
		try {
			$this->database=new PDO(
				'mysql:hostname=' . S()['database']['hostname'] . ';dbname=' . S()['database']['dbname'],
				S()['database']['username'],
				S()['database']['password']
			);
		}
		catch(Exception $e){
			die(Fatality($e));
		}
	}
	
	public function O(){
		return $this->database;
	}
}

?>