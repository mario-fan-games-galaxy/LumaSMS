<?php

class SpritesController extends Controller {
	public function archive(){
		if(!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])){
			$page=$GLOBALS['params'][0];
		}else{
			$page=1;
		}
		
		$sprites=new SpritesModel();
		
		$sprites=$sprites->Read([
			'page'=>$page,
			'join'=>[
				[
					'table'=>'res_gfx',
					'type'=>'LEFT',
					'pkMine'=>'eid',
					'pkTheirs'=>'eid',
				]
			],
			'where'=>[
				[
					'field'=>'type',
					'value'=>1
				]
			],
		]);
		
		echo view('sprites/archive',[
			'sprites'=>$sprites['data'],
			'pages'=>$sprites['pages'],
			'page'=>$page,
			'total'=>$sprites['total']
		]);
	}
	
	public function single(){
		if(!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])){
			$rid=$GLOBALS['params'][0];
		}else{
			$rid=1;
		}
		
		
		
		
		
		if(!empty($GLOBALS['params'][2]) && is_numeric($GLOBALS['params'][2])){
			$commentsPage=$GLOBALS['params'][2];
		}else{
			$commentsPage=1;
		}
		
		
		
		
		
		$sprite=new SpritesModel();
		$comments=new CommentsModel();
		
		
		
		
		
		$sprite=$sprite->Read([
			'limit'=>1,
			'where'=>[
				[
					'field'=>'type',
					'value'=>1
				],
				[
					'field'=>'rid',
					'value'=>$rid
				]
			]
		]);
		
		
		
		
		
		if(empty($sprite['data'])){
			echo view('information',[
				'title'=>'Game Not Found',
				'message'=>'Could not find it'
			]);
			
			return;
		}
		
		
		
		
		
		$sprite=$sprite['data'][0]->data;
		
		
		
		
		
		$comments=$comments->Read([
			'page'=>$commentsPage,
			'where'=>[
				[
					'field'=>'rid',
					'value'=>$sprite['rid']
				],
				[
					'field'=>'type',
					'value'=>1
				]
			]
		]);
		
		
		
		
		
		echo view('sprites/single',[
			'sprite'=>$sprite,
			'comments'=>$comments['data'],
			'commentsPage'=>$commentsPage,
			'commentsPages'=>$comments['pages']
		]);
	}
}

?>