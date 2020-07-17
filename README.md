# MFGG powered by LumaSMS Extended

LumaSMS is a new software being built for compatibility with Taloncrossing Site Managament System. It's being built specifically for Mario Fan Games Galaxy (Also Metroid Fan Mission which is a defunct site).

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
An Apache 2.2 or higher server
PHP 5.4.16 or higher (TCSMS does not work with PHP7 but it will not be necessary later on)
MySQL 5.5 or higher
```

To get going quick on Windows, just install XAMPP.

### Installing

Copy the files into your web directory. If you're using XAMMP, you can copy the
files into your `/../xampp/htdocs/` directory.

#### Using the installer (Recommended)

Once the files are copied over head to `./hyliandev/install/` in your web
browser. Follow the instructions and you should have a copy of LumaSMS up and
running in no time!

#### Manual Install

If the installer isn't working for you for whatever reason, follow these
instructions.

Copy `./hyliandev/install/settings.default.php` to `./hyliandev/settings.php`.

By default, the `settings.php` file runs with a database named `mfgg` and
connects to a server on `localhost` with the username `root` and no password.
Copy this setup or modify the settings starting with `db_` in the
`settings.php` file.

Now, run all of the SQL files in `./hyliandev/install/`, in this order:
* `mfgg.sql` (this one contains a basic TCSMS database structure)
* `mfgg_update.sql` (this one updates the TCSMS database tables with some necessary additions)
* Then everything in the `./hyliandev/install/sql/` directory (these create tables that are unique to LumaSMS)

Lastly, create a directory named `tcsms` in your parent directory. Inside that, create two directories: `file` and `thumbnail`. Finally, put numbered folders `1` through `6` in each. This folder is where content is being stored, as of right now. This will change.

TCSMS source code isn't available here because it isn't open-source.

## How does it work?

### Template

`template.php` contains everything before and after the page content

### Pages

Files under `./hyliandev/pages/` can be loaded by adding their path to your URL.

For example: to load `./hyliandev/pages/test.php`, you would add `/test` to your URL.

### Models

`model.php` contains a class called `Model`. It contains methods for creating, reading, updating, and deleting different database items. You should extend the `Model` class if you want to access a new database item.

There isn't a great deal of abstraction in the `Model` classes yet. Maybe this should be fixed.

### Themes

Themes aren't a thing yet. All theme elements are currently in `./hyliandev/theme/base/`.

### Views

A "view" is a template file you can include anywhere in the page. They can be included using the `view($file,$vars)` function.

The `$file` parameter is the path to the view you're trying to include from `./hyliandev/views/`, without the `.php` extension.

The `$vars` parameter is an associative array of variables you want to be local in scope to the view file.

### User

The `user.php` file contains a static class called `User`. You can get the currently logged in user as an object by calling `User::GetCurrentUser()`.

## Built With

* Raw PHP; no pre-existing framework
* `password.php` is a library I'm using for proper password hashing before PHP 5.5

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Authors

* **HylianDev** - *Project leader/Original author*
* **Mors** - *Programmer*
* **Hypernova** - *Programmer*

See also the list of [contributors](https://github.com/MorsGames/mfgg3/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Theme by Kritter
* Buttons by Mors
* Name by Yoshin
* Github made better by wtl's advice
