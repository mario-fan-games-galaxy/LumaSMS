<?php

class GamesController extends CRUDController {
	public function __construct(){
		$this->commentsType=1;
		
		$this->idField='rid';
		
		$this->type='Games';
		
		$this->join=[
			[
				'table'=>'res_games',
				'type'=>'LEFT',
				'pkMine'=>'eid',
				'pkTheirs'=>'eid',
			]
		];
		
		$this->where=[
			[
				'field'=>'type',
				'value'=>2
			]
		];
	}
}

?>