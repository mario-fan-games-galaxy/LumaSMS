<?php

class Topics extends Model
{
    public static function CanDelete($data = [], $topic = null)
    {
        if (empty(User::GetUser()->uid)) {
            return false;
        }
        
        if (empty($data['tid']) && $topic == null) {
            return false;
        }
        
        if (in_array(User::GetUser()->gid, [
            1,
            2,
            16
        ])) {
            return true;
        }
        
        return false;
    }
    
    public static function CanEdit($data = [], $topic = null)
    {
        if (empty(User::GetUser()->uid)) {
            return false;
        }
        
        if (empty($data['tid']) && $topic == null) {
            return false;
        }
        
        if (in_array(User::GetUser()->gid, [
            1,
            2,
            16
        ])) {
            return true;
        }
        
        if ($topic == null) {
            $topic = Topics::Read(['tid' => $data['tid']]);
        }
        
        return $topic->poster_uid == User::GetUser()->uid;
    }
    
    public static function Create($data = [])
    {
        if (empty($data['pid'])) {
            return false;
        }
        
        if (in_array(true, $errors = Topics::CreateError($data))) {
            return $errors;
        }
        
        $q = DB()->prepare($sql = "
			INSERT INTO " . setting('db_prefix') . "topics
			
			(
				pid,
				title,
				date,
				poster_uid,
				last_post_date,
				views,
				replies
			)
			
			VALUES (
				?,
				?,
				?,
				?,
				?,
				0,
				0
			);
		");
        
        $ret = $q->execute([
            $data['pid'],
            preFormat($data['title']),
            time(),
            User::GetUser()->uid,
            time()
        ]);
        
        $GLOBALS['topic_id'] = DB()->lastInsertId();
        
        Posts::Create([
            'message' => $data['message'],
            'tid' => $GLOBALS['topic_id']
        ]);
        
        return $ret;
    }
    
    public static function CreateError($data = [])
    {
        $error = [
            'title' => false,
            'message' => false
        ];
        
        // Title
        if (empty($data['title'])) {
            $error['title'] = 'Title was empty';
        } elseif (Topics::Exists(['title' => $data['title']])) {
            $error['title'] = 'A topic with that title exists already';
        }
        
        // Message
        if (empty($data['message'])) {
            $error['message'] = 'Message was empty';
        }
        
        return $error;
    }
    
    public static function Exists($data)
    {
        $where = [];
        foreach ($data as $key => $value) {
            $where[] = $key . " = " . DB()->quote($value);
        }
        
        $q = DB()->query("
			SELECT COUNT(*) AS count FROM " . setting('db_prefix') . "topics
			WHERE
			" . implode(' AND ', $where) . "
			
			LIMIT 1
			;
		");
        
        return $q->fetch(PDO::FETCH_OBJ)->count;
    }
    
    public static function Read($data = [])
    {
        $tid = $data['tid'];
        if (!empty($tid)) {
            if (!is_numeric($tid)) {
                return false;
            }
            
            if ($tid < 0) {
                return false;
            }
            
            $q = DB()->prepare("SELECT t.* FROM " . setting('db_prefix') . "topics AS t WHERE t.tid=? LIMIT 1;");
            
            $q->execute([$tid]);
            
            $q = $q->fetch(PDO::FETCH_OBJ);
            
            if (empty($q)) {
                return false;
            }
            
            return $q;
        }
        
        $page = $data['page'];
        if (empty($page)) {
            $page = 1;
        }
        
        $limit = $data['limit'];
        if (empty($limit)) {
            $limit = setting('limit_per_page');
        }
        
        $pid = $data['pid'];
        if (empty($pid)) {
            $pid = 0;
        }
        
        $q = DB()->prepare(
            $sql = "SELECT
			t.*
			
			FROM " . setting('db_prefix') . "topics AS t
			
			WHERE
			pid=?
			
			ORDER BY last_post_date DESC
			
			LIMIT
			" . (($page - 1) * $limit) . ",
			$limit
			;"
        );
        
        $q->execute([
            $pid
        ]);
        
        $q = $q->fetchAll(PDO::FETCH_OBJ);
        
        foreach ($q as $key => $value) {
            if (empty($value)) {
                unset($q[$key]);
                continue;
            }
            
            $q[$key]->user = Users::Read(['uid' => $q[$key]->poster_uid]);
        }
        
        return $q;
    }
    
    public static function NumberOfPages($data = [])
    {
        $limit = $data['limit'];
        if (empty($limit)) {
            $limit = setting('limit_per_page');
        }
        
        $pid = $data['pid'];
        if (empty($pid)) {
            $pid = 0;
        }
        
        $q = DB()->prepare(
            $sql = "SELECT
			COUNT(*) AS count
			
			FROM " . setting('db_prefix') . "topics AS t
			
			WHERE
			pid=?
			;"
        );
        
        $q->execute([
            $pid
        ]);
        
        return ceil($q->fetch(PDO::FETCH_OBJ)->count / $limit);
    }
}
