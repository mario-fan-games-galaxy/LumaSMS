<?php

class SoundsController extends CRUDController {
	public function __construct(){
		$this->commentsType=1;
		
		$this->idField='rid';
		
		$this->type='Sounds';
		
		$this->join=[
			[
				'table'=>'res_sounds',
				'type'=>'LEFT',
				'pkMine'=>'eid',
				'pkTheirs'=>'eid',
			]
		];
		
		$this->where=[
			[
				'field'=>'type',
				'value'=>5
			]
		];
	}
}

?>