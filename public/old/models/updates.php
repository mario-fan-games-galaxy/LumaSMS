<?php

class Updates extends Model
{
    public static function Read($data = [])
    {
        $nid = $data['nid'];
        if (!empty($nid)) {
            if (!is_numeric($nid)) {
                return false;
            }

            if ($nid < 0) {
                return false;
            }

            $q = DB()->prepare("SELECT * FROM " . setting('db_prefix') . "news WHERE nid=? LIMIT 1;");

            $q->execute([$nid]);

            $q = $q->fetch(PDO::FETCH_OBJ);

            if (empty($q)) {
                return false;
            }

            $q->user = Users::Read(['uid' => $q->uid]);

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

        $q = DB()->prepare(
            $sql = "SELECT
			u.*
			
			FROM " . setting('db_prefix') . "news AS u
			
			ORDER BY nid DESC
			
			LIMIT
			" . (($page - 1) * $limit) . ",
			$limit
			;"
        );

        $q->execute();

        $q = $q->fetchAll(PDO::FETCH_OBJ);

        foreach ($q as $key => $value) {
            if (empty($value)) {
                unset($q[$key]);
                continue;
            }

            $q[$key]->user = Users::Read(['uid' => $q[$key]->uid]);
        }

        return $q;
    }

    public static function NumberOfPages($data = [])
    {
        $limit = $data['limit'];
        if (empty($limit)) {
            $limit = setting('limit_per_page');
        }

        $q = DB()->prepare(
            $sql = "SELECT
			COUNT(*) AS count
			
			FROM " . setting('db_prefix') . "news AS u
			;"
        );

        $q->execute();

        return ceil($q->fetch(PDO::FETCH_OBJ)->count / $limit);
    }
}
