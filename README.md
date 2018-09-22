# LumaSMS

LumaSMS is a new site management software being built for compatibility with
Taloncrossing Site Managament System. It's being built specifically for
[Mario Fan Games Galaxy](https://mfgg.net/), but may be useful for other sites
that store fanworks.

## Getting Started

These instructions will get you a copy of the project up and running on your
local machine for development and testing purposes. See deployment for notes
on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

- An Apache 2.2 or higher server
- PHP 5.4.16 or higher
  (TCSMS does not work with PHP7 but it will not be necessary later on)
- MySQL 5.5 or higher

You'll also want [Composer](https://getcomposer.org/) for PHP dependencies.
For public releases, we'll include the `vendor` directory for you so composer
won't be necessary; right now this repo is primarily aimed at developers.

To get going quick on Windows, just install XAMPP.

### Installing

Copy the files into your web directory. If you're using XAMPP, you can copy the
files into your `/../xampp/htdocs/` directory. At the moment you'll want to
configure your webserver to point to the `public` directory- NOT the root
of this project; we'll add an `.htaccess` to handle that in the near future.

After installing, make sure to run `composer install` to install all the
PHP dependencies.

#### Using the installer (Recommended)

Once the files are copied over head to `./install.php` in your web
browser. Follow the instructions and you should have a copy of LumaSMS up and
running in no time!

#### Manual Install

If the installer isn't working for you for whatever reason, follow these
instructions. (And please report an issue with the installer if there is one.)

Copy `./src/install/settings/config.default.yaml` to `./config/config.yaml`.

By default, the `config.yaml` file runs with a database named `mfgg` and
connects to a server on `localhost` with the username `root` and no password.
Copy this setup or modify the `database` settings in the `config.yaml` file.

Now, run all of the SQL files in `./src/install/sql/`, in this order:

- `00-mfgg.sql` (this one contains a basic TCSMS database structure)
- `01-mfgg-update.sql` (this one updates the TCSMS database tables with some necessary additions)
- Then everything else (these create tables that are unique to LumaSMS)

## Built With

- Raw PHP; no pre-existing framework
- [password_compat](https://github.com/ircmaxell/password_compat) - polyfill for PHP 5.5 password functions.
- [Symfony YAML Component](https://symfony.com/doc/2.8/components/yaml.html) - For managing our yaml config file.

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of
conduct, and the process for submitting pull requests to us.

## Authors

- [HylianDev](https://github.com/hyliandev) - Project lead
- [wtl420](https://github.com/wtl420)

See also the list of
[contributors](https://github.com/hyliandev/mfgg3/contributors) who participated
in this project.

## License

This project is licensed under the MIT License - see the
[LICENSE.md](LICENSE.md) file for details

## Acknowledgments

- Theme by [Kritter](https://forums.mfgg.net/member.php?action=profile&uid=8)
- Buttons by [Mors](https://forums.mfgg.net/member.php?action=profile&uid=24)
- "LumaSMS" name by [Yoshin](https://forums.mfgg.net/member.php?action=profile&uid=7)
