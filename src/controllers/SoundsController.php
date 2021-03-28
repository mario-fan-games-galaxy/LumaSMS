<?php

/**
 * Sounds controller.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\controllers;

use LumaSMS\core\CRUDController;

/**
 * Sounds controller.
 */
class SoundsController extends CRUDController
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commentsType = 1;

        $this->idField = 'rid';

        $this->type = 'Sounds';

        $this->join = [
            [
                'table' => 'res_sounds',
                'type' => 'LEFT',
                'pkMine' => 'eid',
                'pkTheirs' => 'eid',
            ]
        ];

        $this->where = [
            [
                'field' => 'type',
                'value' => 5
            ]
        ];
    }
}
