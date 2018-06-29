<?php

class UpdatesModel extends Model {
	public function __construct(){
		$this->table='news';
		
		$this->fields=[
			[
				'name'=>'nid',
				'type'=>'uint'
			],
			
			[
				'name'=>'uid',
				'type'=>'uint'
			],
			
			[
				'name'=>'date',
				'type'=>'uint'
			],
			
			[
				'name'=>'title',
				'type'=>'string'
			],
			
			[
				'name'=>'message',
				'type'=>'text'
			],
			
			[
				'name'=>'comments',
				'type'=>'uint'
			],
			
			[
				'name'=>'update_tag',
				'type'=>'int'
			]
		];
	}
}

?>