<?php

function debug(){
	ob_start();
	
	foreach(func_get_args() as $arg){
		echo '<pre>' . print_r($arg,true) . '</pre>';
	}
	
	return ob_get_clean();
}

function showDate($date,$displaySetting = null){
	if(empty($date) || !is_numeric($date)){
		$date=0;
	}
	
	if($displaySetting == null){
		$displaySetting='since';
	}
	
	switch($displaySetting){
		case 'date':
			$date=date(
				'm/d/Y g:i:sa',
				$date
			);
		break;
		
		case 'since':
			$date=time() - $date;
			
			$suffixes=[
				0=>'second',
				60=>'minute',
				(60 * 60)=>'hour',
				(60 * 60 * 24)=>'day',
				(60 * 60 * 24 * 7)=>'week',
				(60 * 60 * 24 * 365)=>'year'
			];
			
			foreach($suffixes as $key=>$value){
				if(abs($date) < $key){
					break;
				}
				
				if($key != 0){
					$val=floor(abs($date) / $key);
				}else{
					$val=abs($date);
				}
				
				$_date=$val . ' ' . $value;
				
				if($val != 1){
					$_date .= 's';
				}
				
				if($date > 0){
					$_date .= ' ago';
				}else{
					$_date .= ' from now';
				}
				
				$_date='<span class="countdown-container" data-timer="' . -$date . '">' . $_date . '</span>';
			}
			
			$date=$_date;
		break;
	}
	
	return $date;
}

function url(){
	$url='http';
	
	if(!empty($_SERVER['HTTPS'])){
		$url .= 's';
	}
	
	$url .= '://';
	
	$url .= $_SERVER['SERVER_NAME'];
	
	$self=explode('/index.php',$_SERVER['SCRIPT_NAME']);
	
	$url .= array_shift($self);
	
	return $url;
}

function writeNTimes($str, $n, $divider = ', '){
	$ret=[];
	
	for($i=0;$i<$n;$i++){
		$ret[]=$n;
	}
	
	return implode($divider,$ret);
}

?>