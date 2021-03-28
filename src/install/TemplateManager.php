<?php

/**
 * Gather information about the environment.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\install;

use Exception;

/**
 * Manage templates.
 */
class TemplateManager
{

    /**
     * Parse a template file string to the absolute path to the template file.
     *
     * @param string $templateFile The path to the template file. Paths
     *                             that don't start with a '/' character
     *                             will start searching in the
     *                             `install/templates/` directory. Paths that don't
     *                             end in `.html` will have that added
     *                             automatically.
     *
     * @return string Returns the absolute path to the template file.
     */
    protected function parseTemplateFile($templateFile)
    {
        if (mb_substr($templateFile, 0, 1) !== DIRECTORY_SEPARATOR) {
            $templateFile = APP_TEMPLATES . DIRECTORY_SEPARATOR .
                'install' . DIRECTORY_SEPARATOR .
                $templateFile;
        }
        if (pathinfo($templateFile, PATHINFO_EXTENSION) !== 'html') {
            if (mb_substr($templateFile, -1) !== '.') {
                $templateFile .= '.';
            }
            $templateFile .= 'html';
        }

        return $templateFile;
    }

    /**
     * Parse a template file and replace the variables with the data.
     * Replaces {{ data }} with the value of $data['data'] in the $data array.
     * Removes {{ variables }} not found.
     *
     * @param string $templateFile The path to the template file. Paths
     *                             that don't start with a '/' character
     *                             will start searching in the
     *                             install/templates/
     *                             directory.
     * @param array  $data         A key => value array, where {{ key }}
     *                             is replaced by value.
     *
     * @throws Exception If $templateFile can not be opened.
     *
     * @return string Returns the template with the data replaced.
     */
    public function template($templateFile, array $data = null)
    {
        $templateFile = $this->parseTemplateFile($templateFile);

        $template = false;
        $fileError = false;

        if (!is_file($templateFile)) {
            $fileError = true;
        }
        try {
            $template = file_get_contents($templateFile);
        } catch (Exception $e) {
            $fileError = true;
        }
        if (false === $template) {
            $fileError = true;
        }
        if ($fileError) {
            throw new Exception('Could not open file: `' . $templateFile . '`');
            return '';
        }
        if (is_array($data)) {
            foreach ($data as $name => $content) {
                $template = str_replace(
                    '{{ ' . mb_strtolower($name) . ' }}',
                    $content,
                    $template
                );
            }
        }

        // Blank out other template variables
        $template = preg_replace('/{{\s+.+\s+}}/', '', $template);

        return $template;
    }
}
