<?php

class Model {
	protected $table;
	protected $fields;
	public $data;
	
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
		
		$limit='';
		$page='';
		$order='';
		
		if(!empty($vars['orderby'])){
			$order="ORDER BY $vars[orderby]";
			
			if(!empty($vars['order'])){
				$order .= " $vars[order]";
			}
		}
		
		if(empty($vars['limit'])){
			$vars['limit']=20;
		}
		
		if(!empty($vars['page'])){
			$page=$vars['limit'] * ($vars['page'] - 1) . ",";
		}
		
		$limit="LIMIT $page $vars[limit]";
		
		$sql="
		SELECT * FROM
		$table
		
		$order
		
		$limit
		";
		
		$q=DB()->O()->query($sql);
		$ret=[];
		
		foreach($q->fetchAll(PDO::FETCH_ASSOC) as $obj){
			$class=get_class($this);
			
			$newObj=new $class();
			
			foreach($obj as $key=>$value){
				$newObj->data[$key]=$value;
			}
			
			$ret[]=$newObj;
		}
		
		return $ret;
	}
}

?>