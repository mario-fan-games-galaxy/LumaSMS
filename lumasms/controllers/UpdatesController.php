<?php

class UpdatesController extends Controller {
	public function archive(){
		if(!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])){
			$page=$GLOBALS['params'][0];
		}else{
			$page=1;
		}
		
		$updates=new UpdatesModel();
		
		$updates=$updates->Read([
			'limit'=>2,
			'page'=>$page,
			'orderby'=>'nid',
			'order'=>'desc'
		]);
		
		echo view('updates/archive',[
			'updates'=>$updates['data'],
			'pages'=>$updates['pages'],
			'page'=>$page,
			'total'=>$updates['total']
		]);
	}
	
	public function single(){
		if(!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])){
			$nid=$GLOBALS['params'][0];
		}else{
			$nid=1;
		}
		
		
		
		
		
		$update=new UpdatesModel();
		$comments=new CommentsModel();
		
		
		
		
		
		$update=$update->Read([
			'limit'=>1,
			'where'=>[
				[
					'field'=>'nid',
					'value'=>$nid
				]
			]
		]);
		
		
		
		
		
		if(empty($update['data'])){
			echo view('information',[
				'title'=>'News Post Not Found',
				'message'=>'Could not find it'
			]);
			
			return;
		}
		
		
		
		
		
		$update=$update['data'][0]->data;
		
		
		
		
		
		$comments=$comments->Read([
			'page'=>1,
			'where'=>[
				[
					'field'=>'rid',
					'value'=>$update['nid']
				],
				[
					'field'=>'type',
					'value'=>2
				]
			]
		]);
		
		
		
		
		
		echo view('updates/single',[
			'update'=>$update,
			'comments'=>$comments['data']
		]);
	}
}

?>