<?php

class UpdatesController extends CRUDController {
	public function __construct(){
		$this->commentsType=2;
		
		$this->idField='nid';
		
		$this->type='Updates';
	}
}

?>