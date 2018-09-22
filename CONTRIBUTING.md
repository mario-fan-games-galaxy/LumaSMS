# Contributing

When contributing to this repository, please first discuss the change you wish to make via issue,
email, or any other method with the owners of this repository before making a change.

One such place you may discuss this with us is our official Discord server,
which you can find [here](https://discord.gg/bNuR5j6).

Please note we have a code of conduct, please follow it in all your interactions with the project.

## Development Environment

The easiest way to get something that matches our development environment is
to use a CentOS 7 virtual machine. CentOS 7's default Apache, PHP, and MySQL
is pretty close to what the production environment will look like.
[Digital Ocean has a decent guide for getting CentOS 7 LAMP set up.](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-centos-7)

## Developer Tools

There are a handful of developer tools you'll want to make use of to get
the bext experience developing for LumaSMS. Most likely you can get these
developer tools working with your code editor tools- I recommend doing
that to avoid headaches in the future.

### Composer

Composer is a package manager for PHP. Please read up on
[their documentation](https://getcomposer.org/) for advanced usage, to hit
the ground running with our project, install composer and then run
the following command in our project root:

```bash
composer install
```

This'll install our of our project PHP dependencies and tools. Our composer
configuration is handled by `composer.json` in the root directory.

#### PHPUnit

PHPUnit is used for writing tests. We are currently using the unsupported
PHPUnit 4 due to using old PHP to develop this.
[Here's the documentation for that.](https://phpunit.de/manual/4.8/en/index.html)

We have a composer script setup to run PHPUnit; to run our tests use the
following command:

**WARNING**: Do not run these tests if you have any database data or settings
you want to keep! Tests can and possibly will override that data.

```bash
composer run-script tests
```

You can also install PHPUnit on your own; if you do so you should be able
to run the PHPUnit command directly in our directory to do the same
as the composer script above.

PHPUnit's configuration is handled by `phpunit.xml` in the root directory.

#### Code Cleaup

We have a composer script to help you keep your code clean. Run it with this:

```bash
composer run-script clean-code
```

This executes `phpcbf` which fixes code errors it can fix automatically,
`phpcs` which finds unfixable errors and tells you to fix them, and
`phpmd` which like `phpcs`, finds unfixable errors and tells you how to fix
them.

##### PHP Code Beautifier and Fixer & PHP CodeSniffer

Both the `phpcbf` and `phpcs` commands are part of the
[PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) project.
Much like PHPUnit, you may install these globally on your system and run them
in our root directory to get the same as running them via our clean-code
script. Configuration for these is handled by the `phpcs.xml` file in
the project root.

Although these tools can be used to handle code other than PHP, we only
use it for PHP at this time.

##### PHP Mess Detector

[PHP Mess Detector](https://phpmd.org/) looks for things that could cause
potential issues with code.

Much like the others, it has its own config file at `phpmd.xml`. However
unlike the others, it can be difficult to run on your own; for example, if you
install it globally on your system, in order to get the same tests as our
`clean-code` script, you'll have to run this in the root directory of the
project:

```bash
phpmd . text phpmd.xml --exclude */vendor/*,*/node_modules/*,*/public/old/*,*/.git/*,*/var/*,*/config/* --suffixes php
```

And if you're running it in a subdirectory you'll have to update `phpmd.xml`'s
path to point to our project root instead. Becasue this is a bit complicated
there's an extra composer script just to run phpmd if needed:

```bash
coomposer run-script phpmd
```

Which will do the same thing as that big command above.

### pnpm

[pnpm](https://github.com/pnpm/pnpm) is a JavaScript package manager, much like
`yarn` or `npm`. It relies on a `package.json` file for configuration and our
packages can be installed via:

```bash
pnpm install
```

We have a few developer tools with node as well for managing code outside
of the PHP world. They're not fully fleshed out yet but here's a brief overview:

#### prettier

Prettier fixes code to confirm to its specific code style. Keeping everyone's
code style in sync makes working with others code much easier.

Run prettier with this command:

```bash
pnpm run prettier
```

#### eslint

Eslint is a JavaScript linter. A linter works much like PHP's codesniffer
and looks out for things to keep code styles in sync. eslint can fix some
problems automatically as well.

Run this to fix errors that can be fixed automatically:

```bash
pnpm run eslint-fix
```

And run this to find errors that eslint can't fix on its own:

```bash
pnpm run eslint
```

#### Stylelint

Stylelint is another linter for styles such as css or scss.

It works pretty similar to eslint, you even get the same kind of two commands:

```bash
pnpm run stylelint-fix
```

```bash
pnpm run stylelint
```

## Pull Request Process

1. Ensure any install or build dependencies are removed before the end of the layer when doing a
   build.
2. Update the README.md with details of changes to the interface, this includes new environment
   variables, exposed ports, useful file locations and container parameters.
3. Increase the version numbers in any examples files and the README.md to the new version that this
   Pull Request would represent. The versioning scheme we use is [SemVer](http://semver.org/).
4. You may merge the Pull Request in once you have the sign-off of two other developers, or if you
   do not have permission to do that, you may request the second reviewer to merge it for you.

## Code of Conduct

### Our Pledge

In the interest of fostering an open and welcoming environment, we as
contributors and maintainers pledge to making participation in our project and
our community a harassment-free experience for everyone, regardless of age, body
size, disability, ethnicity, gender identity and expression, level of experience,
nationality, personal appearance, race, religion, or sexual identity and
orientation.

### Our Standards

Examples of behavior that contributes to creating a positive environment
include:

- Using welcoming and inclusive language
- Being respectful of differing viewpoints and experiences
- Gracefully accepting constructive criticism
- Focusing on what is best for the community
- Showing empathy towards other community members

Examples of unacceptable behavior by participants include:

- The use of sexualized language or imagery and unwelcome sexual attention or
  advances
- Trolling, insulting/derogatory comments, and personal or political attacks
- Public or private harassment
- Publishing others' private information, such as a physical or electronic
  address, without explicit permission
- Other conduct which could reasonably be considered inappropriate in a
  professional setting

### Our Responsibilities

Project maintainers are responsible for clarifying the standards of acceptable
behavior and are expected to take appropriate and fair corrective action in
response to any instances of unacceptable behavior.

Project maintainers have the right and responsibility to remove, edit, or
reject comments, commits, code, wiki edits, issues, and other contributions
that are not aligned to this Code of Conduct, or to ban temporarily or
permanently any contributor for other behaviors that they deem inappropriate,
threatening, offensive, or harmful.

### Scope

This Code of Conduct applies both within project spaces and in public spaces
when an individual is representing the project or its community. Examples of
representing a project or community include using an official project e-mail
address, posting via an official social media account, or acting as an appointed
representative at an online or offline event. Representation of a project may be
further defined and clarified by project maintainers.

### Enforcement

Instances of abusive, harassing, or otherwise unacceptable behavior may be
reported by contacting the project team on MFGG or our Discord server. All
complaints will be reviewed and investigated and will result in a response that
is deemed necessary and appropriate to the circumstances. The project team is
obligated to maintain confidentiality with regard to the reporter of an incident.
Further details of specific enforcement policies may be posted separately.

Project maintainers who do not follow or enforce the Code of Conduct in good
faith may face temporary or permanent repercussions as determined by other
members of the project's leadership.

### Attribution

This Code of Conduct is adapted from the [Contributor Covenant][homepage], version 1.4,
available at [http://contributor-covenant.org/version/1/4][version]

[homepage]: http://contributor-covenant.org
[version]: http://contributor-covenant.org/version/1/4/
