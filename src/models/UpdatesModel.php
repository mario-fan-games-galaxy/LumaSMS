<?php
/**
 * Updates model.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\models;

use LumaSMS\core\Model;

/**
 * Updates model.
 */
class UpdatesModel extends Model
{
    /**
     * @var string The SQL table this is saved in.
     */
    public $table = 'news';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = [
            'news' => [
                [
                    'name' => 'nid',
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
                    'name' => 'title',
                    'type' => 'string'
                ],

                [
                    'name' => 'message',
                    'type' => 'text'
                ],

                [
                    'name' => 'comments',
                    'type' => 'uint'
                ],

                [
                    'name' => 'update_tag',
                    'type' => 'int'
                ],
            ]
        ];
    }
}
