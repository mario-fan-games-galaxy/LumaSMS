<?php

$routes=[
	// Updates
	'updates/archive'=>'UpdatesController@archive',
	'updates'=>'UpdatesController@archive',
	
	'updates/view'=>'UpdatesController@single',
	
	// Games
	'games/archive'=>'GamesController@archive',
	'games'=>'GamesController@archive',
	
	'games/view'=>'GamesController@single',
];

?>