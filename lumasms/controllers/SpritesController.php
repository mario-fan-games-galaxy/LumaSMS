<?php

class SpritesController extends CRUDController {
	public function __construct(){
		$this->type='Sprites';
		
		$this->join=[
			[
				'table'=>'res_gfx',
				'type'=>'LEFT',
				'pkMine'=>'eid',
				'pkTheirs'=>'eid',
			]
		];
		
		$this->where=[
			[
				'field'=>'type',
				'value'=>1
			]
		];
	}
}

?>