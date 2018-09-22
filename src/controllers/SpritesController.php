<?php
/**
 * Sprites controller.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\controllers;

use LumaSMS\core\CRUDController;

/**
 * Sprites controller.
 */
class SpritesController extends CRUDController
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commentsType = 1;

        $this->idField = 'rid';

        $this->type = 'Sprites';

        $this->join = [
            [
                'table' => 'res_gfx',
                'type' => 'LEFT',
                'pkMine' => 'eid',
                'pkTheirs' => 'eid',
            ]
        ];

        $this->where = [
            [
                'field' => 'type',
                'value' => 1
            ]
        ];
    }
}
