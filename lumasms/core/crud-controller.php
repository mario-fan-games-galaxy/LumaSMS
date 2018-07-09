<?php

class CRUDController extends Controller {
	protected $type='';
	protected $join=[];
	protected $where=[];
	
	public function archive(){
		if(!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])){
			$page=$GLOBALS['params'][0];
		}else{
			$page=1;
		}
		
		$class=$this->type . 'Model';
		
		$objects=new $class();
		
		$objects=$objects->Read([
			'page'=>$page,
			'join'=>$this->join,
			'where'=>$this->where,
		]);
		
		echo view($this->type . '/archive',[
			'sprites'=>$objects['data'],
			'pages'=>$objects['pages'],
			'page'=>$page,
			'total'=>$objects['total']
		]);
	}
	
	public function single(){
		
	}
}

?>