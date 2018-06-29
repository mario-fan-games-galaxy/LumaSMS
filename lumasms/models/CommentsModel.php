<?php

class CommentsModel extends Model {
	public $table='comments';
	
	public function __construct(){
		$this->fields=[
			[
				'name'=>'cid',
				'type'=>'uint'
			],
			
			[
				'name'=>'rid',
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
				'name'=>'message',
				'type'=>'text'
			],
			
			[
				'name'=>'type',
				'type'=>'int'
			],
			
			[
				'name'=>'ip',
				'type'=>'string'
			],
		];
	}
}

?>