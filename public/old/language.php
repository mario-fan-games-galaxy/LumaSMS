<?php

/**
 * Langage template
 * @package lumasms
 */

/**
 * Get a language string
 *
 * @param   string $key  The key to get the language statement for.
 * @param   string $lang The lagnuage to use, default is 'en'.
 *
 * @return  string  The language string
 */
function lang($key, $lang = 'en')
{
    global $language;

    if (empty($language)) {
        $language = [
            // == ENGLISH ==

            'en' => [
                // content.php

                'which-content' => 'Which content, though?',



                // login.php

                'already-logged-in' => 'You\'re already logged in as',
                'login-button' => 'Log In',
                'login-successful' => 'You\'ve been successfully logged in as',
                'login-title' => 'Log In',



                // logout.php

                'already-logged-out' => 'You\'re already logged out',
                'logged-out' => 'You\'ve successfully been logged out',



                // register.php

                'register-basic-info' => 'Basic Information',
                'register-button' => 'Register',
                'register-logged-in' => 'You can\'t register an account if you\'re already logged in',
                'register-success' => 'You\'ve successfully registered an account with the username',
                'register-title' => 'Register An Account',



                // sprites.php

                'sprites-empty' => 'There are no sprites to show',
                'sprites-title' => 'Sprites',



                // updates.php

                'updates-empty' => 'There are no updates to show',
                'updates-title' => 'Updates',



                // view.php

                'hotlinking-detected' => 'Hotlinking detected',
                'invalid-params' => 'Invalid Parameters',
                'invalid-resource' => 'Invalid resource selected',
                'resource-file-not-found' => 'File not found',
                'resource-no-thumb' => 'This resource type does not have thumbnails',
                'resource-not-found' => 'There is no such resource',



                // bbcode

                'spoiler-button' => 'Spoiler',



                // comments

                'comments-empty' => 'There are no comments to show',
                'comments-name' => 'Comments',
                'comments-title' => 'Comments',



                // content

                'content-download' => 'Download',
                'content-downloads' => 'Downloads',
                'content-views' => 'Views',



                // misc

                'misc-error' => 'Error',
                'misc-invalid-id' => 'Invalid ID',
                'misc-preview' => 'Preview',
                'misc-reset' => 'Reset',
                'misc-submit' => 'Submit',



                // redirect

                'redirect-after' => 'if you don\'t want to wait.',
                'redirect-before' => 'You\'re being redirected.',
                'redirect-link' => 'Click here',
            ]
        ];
    }

    $ret = $language;

    if (empty($ret[$lang])) {
        return false;
    }

    $ret = $ret[$lang];

    if (empty($ret[$key])) {
        return false;
    }

    $ret = $ret[$key];

    return $ret;
}
