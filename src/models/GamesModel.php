<?php
/**
 * Games resource model.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\models;

use LumaSMS\core\Model;

/**
 * Games resource model.
 */
class GamesModel extends Model
{
    /**
     * @var string The SQL table this resource is saved in.
     */
    public $table = 'resources';

    /**
     * Constructor
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function __construct()
    {
        $this->fields = [
            'resources' => [
                [
                    'name' => 'rid',
                    'type' => 'uint'
                ],

                [
                    'name' => 'type',
                    'type' => 'uint'
                ],

                [
                    'name' => 'eid',
                    'type' => 'uint'
                ],

                [
                    'name' => 'uid',
                    'type' => 'uint'
                ],

                [
                    'name' => 'title',
                    'type' => 'string'
                ],

                [
                    'name' => 'description',
                    'type' => 'text'
                ],

                [
                    'name' => 'author_override',
                    'type' => 'string'
                ],

                [
                    'name' => 'website_override',
                    'type' => 'string'
                ],

                [
                    'name' => 'weburl_override',
                    'type' => 'string'
                ],

                [
                    'name' => 'created',
                    'type' => 'uint'
                ],

                [
                    'name' => 'updated',
                    'type' => 'uint'
                ],

                [
                    'name' => 'queue_code',
                    'type' => 'int'
                ],

                [
                    'name' => 'ghost',
                    'type' => 'uint'
                ],

                [
                    'name' => 'update_reason',
                    'type' => 'string'
                ],

                [
                    'name' => 'accept_date',
                    'type' => 'uint'
                ],

                [
                    'name' => 'update_accept_date',
                    'type' => 'uint'
                ],

                [
                    'name' => 'decision',
                    'type' => 'string'
                ],

                [
                    'name' => 'catwords',
                    'type' => 'text'
                ],

                [
                    'name' => 'comments',
                    'type' => 'uint'
                ],

                [
                    'name' => 'comment_date',
                    'type' => 'uint'
                ],
            ]
        ];
    }
}
