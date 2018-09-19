<?php
/**
 * Handler of files for the installer.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\install;

use \Exception;

/**
 * This handles the file management functionality for the installer.
 */
class FileManager
{
    /**
     * Check if a file exists and is able to be read and written to.
     *
     * @param string $file The file to check.
     *
     * @return boolean `true` if file exists and is readable/writable,
     *                 `false` otherwise.
     */
    public function fileAccessible($file)
    {
        return file_exists($file)
            && is_readable($file)
            && is_writable($file);
    }

    /**
     * Check if it's possible to create a file.
     *
     * @param string $file The file to check.
     *
     * @return boolean `true` if file exists, `false` otherwise.
     */
    public function canBeCreated($file)
    {
        return is_readable(dirname($file))
            && is_writable(dirname($file));
    }

    /**
     * Copies a file from `$source` to `$destination`
     *
     * @param string $source      The source file to copy.
     * @param string $destination The destination file the source file will be
     *                            copied to.
     *
     * @throws Exception If `$source` is not a valid file.
     * @throws Exception If `$destination` is not a valid file.
     * @throws Exception If `$source` can not be accessed.
     * @throws Exception If `$destination` already exists.
     * @throws Exception If `$destination` can't be created.
     * @throws Exception If there was an issue copying `$source` to
     *                   `$destination`.
     *
     * @return boolean `true` If the file is successfully copied over, `false`
     *                        otherwise.
     */
    public function copyFile($source, $destination)
    {
        if (1 > mb_strlen($source)) {
            throw new Exception(
                '`' . $source . '` is not a valid file!'
            );
            return false;
        }

        if (1 > mb_strlen($destination)) {
            throw new Exception(
                '`' . $destination . '` is not a valid file!'
            );
            return false;
        }

        if (!file_exists($source) || !is_readable($source)) {
            throw new Exception(
                '`' . $source . '` can\'t be accessed!'
            );
            return false;
        }

        if (file_exists($destination)) {
            throw new Exception(
                '`' . $destination . '` already exists!'
            );
            return false;
        }

        if (!$this->canBeCreated($destination)) {
            throw new Exception(
                '`' . $destination . '` can\'t be created!'
            );
            return false;
        }

        // Copy file over.
        $result = copy($source, $destination);
        chmod($destination, 0664);
        if (!$result) {
            throw new Exception(
                'There was an issue copying the file over: `' .
                $source . '` to `' . $destination . '`'
            );
            return false;
        }
        // This should always return true at this point.
        return $this->fileAccessible($destination);
    }

    /**
     * Create configured directories if they don't exist, if they already do,
     * great! No need for any further action.
     *
     * @param string $directory The directory to create.
     *
     * @throws Exception If the directory can not be created.
     * @throws Exception If the directory was created but is inaccessible.
     *
     * @return boolean `true` If directory exists now and is accessible,
     *                        `false` otherwise.
     */
    public function createDirectory($directory)
    {
        if (!$this->canBeCreated($directory)) {
            throw new Exception('Could not create directory: ' . $directory);
            return false;
        }
        if (!file_exists($directory)) {
            mkdir($directory, 0775, true);
        }
        if (!$this->fileAccessible($directory)) {
            throw new Exception('Could not access directory: ' . $directory);
            return false;
        }

        return true;
    }
}
