<?php

class GamesController extends Controller {
	public function archive(){
		if(!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])){
			$page=$GLOBALS['params'][0];
		}else{
			$page=1;
		}
		
		$games=new GamesModel();
		
		$games=$games->Read([
			'page'=>$page,
			'join'=>[
				[
					'table'=>'res_games',
					'type'=>'LEFT',
					'pkMine'=>'eid',
					'pkTheirs'=>'eid',
				]
			],
			'where'=>[
				[
					'field'=>'type',
					'value'=>2
				]
			],
		]);
		
		echo view('games/archive',[
			'games'=>$games['data'],
			'pages'=>$games['pages'],
			'page'=>$page,
			'total'=>$games['total']
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
		
		
		
		
		
		$game=new GamesModel();
		$comments=new CommentsModel();
		
		
		
		
		
		$game=$game->Read([
			'limit'=>1,
			'where'=>[
				[
					'field'=>'type',
					'value'=>2
				],
				[
					'field'=>'rid',
					'value'=>$rid
				]
			]
		]);
		
		
		
		
		
		if(empty($game['data'])){
			echo view('information',[
				'title'=>'Game Not Found',
				'message'=>'Could not find it'
			]);
			
			return;
		}
		
		
		
		
		
		$game=$game['data'][0]->data;
		
		
		
		
		
		$comments=$comments->Read([
			'page'=>$commentsPage,
			'where'=>[
				[
					'field'=>'rid',
					'value'=>$game['rid']
				],
				[
					'field'=>'type',
					'value'=>1
				]
			]
		]);
		
		
		
		
		
		echo view('games/single',[
			'game'=>$game,
			'comments'=>$comments['data'],
			'commentsPage'=>$commentsPage,
			'commentsPages'=>$comments['pages']
		]);
	}
}

?>