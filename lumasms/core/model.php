<?php

class Model {
	protected $table;
	protected $fields;
	
	function Create($vars){
		$qMarks=writeNTimes('?',count($vars));
		$fields=implode(',',array_keys($vars));
		$table=S()['database']['prefix'] . $this->table;
		
		$sql="
		INSERT INTO
		$table
		($fields)
		VALUES
		($qMarks)
		";
	}
	
	function Read($vars=[]){
		$table=S()['database']['prefix'] . $this->table;
		
		if(empty($vars['limit'])){
			$vars['limit']=20;
		}
		
		$sql="
		SELECT * FROM
		$table
		
		LIMIT
		$vars[limit]
		";
		
		$q=DB()->O()->query($sql);
		
		foreach($q->fetchAll(PDO::FETCH_OBJ) as $obj){
			die(debug($obj));
		}
	}
}

?>