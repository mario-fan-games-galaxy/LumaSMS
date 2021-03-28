<?php

class Sprites extends Model
{
    public static function Read($data = [], $qc = false)
    {
        $rid = $data['rid'];
        if (!empty($rid)) {
            if (!is_numeric($rid)) {
                return false;
            }

            if ($rid < 0) {
                return false;
            }

            $q = DB()->prepare("SELECT r.*, g.* FROM " . setting('db_prefix') . "res_gfx AS g LEFT JOIN " . setting('db_prefix') . "resources AS r ON r.eid=g.eid WHERE r.rid=? LIMIT 1;");

            $q->execute([$rid]);

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
			r.*,
			g.*
			
			FROM " . setting('db_prefix') . "res_gfx AS g
			
			LEFT JOIN " . setting('db_prefix') . "resources AS r
			ON r.eid = g.eid
			
			WHERE
			r.type=1
			AND
			r.rid > 0
			AND
			r.accept_date " . ($qc ? " = 0" : " > 0") . "
			
			ORDER BY rid DESC
			
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

    public static function NumberOfPages($data = [], $qc = false)
    {
        $limit = $data['limit'];
        if (empty($limit)) {
            $limit = setting('limit_per_page');
        }

        $q = DB()->prepare(
            $sql = "SELECT
			COUNT(*) AS count
			
			FROM " . setting('db_prefix') . "res_gfx AS g
			
			LEFT JOIN " . setting('db_prefix') . "resources AS r
			ON r.eid=g.eid
			
			WHERE
			r.type = 1
			AND
			r.accept_date " . ($qc ? " = 0" : " > 0") . "
			;"
        );

        $q->execute();

        return ceil($q->fetch(PDO::FETCH_OBJ)->count / $limit);
    }
}
