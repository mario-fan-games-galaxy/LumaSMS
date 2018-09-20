<?php
/**
 * Installer file for LumaSMS.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS;

require_once __DIR__ . DIRECTORY_SEPARATOR .
    'install' . DIRECTORY_SEPARATOR .
    'Autoloader.php';

use LumaSMS\install\Autoloader;
use LumaSMS\install\DatabaseManager;
use LumaSMS\install\EnvironmentManager;
use LumaSMS\install\FileManager;
use LumaSMS\install\SettingsManager;
use LumaSMS\install\ViewManager;
use \Exception;

$autoloader = new Autoloader();
$autoloader->register();

/*
 * Get the data managers
 */
$environmentManager = new EnvironmentManager();
$viewManager = new ViewManager();
$fileManager = new FileManager();
$settingsManager = null;
$databaseManager = null;

/*
 * Handle which step a user is on.
 */

$validSteps = [1,2,3,4];
if (isset($_GET['step'])) {
    $_GET['step'] = (int) $_GET['step'];
}
if (!isset($_GET['step']) or !$_GET['step']) {
    $_GET['step'] = 1;
}
$ignoreInstalled = false;
if ($_GET['step'] > 1 && !isset($_POST['compatible'])) {
    header('Location: ' . strtok($environmentManager->getUrl(), '?'));
}
if ($_GET['step'] > 2 && !isset($_POST['site_name'])) {
    header('Location: ' . strtok($environmentManager->getUrl(), '?'));
} elseif ($_GET['step'] > 2) {
    $ignoreInstalled = true;
}
if ($_GET['step'] > 3 && !isset($_POST['admin_username'])) {
    header('Location: ' . strtok($environmentManager->getUrl(), '?'));
}

/*
 * Take note of errors.
 */
$errors = [];

/*
 * Check if we can create settings file.
 */

$settingsFile = __DIR__ . DIRECTORY_SEPARATOR .
    'old' . DIRECTORY_SEPARATOR .
    'settings.php';
$installed = false;
if (!$fileManager->fileAccessible($settingsFile)
    && $fileManager->canBeCreated($settingsFile)
) {
    try {
        $fileManager->copyFile(
            __DIR__ . DIRECTORY_SEPARATOR .
            'install' . DIRECTORY_SEPARATOR .
            'settings' . DIRECTORY_SEPARATOR .
            'settings.default.php',
            $settingsFile
        );
    } catch (Exception $exception) {
        $errors[] = $exception->getMessage();
        $_GET['step'] = 128;
    }
}
try {
    $settingsManager = new SettingsManager($settingsFile);
} catch (Exception $exception) {
    $errors[] = $exception->getMessage();
    $_GET['step'] = 128;
}
if (!$settingsManager) {
    $errors[] = <<<EOT
Couldn't create settings file at <pre>${settingsFile}</pre> -
Please check that the software can write to its own directories.
EOT;
}
if ($settingsManager) {
    try {
        $databaseManager = new DatabaseManager(
            $settingsManager->getSetting('db_host'),
            $settingsManager->getSetting('db_name'),
            $settingsManager->getSetting('db_user'),
            $settingsManager->getSetting('db_pass'),
            $settingsManager->getSetting('db_prefix')
        );
        $installed = $databaseManager->isInstalled();
    } catch (Exception $exception) {
        if ($ignoreInstalled) {
            $errors[] = $exception->getMessage();
        }
    }
}
if (!$ignoreInstalled && $installed) {
    $errors[] = 'The application is already installed! Cannot continue.';
}

/*
 * Gather the page content.
 */
$mainData = [
    'css_url' => dirname($environmentManager->getUrl()) . '/install/css/css.css',
    'alerts' => '',
    'content' => 'No content loaded.',
];

/*
 * Do the work of each step.
 */
if ($_GET['step'] === 1) {
    $environment = $environmentManager->getEnvironment();
    $compatible = $environment['php']['compatible'] &&
        $environment['mysql']['compatible'] &&
        $environment['webserver']['compatible'];
    $environmentViewVariables = [
        'php_version' => $environment['php']['version'],
        'php_compatible' => $environment['php']['compatible'] ? 'Yes' : 'No',
        'mysql_version' => $environment['mysql']['version'],
        'mysql_compatible' => $environment['mysql']['compatible'] ? 'Yes' : 'No',
        'webserver_software' => $environment['webserver']['software'],
        'webserver_version' => $environment['webserver']['version'],
        'webserver_os' => $environment['webserver']['operating_system'],
        'webserver_compatible' => $environment['mysql']['compatible'] ? 'Yes' : 'No',
    ];
    $phpExtensionsHtml = '';
    foreach ($environment['php']['extensions'] as $extension) {
        $phpExtensionsHtml .= $viewManager->template('list-item', [
            'content' => $extension,
        ]) . PHP_EOL;
    }
    $environmentViewVariables['php_extensions'] = $phpExtensionsHtml;
    $mainData['content'] = $viewManager->template('environment', $environmentViewVariables);

    if ($compatible) {
        $mainData['content'] .= PHP_EOL . $viewManager->template('environment-next', [
            'action' => strtok($environmentManager->getUrl(), '?') . '?step=2',
            'compatible' => (int) $compatible,
        ]);
    } else {
        $mainData['content'] .= PHP_EOL . $viewManager->template('environment-bad');
    }
} elseif ($_GET['step'] === 2) {
    $mainData['content'] = $viewManager->template('settings', [
        'action' => strtok($environmentManager->getUrl(), '?') . '?step=3',
        'compatible' => $_POST['compatible'],
        'thumbnail_directory' => $settingsManager->getSetting('thumbnail_directory'),
        'file_directory' => $settingsManager->getSetting('file_directory'),
        'session_hotlink_protection' => $settingsManager->getSetting('session_hotlink_protection'),
        'db_host' => $settingsManager->getSetting('db_host'),
        'db_name' => $settingsManager->getSetting('db_name'),
        'db_user' => $settingsManager->getSetting('db_user'),
        'db_pass' => $settingsManager->getSetting('db_pass'),
        'db_prefix' => $settingsManager->getSetting('db_prefix'),
        'date_format' => $settingsManager->getSetting('date_format'),
        'date_setting' => $settingsManager->getSetting('date_setting'),
        'login_attempts_max' => $settingsManager->getSetting('login_attempts_max'),
        'login_attempts_wait' => $settingsManager->getSetting('login_attempts_wait'),
        'username_min_length' => $settingsManager->getSetting('username_min_length'),
        'username_max_length' => $settingsManager->getSetting('username_max_length'),
        'password_min_length' => $settingsManager->getSetting('password_min_length'),
        'password_max_length' => $settingsManager->getSetting('password_max_length'),
        'limit_per_page' => $settingsManager->getSetting('limit_per_page'),
        'site_name' => $settingsManager->getSetting('site_name'),
        'site_abbr' => $settingsManager->getSetting('site_abbr'),
    ]);
} elseif ($_GET['step'] === 3) {
    // Only update the editable-settings for now.
    if (!$databaseManager) {
        die('Database not loaded.');
    }
    $settingsManager->updateSetting('db_host', $_POST['db_host']);
    $settingsManager->updateSetting('db_name', $_POST['db_name']);
    $settingsManager->updateSetting('db_user', $_POST['db_user']);
    $settingsManager->updateSetting('db_pass', $_POST['db_pass']);
    $settingsManager->updateSetting('site_name', $_POST['site_name']);
    $settingsManager->updateSetting('site_abbr', $_POST['site_abbr']);
    // Install database.
    $databaseManager->installDatabase();
    $mainData['content'] = $viewManager->template('user-information', [
        'action' => strtok($environmentManager->getUrl(), '?') . '?step=4',
        'compatible' => $_POST['compatible'],
        'site_name' => $_POST['site_name'],
    ]);
} elseif ($_GET['step'] === 4) {
    $mainData['content'] = '';
    if (isset($_POST['clear_sample_data']) && $_POST['clear_sample_data']) {
        $databaseManager->emptyInstall();
    }
    try {
        $databaseManager->createAdminUser(
            $_POST['admin_username'],
            $_POST['admin_email'],
            $_POST['admin_password']
        );
    } catch (Exception $exception) {
        $errors[] = $exception->getMessage();
        $databaseManager->uninstallDatabase();
        $startUrl = strtok($environmentManager->getUrl(), '?');
        $errors[] = 'There was an issue creating the admin user. ' .
            'Make sure you use a valid email address and that the username ' .
            'is under 32 characters. Please start <a href="' . $startUrl .
            '">from the beginning.';
    }
    if (empty($errors)) {
        $mainData['content'] = $viewManager->template('success');
    }
} else {
    $startUrl = strtok($environmentManager->getUrl(), '?');
    $errors[] = 'An unknown operation has occurred. ' .
        'Please start <a href="' . $startUrl . '">from the beginning.';
}

/*
 * Handle errors
 */

foreach ($errors as $error) {
    $mainData['alerts'] .= $viewManager->template('error', [
        'content' => $error,
    ]) . PHP_EOL;
}

/*
 * Finally print out the content.
 */
echo $viewManager->template('install', $mainData);
