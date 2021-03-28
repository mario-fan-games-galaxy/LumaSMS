<?php

/**
 * The user class
 * @package lumasms
 */

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace,PSR1.Methods.CamelCapsMethodName.NotCamelCaps
/**
 * The base user
 */
class User
{
    /**
     * @var boolean|self    Stored user
     */
    public static $user = false;

    /**
     * Get a new cookie string
     *
     * @return string The cookie string
     */
    public static function Cookie()
    {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    /**
     * Return a model object for the user you're currently logged in as
     * Alternatively, return false. Use `User::GetUser() === false` to see if it's empty
     *
     * @return object User model object
     */
    public static function GetUser()
    {
        if (self::$user) {
            return self::$user;
        }

        if (!isset($_SESSION['uid'])) {
            return false;
        }

        $user = Users::Read(['uid' => $_SESSION['uid']]);

        if (!$user) {
            return false;
        }

        self::$user = $user;

        self::UpdateLastActivity();

        return $user;
    }

    /**
     * Get the group the user is in
     * TODO: Extend this to allow other user IDs?
     *
     * @return integer Group ID, or 0
     */
    public static function GetUserGroup()
    {
        if (self::$user) {
            return self::$user->gid;
        }

        return 0;
    }

    /**
     * Log in with username and password
     *
     * @param string $username The username.
     * @param string $password The password.
     *
     * @return mixed    Login data
     */
    public static function Login($username, $password)
    {
        $ret = [
            'attempts' => false,
            'username' => false,
            'password' => false
        ];

        // Check the number of attempts first
        $attempts = DB()->prepare("
			SELECT COUNT(*) AS count FROM " . setting('db_prefix') . "login_attempts AS l
			WHERE
			date > ?
			AND
			user_agent = ?
			AND
			ip = ?
			AND
			success = 0
			;
		");

        $attempts->execute([
            time() - setting('login_attempts_wait'),
            $_SERVER['HTTP_USER_AGENT'],
            $_SERVER['REMOTE_ADDR']
        ]);

        $attempts = $attempts->fetch(PDO::FETCH_OBJ)->count;

        if ($attempts <= setting('login_attempts_max')) {
            $ret['attempts'] = true;

            $q = DB()->prepare("SELECT password,uid FROM " . setting('db_prefix') . "users WHERE username=? LIMIT 1;");
            $q->execute([$username]);
            $user = $q->fetch(PDO::FETCH_OBJ);
            $_password = $user->password;

            if (!empty($_password)) {
                $ret['username'] = true;

                $login = false;

                if (User::PasswordMatch($password, $_password)) {
                    $login = true;
                } elseif (hash('md5', $password) == $_password) {
                    // update from old, insecure hash
                    $login = true;

                    $q = DB()->prepare("
						UPDATE " . setting('db_prefix') . "users

						SET password = ?

						WHERE uid = ?

						LIMIT 1
						;
					");

                    $q->execute($data = [
                        User::Password($password),
                        $user->uid
                    ]);
                }

                if ($login) {
                    $ret['password'] = true;

                    session_destroy();
                    session_start();

                    $_SESSION['uid'] = $user->uid;

                    self::UpdateLastActivity();
                }
            }

            // Record the login attempt
            $a = DB()->prepare("
				INSERT INTO " . setting('db_prefix') . "login_attempts
				( uid,date,user_agent,ip,success )
				VALUES
				( ?, ?, ?, ?, ? )
				;
			");

            $a->execute([
                empty($user->uid) ? 0 : $user->uid,
                time(),
                $_SERVER['HTTP_USER_AGENT'],
                $_SERVER['REMOTE_ADDR'],
                $login ? true : false
            ]);
            // End record the login attempts
        }

        return $ret;
    }

    /**
     * Get a hash from the password
     *
     * @param string $password The password.
     *
     * @return string The hashed version of the password
     */
    public static function Password($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Find out if the hash came from the password
     * Use for login verification
     *
     * @param string $maybe The password.
     * @param string $real  The hash.
     *
     * @return boolean Whether or not the password is correct
     */
    public static function PasswordMatch($maybe, $real)
    {
        return password_verify($maybe, $real);
    }

    /**
     * Display the username's full HTML version
     * Should include coloring for group, link to profile, etc
     *
     * @param integer $user User ID.
     *
     * @return string HTML-formatted username
     */
    public static function ShowUsername($user = 0)
    {
        if ($user === 0) {
            $user = self::$user;
        }

        if (!$user) {
            return 'Guest';
        }

        $username = $user->username;

        $username = '<a href="'
            . url()
            . '/user/'
            . $user->uid
            . '-'
            . titleToSlug($username)
            . '">' . $username . '</a>';

        return $username;
    }

    /**
     * Update the current user's last activity
     * I haven't tested this in a while but it probably doesn't work lol
     * TODO: Extend this to include guests, more than it does now
     *
     * @return void
     */
    public static function UpdateLastActivity()
    {
        if (!self::$user) {
            return;
        }

        $q = DB()->prepare("
			UPDATE " . setting('db_prefix') . "users

			SET
			last_activity=?,
			last_ip=?

			WHERE
			uid=?
			;
		");

        $q->execute([
            time(),
            $_SERVER['REMOTE_ADDR'],
            self::$user->uid
        ]);
    }
}
