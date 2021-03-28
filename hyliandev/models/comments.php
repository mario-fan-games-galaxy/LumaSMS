<?php

class Comments extends Model {
	public static function Read($data=[]){
		$type=$data['type'];
		$rid=$data['rid'];
		if(empty($type) || empty($rid)) return [];
		
		$page=$data['page'];
		if(empty($page)) $page=1;
		
		$limit=$data['limit'];
		if(empty($limit)) $limit=setting('limit_per_page');
		
		$q=DB()->prepare(
			$sql="SELECT
			c.*
			
			FROM " . setting('db_prefix') . "comments AS c
			
			WHERE
			type=?
			AND
			rid=?
			
			ORDER BY cid ASC
			
			LIMIT
			" . (($page - 1) * $limit) . ",
			$limit
			;"
		);
		
		$q->execute([
			$type,
			$rid
		]);
		
		$q=$q->fetchAll(PDO::FETCH_OBJ);
		
		foreach($q as $key=>$value){
			if(empty($value)){
				unset($q[$key]);
				continue;
			}
			
			$q[$key]->user=Users::Read(['uid'=>$q[$key]->uid]);
		}
		
		return $q;
	}
	
	public static function NumberOfPages($data=[]){
		$type=$data['type'];
		$rid=$data['rid'];
		if(empty($type) || empty($rid)) return [];
		
		$limit=$data['limit'];
		if(empty($limit)) $limit=setting('limit_per_page');
		
		$q=DB()->prepare(
			$sql="SELECT
			COUNT(*) AS count
			
			FROM " . setting('db_prefix') . "comments AS c
			
			WHERE
			type=?
			AND
			rid=?
			
			;"
		);
		
		$q->execute([
			$type,
			$rid
		]);
		
		return ceil($q->fetch(PDO::FETCH_OBJ)->count / $limit);
	}
}

?>