<?php
/**
 * Base model for all other models.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\core;

/**
 * Base model for all other models.
 */
class Model
{
    /**
     * @var string The SQL table this resource is saved in.
     */
    protected $table = '';

    /**
     * @var string The fields for this model, separated by commas.
     */
    protected $fields = '';

    /**
     * @var string The model's data, separated by commas.
     */
    public $data;

    /**
     * @var string Number of fields to replace in a query.
     */
    public $qMarks;

    /**
     * Create a query
     *
     * @param array $vars A key/value array of fields/values for this query.
     *
     * @return void
     */
    public function create(array $vars)
    {
        $this->qMarks = writeNTimes('?', count($vars));
        $this->fields = implode(',', array_keys($vars));
        $this->table = settings()['database']['prefix'] . $this->table;
    }

    /**
     * Query the database for this model.
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     *
     * @param array $vars Modify the database query with the values of this
     *                    array, somehow.
     *
     * @return array An array of results.
     */
    public function read(array $vars = [])
    {
        // Variables

        // Get full table name
        $table = settings()['database']['prefix'] . $this->table;

        // Variables we'll fill in later
        $limit = '';
        $page = '';
        $order = '';
        $fields = '*';
        $where = '';
        $whereValues = [];
        $joins = '';

        // Get order

        if (!empty($vars['orderby'])) {
            $order = "ORDER BY $vars[orderby]";

            if (!empty($vars['order'])) {
                $order .= " $vars[order]";
            }
        }

        // Get limit

        if (empty($vars['limit'])) {
            $vars['limit'] = 20;
        }

        if (!empty($vars['page'])) {
            $page = $vars['limit'] * ($vars['page'] - 1) . ",";
        }

        $limit = "LIMIT $page $vars[limit]";

        // Get fields

        if (!empty($vars['fields'])) {
            $fields = implode(',', array_keys($vars['fields']));
        }

        // Get where

        if (!empty($vars['where'])) {
            $where = [];

            foreach ($vars['where'] as $wherePiece) {
                $where[] = $wherePiece['field'] . ' = ?';
                $whereValues[] = $wherePiece['value'];
            }

            $where = 'WHERE ' . implode(' AND ', $where);
        }

        // Get joins

        if (!empty($vars['join'])) {
            $joins = [];

            foreach ($vars['join'] as $join) {
                static $joinID = 0;

                $join['table'] = settings()['database']['prefix'] . $join['table'];

                $joins[] = "
				$join[type] JOIN $join[table] AS join$joinID
				ON
				join$joinID.$join[pkMine] = main.$join[pkTheirs]
				";

                $joinID++;
            }

            $joins = implode("\n", $joins);
        }

        // Base query

        $sql = "
		SELECT {fields} FROM
		$table AS main

		$joins

		$where
		";

        // Get the total results before limit

        $count = str_replace('{fields}', 'COUNT(*) AS count', $sql);
        $count = database()->object()->prepare($count);
        $count->execute($whereValues);
        $count = $count->fetch(PDO::FETCH_ASSOC);
        $count = $count['count'];

        // Finalize the query

        $sql = str_replace('{fields}', $fields, $sql);
        $sql .= $order . " " . $limit;

        // Run the query

        $query = database()->object()->prepare($sql);
        $query->execute($whereValues);
        $ret = [
            'total' => $count,
            'pages' => ceil($count / $vars['limit']),
            'data' => []
        ];

        // Get the list of model objects

        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $obj) {
            $class = get_class($this);

            $newObj = new $class();

            foreach ($obj as $key => $value) {
                $newObj->data[$key] = $value;
            }

            $ret['data'][] = $newObj;
        }

        // Return the response

        return $ret;
    }
}
