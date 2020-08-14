<?php

class Forums extends Model {
	public static function Read($data=[]){
		$fid=$data['fid'];
		if(!empty($fid)){
			if(!is_numeric($fid)) return false;
			
			if($fid < 0) return false;
			
			$q=DB()->prepare("SELECT f.* FROM " . setting('db_prefix') . "forums AS f WHERE f.fid=? LIMIT 1;");
			
			$q->execute([$fid]);
			
			$q=$q->fetch(PDO::FETCH_OBJ);
			
			if(empty($q)){
				return false;
			}
			
			return $q;
		}
		
		$page=$data['page'];
		if(empty($page)) $page=1;
		
		$limit=$data['limit'];
		if(empty($limit)) $limit=setting('limit_per_page');
		
		$pid=$data['pid'];
		if(empty($pid)) $pid=0;
		
		$gid=$data['gid'];
		
		$q=DB()->prepare(
			$sql="SELECT
			f.*
			
			FROM " . setting('db_prefix') . "forums AS f
			
			WHERE
			pid=?
			" . (!isset($gid) ? "" : "AND can_see LIKE '%-" . $gid . "-%'") . "
			
			ORDER BY order_place ASC
			
			LIMIT
			" . (($page - 1) * $limit) . ",
			$limit
			;"
		);
		
		$q->execute([
			$pid
		]);
		
		$q=$q->fetchAll(PDO::FETCH_OBJ);
		
		foreach($q as $key=>$value){
			if(empty($value)){
				unset($q[$key]);
				continue;
			}
			
			$q[$key]->user=Users::Read(['uid'=>$q[$key]->poster_uid]);
		}
		
		return $q;
	}
}

?>