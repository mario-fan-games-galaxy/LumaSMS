<?php
/**
 * Database class for handling installer database functions.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\install;

use \InvalidArgumentException;
use \Exception;

/**
 * This handles the settings file functionality for the installer.
 */
class SettingsManager
{
    /**
     * @var string The location of the settings file.
     */
    protected $settingsFile = '';

    /**
     * @var array An array of settings so we don't have to go back and retrieve
     *            them if they're called multiple times
     */
    protected $settings = [];

    /**
     * @var array An array of settings that only store a boolean value.
     */
    protected $booleanSettings = [];

    /**
     * Constructor for the SettingsManager.
     *
     * @param string $settingsFile A full path to a settings file.
     *
     * @throws InvalidArgumentException If a filepath is not passed.
     * @throws InvalidArgumentException If a PHP filepath is not passed.
     * @throws InvalidArgumentException If the directory the path is in is not
     *                                  writable.
     *
     */
    public function __construct($settingsFile)
    {
        if (!is_string($settingsFile) || mb_strlen($settingsFile) < 1) {
            throw new InvalidArgumentException(
                '`' . $settingsFile . '` is not a valid file!'
            );
            return;
        }
        if ('.php' !== mb_substr($settingsFile, -4)) {
            throw new InvalidArgumentException(
                '`' . $settingsFile . '` is not a PHP file!'
            );
            return;
        }

        $fileManager = new FileManager();

        if (!$fileManager->fileAccessible($settingsFile)
            && !$fileManager->canBeCreated($settingsFile)) {
            throw new InvalidArgumentException(
                '`' . $settingsFile . '` is is not accessible and can\'t be created!'
            );
            return;
        }

        $this->booleanSettings = [
            'session_hotlink_protection',
        ];


        $this->settingsFile = $settingsFile;
    }

    /**
     * Format a string value to a quoted string that can be written to a php
     * file.
     *
     * @param string $value The value you want to format.
     *
     * @return mixed The formatted value.
     */
    protected function formatStringValue($value)
    {
        return  '\'' . str_replace("'", "\'", $value) . '\'';
    }

    /**
     * Format a boolean value to a string.
     *
     * @param mixed $value The value you want to format.
     *
     * @return mixed The formatted value.
     */
    protected function formatBooleanValue($value)
    {
        if ((trim(mb_strtolower($value)) === 'true'
            || trim(mb_strtolower($value)) === 'false')
        ) {
            $value = trim(mb_strtolower($value)) === 'true';
        } else {
            $value = (bool) $value;
        }

        if ($value === true) {
            // `true` normally becomes `'1'` when converted to a string
            $value = 'true';
        } elseif ($value === false) {
            // `false` normall becomes `''` when converted to a string
            $value = 'false';
        }

        return $value;
    }

    /**
     * Format a numeric string to an int, float, or double.
     *
     * @param mixed $value The value you want to format.
     *
     * @return mixed The formatted value.
     */
    protected function formatNumericValue($value)
    {
        if ((string) (int) $value === $value) {
            $value = (int) $value;
        } elseif ((string) (float) $value === $value) {
            $value = (float) $value;
        } elseif ((string) (double) $value === $value) {
            $value = (double) $value;
        }

        return $value;
    }

    /**
     * Format a value string to something that can be written to a PHP file.
     *
     * @param mixed  $value   The value you want to format. Only accepts strings,
     *                        integers, floatign point numbers, and booleans.
     * @param string $setting The setting the value is for; this lets us decide
     *                        what type to use for the value. Can be left empty.
     *
     * @throws InvalidArgumentException If the value to set is invalid.
     *
     * @return string The formatted value.
     */
    protected function formatValue($value, $setting = false)
    {
        if (!is_string($value) && !is_numeric($value) && !is_bool($value)) {
            throw new InvalidArgumentException(
                'Invalid value for setting: `' . $value . '`'
            );
        }

        // Check if value shouldn't be a string and give it the correct type
        if (in_array($setting, $this->booleanSettings, true)) {
            $value = $this->formatBooleanValue($value);
        } elseif (is_numeric($value)) {
            $value = $this->formatNumericValue($value);
        } elseif (is_string($value)) {
            $value = $this->formatStringValue($value);
        }

        return $value;
    }

    /**
     * Read a setting by parsing the `SETTINGS_FILE` file- necessary for
     * loading a setting that has changed after the file has been included.
     *
     * @param string $setting The setting you want to read.
     *
     * @throws Exception If `SETTINGS_FILE` can not be read.
     *
     * @return mixed The value of the setting you've read.
     *
     */
    protected function readSetting($setting)
    {
        $fileManager = new FileManager();

        if (!$fileManager->fileAccessible($this->settingsFile)) {
            throw new Exception(
                'Could not read the following file: `' . $this->settingsFile . '`!'
            );
            return false;
        }

        include $this->settingsFile;

        if (isset($_SETTINGS)
            && is_array($_SETTINGS)
            && isset($_SETTINGS[$setting])
        ) {
            $this->settings[$setting] = $_SETTINGS[$setting];
            return $_SETTINGS[$setting];
        }

        throw new Exception('Could not read settings!');
        return null;
    }

    /**
     * Create settings file if it does not exist.
     *
     * @throws Exception If the default settings file is not a valid file.
     * @throws Exception If the new settings file is not a valid file.
     * @throws Exception If the default settings file can not be accessed.
     * @throws Exception If the new file can't be created.
     * @throws Exception If there was an issue copying the default settings file
     *                   to the new settings file location.

     * @return  boolean  `true` if file was copied over successfully.
     */
    public function createSettingsFile()
    {
        $fileManager = new FileManager();

        if ($fileManager->fileAccessible($this->settingsFile)) {
            return true;
        }

        $fileManager->copyFile(
            __DIR__ . DIRECTORY_SEPARATOR . 'settings' .
            DIRECTORY_SEPARATOR . 'settings.default.php',
            $this->settingsFile
        );

        return $fileManager->fileAccessible($this->settingsFile);
    }

    /**
     * Get a setting; will load from a cache in the setting if we have it
     * already, otherwise calls readSetting().
     *
     * @param string $setting The setting you want to read.
     *
     * @throws Exception If `SETTINGS_FILE` can not be read.
     *
     * @return mixed The value of the setting you've gotten.
     */
    public function getSetting($setting)
    {
        if (isset($this->settings[$setting])) {
            // we can ignore all this and use what's already there
            return $this->settings[$setting];
        }

        try {
            return $this->readSetting($setting);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Update a setting in the site's configuration file.
     * Note: This will NOT create new settings,
     * only update existing ones. If it can't find the setting, it shouldn't
     * do anything.
     *
     * Settings in the settings file _must_ be 1 per line, in the format:
     * `'setting_name' => value,`
     *
     * @param string $setting The setting you wish to update.
     * @param mixed  $value   The value of the setting you wish to update.
     *
     * @throws InvalidArgumentException If the value to set is invalid.
     * @throws InvalidArgumentException If the setting to be updated isn't found.
     * @throws Exception                If the `SETTINGS_FILE` cannot be read.
     * @throws Exception                If the `SETTINGS_FILE` cannot be written.
     *
     * @return boolean If the setting was updated successfully.
     */
    public function updateSetting($setting, $value)
    {
        try {
            $valueString = $this->formatValue($value, $setting);
        } catch (Exception $e) {
            throw $e;
            return false;
        }

        $fileManager = new FileManager();

        if (!$fileManager->fileAccessible($this->settingsFile)) {
            throw new Exception(
                '`' . $this->settingsFile . '` is not accessible!'
            );
            return false;
        }

        $settingsFile = preg_split('/\R/', file_get_contents($this->settingsFile));

        $regexSafeSetting = preg_quote($setting);

        $settingFound = false;
        foreach ($settingsFile as $lineNumber => $line) {
            $matches = array();
            $match = preg_match(
                '/^(?<startingSpace>\s*)[\'"]' . $regexSafeSetting .
                '[\'"]\s*=\s*>\s*.*,(?<endingSpace>\s*)(?:\n|$)/',
                $line,
                $matches
            );
            if ($match) {
                $settingsFile[$lineNumber] = $matches['startingSpace'] . '\'' .
                    $setting . '\' => ' . $valueString . ',' .
                    $matches['endingSpace'];
                $settingFound = true;
                break;
            }
        }

        if (!$settingFound) {
            throw new InvalidArgumentException('Setting not found.');
            return false;
        }

        file_put_contents($this->settingsFile, implode(PHP_EOL, $settingsFile));

        try {
            return $this->readSetting($setting) === $value;
        } catch (Exception $e) {
            throw $e;
            return false;
        }
    }
}
