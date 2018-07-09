<?php

class HowtosModel extends Model {
	public $table='resources';
	
	public function __construct(){
		$this->fields=[
			'resources'=>[
				[
					'name'=>'rid',
					'type'=>'uint'
				],
				
				[
					'name'=>'type',
					'type'=>'uint'
				],
				
				[
					'name'=>'eid',
					'type'=>'uint'
				],
				
				[
					'name'=>'uid',
					'type'=>'uint'
				],
				
				[
					'name'=>'title',
					'type'=>'string'
				],
				
				[
					'name'=>'description',
					'type'=>'text'
				],
				
				[
					'name'=>'author_override',
					'type'=>'string'
				],
				
				[
					'name'=>'website_override',
					'type'=>'string'
				],
				
				[
					'name'=>'weburl_override',
					'type'=>'string'
				],
				
				[
					'name'=>'created',
					'type'=>'uint'
				],
				
				[
					'name'=>'updated',
					'type'=>'uint'
				],
				
				[
					'name'=>'queue_code',
					'type'=>'int'
				],
				
				[
					'name'=>'ghost',
					'type'=>'uint'
				],
				
				[
					'name'=>'update_reason',
					'type'=>'string'
				],
				
				[
					'name'=>'accept_date',
					'type'=>'uint'
				],
				
				[
					'name'=>'update_accept_date',
					'type'=>'uint'
				],
				
				[
					'name'=>'decision',
					'type'=>'string'
				],
				
				[
					'name'=>'catwords',
					'type'=>'text'
				],
				
				[
					'name'=>'comments',
					'type'=>'uint'
				],
				
				[
					'name'=>'comment_date',
					'type'=>'uint'
				],
			]
		];
	}
}

?>