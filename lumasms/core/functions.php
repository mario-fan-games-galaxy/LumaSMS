<?php

/**
 * Returns a print_r string warapped in a <pre> tag for all of the parameters
 *
 * @return string
 */
function debug(){
	ob_start();
	
	foreach(func_get_args() as $arg){
		echo '<pre>' . print_r($arg,true) . '</pre>';
	}
	
	return ob_get_clean();
}

/**
 * Echo this any time you show a date
 *
 * @param int $date Unix timestamp
 * @param string $displaySetting Override for the date display setting
 * @return string
 */
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

/**
 * Turn a formatted string into a URL-frindly string
 *
 * @param string $title
 * @return void
 */
function titleToSlug($title){
	$title=preg_replace('/&(.)+;/U','',$title);
	$title=preg_replace('/[^a-zA-Z0-9 ]/','',$title);
	$title=str_replace(' ','-',$title);
	$title=strtolower($title);
	$title=substr($title,0,50);
	
	return $title;
}

/**
 * Put this at the beginning of any on-site links. Returns the domain and directory
 *
 * @return string
 */
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

/**
 * Write a string a specified number of times. Used for putting ?s in prepared queries
 *
 * @param string $str The string to repead
 * @param int $n The number of times to repeat it
 * @param string $divider The divider. Default ", "
 * @return return string
 */
function writeNTimes($str, $n, $divider = ', '){
	$ret=[];
	
	for($i=0;$i<$n;$i++){
		$ret[]=$n;
	}
	
	return implode($divider,$ret);
}

?>