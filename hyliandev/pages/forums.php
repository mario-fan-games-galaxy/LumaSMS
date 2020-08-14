<?php

$vars=[];

switch($params[0]){
	case '':
	case 'index':
		$view='index';
	break;
	
	case 'category':
		$view='category-single';
		
		$fid=array_shift(explode('-',$params[1]));
		
		$vars=Forums::Read(['fid'=>$fid,'gid'=>User::GetUserGroup()]);
		if(empty($vars)){
			$view='badparams';
			break;
		}
	break;
	
	case 'forum':
		$view='forum-single';
		
		$fid=array_shift(explode('-',$params[1]));
		
		$vars=Forums::Read(['fid'=>$fid,'gid'=>User::GetUserGroup()]);
		
		if(empty($vars)){
			$view='badparams';
			break;
		}
		
		$vars->topics=Topics::Read($data=['pid'=>$fid,'page'=>$page]);
	break;
	
	case 'topic':
		$view='topic-single';
		
		if($params[1] == 'new'){
			$user = User::GetUser();
			$vars=Forums::Read(['fid'=>$params[2],'can_post'=>User::GetUserGroup()]);
			if(empty($user)){
				$view='not-logged-in';
				break;
			}elseif(empty($vars)){
				$view='badparams';
				break;
			}
			
			$view='topic-new';
			
			if(isset($_POST['title']) && isset($_POST['message'])){
				$vars->errors=Topics::Create([
					'title'=>$_POST['title'],
					'message'=>$_POST['message'],
					'pid'=>$params[2]
				]);
				
				$view='topic-new-success';
				
				if($vars->errors === true){
					$view='topic-new-success';
				}else{
					foreach($vars->errors as $error){
						if(!empty($error)){
							$view='topic-new';
						}
					}
				}
			}
			
			break;
		}
		
		$tid=array_shift(explode('-',$params[1]));
		
		$vars=Topics::Read(['tid'=>$tid]);
		if(empty($vars)){
			$view='badparams';
			break;
		}
		
		$q=DB()->prepare("
			UPDATE " . setting('db_prefix') . "topics
			SET views = views + 1
			WHERE
			tid= ?
		");
		
		$q->execute([$tid]);
	break;
	
	case 'post':
		$view='post-new';
		
		$user = User::GetUser();
		$vars=Topics::Read(['tid'=>$params[2]]);
		if(empty($user)){
			$view='not-logged-in';
			break;
		}elseif($params[1] != 'new' || empty($vars)){
			$view='badparams';
			break;
		}
		
		if(isset($_POST['message'])){
			$vars->errors=Posts::Create([
				'message'=>$_POST['message'],
				'tid'=>$params[2]
			]);
			
			$view='post-new-success';
			
			if($vars->errors === true){
				$view='post-new-success';
				
				$q=DB()->prepare("
					UPDATE " . setting('db_prefix') . "topics
					SET replies = replies + 1
					WHERE
					tid=?
				");
				
				$q->execute([$params[2]]);
			}else{
				foreach($vars->errors as $error){
					if(!empty($error)){
						$view='post-new';
					}
				}
			}
		}
	break;
	
	default:
		$view='badparams';
	break;
}

$vars->page=$params[2];
if(empty($vars->page) || !is_numeric($vars->page) || $vars->page <= 0){
	$vars->page=1;
}

echo view('forums/' . $view,$vars);

?>
