<?php

class UpdatesController extends Controller {
	public function archive(){
		$updates=new UpdatesModel();
		
		$updates=$updates->Read([
			'limit'=>2,
			'page'=>1,
			'orderby'=>'nid',
			'order'=>'desc'
		]);
		
		echo view('updates/archive',[
			'updates'=>$updates['data'],
			'pages'=>$updates['pages'],
			'total'=>$updates['total']
		]);
	}
}

?>