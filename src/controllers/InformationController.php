<?php

/**
 * Information controller.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\controllers;

use LumaSMS\core\Controller;

/**
 * Information controller.
 */
class InformationController extends Controller
{
    /**
     * If you ever need to echo a string that says '404 error', here's the
     * place to go.
     *
     * @return void
     */
    public function error404()
    {
        echo '404 error';
    }
}
