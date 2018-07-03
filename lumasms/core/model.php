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
		// Variables
		
		// Get full table name
		$table=S()['database']['prefix'] . $this->table;
		
		// Variables we'll fill in later
		$limit='';
		$page='';
		$order='';
		$fields='*';
		$where='';
		$whereValues=[];
		$joins='';
		
		
		
		
		
		// Get order
		
		if(!empty($vars['orderby'])){
			$order="ORDER BY $vars[orderby]";
			
			if(!empty($vars['order'])){
				$order .= " $vars[order]";
			}
		}
		
		
		
		
		
		// Get limit
		
		if(empty($vars['limit'])){
			$vars['limit']=20;
		}
		
		if(!empty($vars['page'])){
			$page=$vars['limit'] * ($vars['page'] - 1) . ",";
		}
		
		$limit="LIMIT $page $vars[limit]";
		
		
		
		
		
		// Get fields
		
		if(!empty($vars['fields'])){
			$fields=implode(',',array_keys($vars['fields']));
		}
		
		
		
		
		
		// Get where
		
		if(!empty($vars['where'])){
			$where=[];
			
			foreach($vars['where'] as $_where){
				$where[]=$_where['field'] . ' = ?';
				$whereValues[]=$_where['value'];
			}
			
			$where='WHERE ' . implode(' AND ',$where);
		}
		
		
		
		
		
		// Get joins
		
		if(!empty($vars['join'])){
			$joins=[];
			
			foreach($vars['join'] as $join){
				static $joinID=0;
				
				$join['table']=S()['database']['prefix'] . $join['table'];
				
				$joins[]="
				$join[type] JOIN $join[table] AS join$joinID
				ON
				join$joinID.$join[pkMine] = main.$join[pkTheirs]
				";
				
				$joinID++;
			}
			
			$joins=implode("\n",$joins);
		}
		
		
		
		
		
		// Base query
		
		$sql="
		SELECT {fields} FROM
		$table AS main
		
		$joins
		
		$where
		";
		
		
		
		
		
		// Get the total results before limit
		
		$count=str_replace('{fields}','COUNT(*) AS count',$sql);
		$count=DB()->O()->prepare($count);
		$count->execute($whereValues);
		$count=$count->fetch(PDO::FETCH_ASSOC);
		$count=$count['count'];
		
		
		
		
		
		// Finalize the query
		
		$sql=str_replace('{fields}',$fields,$sql);
		$sql.=$order . " " . $limit;
		
		
		
		
		
		// Run the query
		
		$q=DB()->O()->prepare($sql);
		$q->execute($whereValues);
		$ret=[
			'total'=>$count,
			'pages'=>ceil($count / $vars['limit']),
			'data'=>[]
		];
		
		
		
		
		
		// Get the list of model objects
		
		foreach($q->fetchAll(PDO::FETCH_ASSOC) as $obj){
			$class=get_class($this);
			
			$newObj=new $class();
			
			foreach($obj as $key=>$value){
				$newObj->data[$key]=$value;
			}
			
			$ret['data'][]=$newObj;
		}
		
		
		
		
		
		// Return the response
		
		return $ret;
	}
}

?>