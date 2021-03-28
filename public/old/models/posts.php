<?php

class Posts extends Model
{
    public static function Create($data = [])
    {
        if (empty($data['tid'])) {
            return false;
        }

        if (in_array(true, $errors = Posts::CreateError($data))) {
            return $errors;
        }

        $q = DB()->prepare($sql = "
			INSERT INTO " . setting('db_prefix') . "posts
			
			(
				tid,
				message,
				date,
				poster_uid
			)
			
			VALUES (
				?,
				?,
				?,
				?
			);
		");

        $ret = $q->execute([
            $data['tid'],
            preFormat($data['message']),
            time(),
            User::GetUser()->uid
        ]);

        return $ret;
    }

    public static function CreateError($data = [])
    {
        $error = [
            'message' => false
        ];

        // Message
        if (empty($data['message'])) {
            $error['message'] = 'Message was empty';
        }

        return $error;
    }

    public static function Read($data = [])
    {
        $page = $data['page'];
        if (empty($page)) {
            $page = 1;
        }

        $limit = $data['limit'];
        if (empty($limit)) {
            $limit = setting('limit_per_page');
        }

        $tid = $data['tid'];
        if (empty($tid)) {
            $tid = 0;
        }

        $q = DB()->prepare(
            $sql = "SELECT
			p.*
			
			FROM " . setting('db_prefix') . "posts AS p
			
			WHERE
			tid=?
			
			ORDER BY pid ASC
			
			LIMIT
			" . (($page - 1) * $limit) . ",
			$limit
			;"
        );

        $q->execute([
            $tid
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

        $tid = $data['tid'];
        if (empty($tid)) {
            $tid = 0;
        }

        $q = DB()->prepare(
            $sql = "SELECT
			COUNT(*) AS count
			
			FROM " . setting('db_prefix') . "posts AS p
			
			WHERE
			tid=?
			;"
        );

        $q->execute([
            $tid
        ]);

        return ceil($q->fetch(PDO::FETCH_OBJ)->count / $limit);
    }
}
