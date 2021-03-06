<?php

/**
 * Create/Read/Update/Delete controller.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\core;

use LumaSMS\models\CommentsModel;

/**
 * Create/Read/Update/Delete controller.
 */
class CRUDController extends Controller
{
    /**
     * @var string The model type we're dealing with.
     */
    protected $type = '';

    /**
     * @var array Variables to manage a JOIN SQL cluase.
     */
    protected $join = [];

    /**
     * @var array Variables to manage a WHERE SQL clause.
     */
    protected $where = [];

    /**
     * Display an archive of items in the model, like WordPress.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     *
     * @return void
     */
    public function archive()
    {
        $page = 1;
        if (!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])) {
            $page = $GLOBALS['params'][0];
        }

        $class = '\\LumaSMS\\models\\' . $this->type . 'Model';

        $objects = new $class();

        $objects = $objects->read([
            'page' => $page,
            'join' => $this->join,
            'where' => $this->where,
        ]);

        echo template($this->type . '/archive', [
            'objects' => $objects['data'],
            'pages' => $objects['pages'],
            'page' => $page,
            'total' => $objects['total']
        ]);
    }

    /**
     * Display a single item in the model.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     *
     * @return void
     */
    public function single()
    {
        $oid = 1;
        if (!empty($GLOBALS['params']) && is_numeric($GLOBALS['params'][0])) {
            $oid = $GLOBALS['params'][0];
        }

        $commentsPage = 1;
        if (!empty($GLOBALS['params'][2]) && is_numeric($GLOBALS['params'][2])) {
            $commentsPage = $GLOBALS['params'][2];
        }

        $class = '\\LumaSMS\\models\\' . $this->type . 'Model';
        $object = new $class();
        $comments = new CommentsModel();

        $object = $object->read([
            'limit' => 1,
            'where' => [
                [
                    'field' => $this->idField,
                    'value' => $oid
                ]
            ]
        ]);

        if (empty($object['data'])) {
            echo template('information', [
                'title' => 'Object Not Found',
                'message' => 'Could not find it'
            ]);

            return;
        }

        $object = $object['data'][0]->data;

        $comments = $comments->read([
            'page' => $commentsPage,
            'where' => [
                [
                    'field' => 'rid',
                    'value' => $object[$this->idField]
                ],
                [
                    'field' => 'type',
                    'value' => $this->commentsType
                ]
            ]
        ]);

        echo template($this->type . '/single', [
            'object' => $object,
            'comments' => $comments['data'],
            'commentsPage' => $commentsPage,
            'commentsPages' => $comments['pages']
        ]);
    }
}
