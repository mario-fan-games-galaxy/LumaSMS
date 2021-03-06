<?php

/**
 * Comments model.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\models;

use LumaSMS\core\Model;

/**
 * Comments resource model.
 */
class CommentsModel extends Model
{
    /**
     * @var string The SQL table this is saved in.
     */
    public $table = 'comments';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = [
            'comments' => [
                [
                    'name' => 'cid',
                    'type' => 'uint'
                ],

                [
                    'name' => 'rid',
                    'type' => 'uint'
                ],

                [
                    'name' => 'uid',
                    'type' => 'uint'
                ],

                [
                    'name' => 'date',
                    'type' => 'uint'
                ],

                [
                    'name' => 'message',
                    'type' => 'text'
                ],

                [
                    'name' => 'type',
                    'type' => 'int'
                ],

                [
                    'name' => 'ip',
                    'type' => 'string'
                ],
            ]
        ];
    }
}
