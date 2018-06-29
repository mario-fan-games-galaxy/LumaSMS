<?php

class DatabaseDriver {
	protected $database;
}

function DB(){
	return $GLOBALS['database'];
}

?>