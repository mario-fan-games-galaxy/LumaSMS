<?php

/**
 * Template manager.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

/**
 * Returns the output of the template
 *
 * @param string $templateFile The path to the template inside of `templates/`.
 * @param array  $vars         An associative array of variables that you want
 *                             to be local to the template.
 * @return string The output of the template.
 */
function template($templateFile, array $vars = [])
{
    $templateFile = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .
        'templates' . DIRECTORY_SEPARATOR . $templateFile . '.php';

    if (!file_exists($templateFile)) {
        return false;
    }

    extract($vars);

    ob_start();

    include $templateFile;

    return ob_get_clean();
}
