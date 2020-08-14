<?php
namespace LumaSMS;

// I'm not making an autoloader for one class
require_once __DIR__.'/Installer.php';

use LumaSMS\Installer;

if (!isset($_GET['step']) or !$_GET['step']) {
    $_GET['step'] = 1;
}

$ok_if_installed = false;

if ($_GET['step'] > 1 && !isset($_POST['compatible'])) {
    header('Location: '.strtok($_SERVER['REQUEST_URI'], '?'));
}
if ($_GET['step'] > 2 && !isset($_POST['site_name'])) {
    header('Location: '.strtok($_SERVER['REQUEST_URI'], '?'));
} elseif ($_GET['step'] > 2) {
    $ok_if_installed = true;
}
if ($_GET['step'] > 3 && !isset($_POST['admin_username'])) {
    header('Location: '.strtok($_SERVER['REQUEST_URI'], '?'));
}

// Start the HTML page
?><!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>LumaSMS Installer</title>

    <style type="text/css">
        HTML, BODY {
            font-size: 1em;
        }
        BODY {
            background-color: #fff;
            color: #000;
            font-family: serif;
            margin: 1em auto;
            max-width: 80ch;
        }
        H1, H2, H3, H4, H5, H6 {
            font-family: sans-serif;
        }
        .environment {
            border: 1px solid #000;
            border-collapse: collapse;
            margin: 0 auto 1em;
            width: 100%;
        }
        .environment TH,
        .environment TD {
            border: 1px solid #000;
            padding: 1em 1ch;
        }
        .form-item {
            margin: 1em auto;
        }
        .form-item LABEL {
            font-family: sans-serif;
            font-size: 1.25em;
            font-weight: bold;
        }
        .form-item INPUT {
            display: block;
            font-size: 1em;
            width: 100%;
            padding: 0.25em;
        }
        .continue-button {
            display: block;
            font-size: 1.5em;
            margin: 1em 0 0 auto;
        }
    </style>

</head>

<body>
    <h1>LumaSMS Installer</h1>
<?php
try {
    $settings_ok = Installer::create_settings_file();
} catch (Exception $e) {
    ?><h2>Error</h2>
<p><pre><?php echo $e; ?></pre></p>
<?php
    $_GET['step'] = 128;
}
try {
    $installed = Installer::is_installed();
} catch (Exception $e) {
    ?><h2>Error</h2>
    <p><pre><?php echo $e; ?></pre></p>
<?php
}
if (!$settings_ok): ?>
    <h2>Settings File</h2>
    <p>Couldn't create settings file at <pre><?php echo SETTINGS_FILE; ?></pre> - Please check that the software can write to its own directories.</p>
<?php elseif (!$ok_if_installed && $installed): ?>
    <h2>Application already installed</h2>
    <p>The application is already installed! Cannot continue.</p>
<?php else:
    switch ((int) $_GET['step']) {
        case 1:
            $info = Installer::get_environment();
            $compatible =
                $info['php']['compatible'] &&
                $info['mysql']['compatible'] &&
                $info['webserver']['compatible'];
            ?>
            <h2>Step #1 - Environment</h2>
            <table class="environment">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Recommended</th>
                        <th>Yours</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PHP Version</td>
                        <td>&gt;= 5.4.16</td>
                        <td><?php echo $info['php']['version']; ?></td>
                    </tr>
                    <tr>
                        <td>PHP Extensions</td>
                        <td><ul>
                            <li>Core</li>
                            <li>date</li>
                            <li>session</li>
                            <li>PDO</li>
                            <li>pdo_mysql</li>
                        </ul></td>
                        <td><ul><?php foreach ($info['php']['extensions'] as $extension) {
                echo '<li>'.$extension.'</li>'.PHP_EOL;
            } ?></ul></td>
                    </tr>
                    <tr>
                        <td>PHP Compatible</td>
                        <td>Yes</td>
                        <td><?php echo $info['php']['compatible']?'Yes':'No'; ?></td>
                    </tr>
                    <tr>
                        <td>MySQL Version</td>
                        <td>&gt;= 5.5</td>
                        <td><?php echo $info['mysql']['version']; ?></td>
                    </tr>
                    <tr>
                        <td>MySQL Compatible</td>
                        <td>Yes</td>
                        <td><?php echo $info['mysql']['compatible']?'Yes':'No'; ?></td>
                    </tr>
                    <tr>
                        <td>Webserver Software</td>
                        <td>Apache</td>
                        <td><?php echo $info['webserver']['software']; ?></td>
                    </tr>
                    <tr>
                        <td>Webserver Version</td>
                        <td>&gt;= 2.2</td>
                        <td><?php echo $info['webserver']['version']; ?></td>
                    </tr>
                    <tr>
                        <td>Webserver Operating System</td>
                        <td>&nbsp;</td>
                        <td><?php echo $info['webserver']['operating_system']; ?></td>
                    </tr>

                    <tr>
                        <td>Webserver Compatible</td>
                        <td>Yes</td>
                        <td><?php echo $info['webserver']['compatible']?'Yes':'No'; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php if ($compatible) {
                ?>
                <form action="<?php echo strtok($_SERVER['REQUEST_URI'], '?').'?step=2'; ?>" method="POST">
                    <input type="hidden" name="compatible" value="<?php echo $compatible; ?>"/>
                    <input type="Submit" name="submit" value="Continue &rarr;" class="continue-button"/>
                </form>
            <?php
            } else {
                ?>
                <p>Your environment is incompatible with this installer. You may attempt a manual install (see <pre>README.md</pre> file).</p>
            <?php
            }
            break;
        case 2:
            ?><h2>Settings</h2>
            <form action="<?php echo strtok($_SERVER['REQUEST_URI'], '?').'?step=3'; ?>" method="POST">
            <input type="hidden" name="compatible" value="<?php echo $_POST['compatible']; ?>"/>

            <div class="form-item"> 
                <label for="thumbnail_directory">Thumbnail Directory</label>
                <input type="text" id="thumbnail_directory" name="thumbnail_directory" disabled="disabled" value="<?php echo Installer::get_setting('thumbnail_directory'); ?>" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="file_directory">File Directory</label>
                <input type="text" id="file_directory" name="file_directory" disabled="disabled" value="<?php echo Installer::get_setting('file_directory'); ?>" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="session_hotlink_protection">Session Hotlink Protection</label>
                <input type="text" id="session_hotlink_protection" name="session_hotlink_protection" disabled="disabled" value="<?php echo Installer::get_setting('session_hotlink_protection')?'true':'false'; ?>" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="db_host">Database Host</label>
                <input type="text" id="db_host" name="db_host" value="<?php echo Installer::get_setting('db_host'); ?>" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="db_name">Database Name</label>
                <input type="text" id="db_name" name="db_name" value="<?php echo Installer::get_setting('db_name'); ?>" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="db_user">Database Username</label>
                <input type="text" id="db_user" name="db_user" value="<?php echo Installer::get_setting('db_user'); ?>" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="db_pass">Database Password</label>
                <input type="text" id="db_pass" name="db_pass" value="<?php echo Installer::get_setting('db_pass'); ?>" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="db_prefix">Database Prefix</label>
                <input type="text" id="db_prefix" name="db_prefix" value="<?php echo Installer::get_setting('db_prefix'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="date_format">Date Format</label>
                <input type="text" id="date_format" name="date_format" value="<?php echo Installer::get_setting('date_format'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="date_setting">Date Setting</label>
                <input type="text" id="date_setting" name="date_setting" value="<?php echo Installer::get_setting('date_setting'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="login_attempts_max">Maximum Login Attempts</label>
                <input type="text" id="login_attempts_max" name="login_attempts_max" value="<?php echo Installer::get_setting('login_attempts_max'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="login_attempts_wait">Maximum Login Attempts Period (in seconds)</label>
                <input type="text" id="login_attempts_wait" name="login_attempts_wait" value="<?php echo Installer::get_setting('login_attempts_wait'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="username_min_length">Minimum Username Length</label>
                <input type="text" id="username_min_length" name="username_min_length" value="<?php echo Installer::get_setting('username_min_length'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="username_max_length">Maximum Username Length</label>
                <input type="text" id="username_max_length" name="username_max_length" value="<?php echo Installer::get_setting('username_max_length'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="password_min_length">Minimum Password Length</label>
                <input type="text" id="password_min_length" name="password_min_length" value="<?php echo Installer::get_setting('password_min_length'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="password_max_length">Maximum Password Length</label>
                <input type="text" id="password_max_length" name="password_max_length" value="<?php echo Installer::get_setting('password_max_length'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="limit_per_page">Maximum Items Per Page</label>
                <input type="text" id="limit_per_page" name="limit_per_page" value="<?php echo Installer::get_setting('limit_per_page'); ?>" disabled="disabled" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="site_name">Site Name</label>
                <input type="text" id="site_name" name="site_name" value="<?php echo Installer::get_setting('site_name'); ?>"  required="required"/>
            </div>

            <div class="form-item"> 
                <label for="site_abbr">Site Abbreviation</label>
                <input type="text" id="site_abbr" name="site_abbr" value="<?php echo Installer::get_setting('site_abbr'); ?>" required="required"/>
            </div>

            <input type="Submit" name="submit" value="Continue &rarr;" class="continue-button"/>
            </form>
<?php
            break;
        case 3:
            // only update the editable-settings for now
            Installer::update_setting('db_host', $_POST['db_host']);
            Installer::update_setting('db_name', $_POST['db_name']);
            Installer::update_setting('db_user', $_POST['db_user']);
            Installer::update_setting('db_pass', $_POST['db_pass']);
            Installer::update_setting('site_name', $_POST['site_name']);
            Installer::update_setting('site_abbr', $_POST['site_abbr']);
            // Install database
            Installer::install_database();
            // Create directories
            Installer::create_directories();
            ?><h2>User Information</h2>
            <form action="<?php echo strtok($_SERVER['REQUEST_URI'], '?').'?step=4'; ?>" method="POST">
            <input type="hidden" name="compatible" value="<?php echo $_POST['compatible']; ?>"/>
            <input type="hidden" name="site_name" value="<?php echo $_POST['site_name']; ?>"/>

            <div class="form-item"> 
                <label for="clear_sample_data">Clear database of sample data?</label>
                <input type="checkbox" id="clear_sample_data" name="clear_sample_data" value="1"/>
            </div>

            <div class="form-item"> 
                <label for="admin_username">Administrator Username</label>
                <input type="text" id="admin_username" name="admin_username" value="" maxlength="32" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="admin_email">Administrator Email Address</label>
                <input type="email" id="admin_email" name="admin_email" value="" maxlength="128" required="required"/>
            </div>

            <div class="form-item"> 
                <label for="admin_pasword">Administrator Password</label>
                <input type="text" id="admin_password" name="admin_password" value="" maxlength="72" required="required"/>
            </div>

            <input type="Submit" name="submit" value="Continue &rarr;" class="continue-button"/>
            </form>
            <?php

            break;
        case 4:
            if (isset($_POST['clear_sample_data']) && $_POST['clear_sample_data']) {
                Installer::empty_install();
            }
            if (!Installer::create_admin_user($_POST['admin_username'], $_POST['admin_email'], $_POST['admin_password'])) {
                Installer::uninstall_database(); ?><h2>Error!</h2>
                <p>There was an issue creating the admin user. Make sure you use a valid email address and that the username is under 32 characters. Please start <a href="<?php echo strtok($_SERVER['REQUEST_URI'], '?'); ?>">from the beginning.</a>
                <?php
            }
            ?><h2>Success</h2>
            <p>LumaSMS is now installed.</a>
            <?php
            break;
        default:
            ?>
    <h2>Unknown Operation</h2>
    <p>An unknown operation has occurred. Please start <a href="<?php echo strtok($_SERVER['REQUEST_URI'], '?'); ?>">from the beginning.</a>
            <?php
            break;
    }

    endif;

?></body>
</html>
