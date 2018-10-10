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

You'll want to install PHP 5.6 instead of CentOS 7's default PHP 5.4;
you can do that by installing the [ius repo for CentOS 7](https://ius.io/)
and replacing all the install instructions to PHP installing with `php56u`
instead of merely `php` (for example, `sudo yum install php php-mysql`
should instead be (sudo `yum install php56u php56u-mysql`)

## Developer Tools

There are a handful of developer tools you'll want to make use of to get
the bext experience developing for LumaSMS. Most likely you can get these
developer tools working with your code editor tools- I recommend doing
that to avoid headaches in the future.

For each of these tools, their website is linked. Be sure to check their
website out for additional documentation if needed, and possibly how
to integrate the tool with your own personal IDE or text editor.

### EditorConfig

[EditorConfig](http://EditorConfig.org) is a tool to standardize simple
editor rules between developers. Install the appropriate plugin for your
editor and watch the magic happen as it reas the `.editorconfig` file from
our project whenever you edit the code.

### pnpm

[pnpm](https://github.com/pnpm/pnpm) is a JavaScript package manager, much like
`yarn` or `npm`. It relies on a `package.json` file for configuration and our
packages can be installed via:

```bash
pnpm install
```

Because `npm` and `yarn` are compatible with the same `package.json` format,
you may use either instead to get the development environment set up. However,
if you wish to add or remove packages, I recommend using `pnpm` directly.

Not only will this handle management of our front-end assets such as
Bootstrap, this is the central hub for development tools. It will also handle
installing `composer`, which handles our PHP dependencies and tools.

#### Prettier

[Prettier](https://prettier.io/) fixes code to confirm to its specific code
style. Keeping everyone's code style in sync makes working with others code
much easier.

Run prettier with this command:

```bash
pnpm run prettier
```

Prettier is ran with the `--single-quote` option, using single quotes over
double quotes where appropriate. Keep that in mind if you want to run it
on your own.

Prettier does not support configuration aside from a `.prettierignore` file,
which lists files and directories it should always ignore.

#### ESLint

[ESLint](https://eslint.org/) is a JavaScript linter. A linter looks out for
things to keep code styles in sync. ESLint can fix some problems automatically
as well.

Run this to fix errors that can be fixed automatically:

```bash
pnpm run eslint-fix
```

And run this to find errors that ESLint can't fix on its own:

```bash
pnpm run eslint
```

ESLint is configured via `.eslintrc.js`. We have it configured to conform to
[Airbnb's JavaScript Style Guide](https://github.com/airbnb/javascript) and
prettier's rules. Much like Prettier, there's also a `.eslintignore` file
for files and directorie to ignore.

#### Stylelint

[Stylelint](https://stylelint.io/) is another linter for styles such as CSS or
SCSS

It works pretty similar to ESLint, you even get the same kind of two commands:

```bash
pnpm run stylelint-fix
```

```bash
pnpm run stylelint
```

We use [styelint-config-standard](https://github.com/stylelint/stylelint-config-standard)
as a base. Stylelint is configured via `.stylelintrc.yaml`. It also has a
`.stylelintignore` file, much like Prettier and ESLint.

#### html-beautify

Prettier does not support HTML files. The
[js-beautify](https://github.com/beautify-web/js-beautify) includes a tool
to handle HTML files. We don't have any automation or alias to run html-beautify
as we're typically not dealing with HTML files directly, but in the case
you do want to format some HTML files, here's how to use it.

We're making use of linux's `find` command; this probably won't work
on Windows so you'll have to find your own solution there.

Run on all HTML files outside of excluded directories:

```bash
find . -name "*.html" -not -path */vendor/* -not -path */node_modules/* -exec pnpx html-beautify -r {} +
```

It works on XML files too.

```bash
find . -name "*.xml" -not -path */vendor/* -not -path */node_modules/* -exec pnpx html-beautify -r {} +
```

This is configured via the `.jsbeautifyrc` file, which is a `json` file.

#### Parcel

[Parcel](https://parceljs.org/) is a bundler for front-end resources. It
largely configures itself, figuring out what to run simply by reading our
`package.json` file and running packages compatible with it.

The basic concept is it takes in our JavaScript and CSS resources, bundles them
with the appropriate dependencies, transpiles code such as SCSS to CSS,
runs scripts such as `babel` or `post-css` to handle some browser
compatibility magic, and minfiies the scripts so the end-user is dealing with
the smallest possible filesize for our front-end assets.

There is no configuration file for parcel directly, but it does use
configuration for the tools it relies on.

Here's how to run it:

```
pnpm run build
```

Are you actively developing? Use this instead, it'll run parcel in the
background and re-compile the code whenever there are changes. It doesn't
minify the code either so you can more easily debug issues.

```
pnpm run watch
```

At the moment, the command is configured to run on the `assets/main.scss`
and the `assets/main.js` files, pulling in dependencies from whatever
those two call.

Anyway, let's get into some of the underlying technology we've configured
it to use:

##### Babel

[Babel](https://babeljs.io/) compiles modern JavaScript down to JavaScript that
older browsers can understand. This allows us to code with modern standards
without hving to worry too much about browser compatibility. We currently
have it set up to target browsers with greater than 0.25% usage and aren't
dead (unsupported by their developers), so we aren't supporting something
the developers don't support anymore, like Internet Explorer 6.

##### SCSS

[SASS](https://sass-lang.com/) is an extension to CSS that lets you do things
such as nested classes or variables. We're making use of the SCSS syntax,
which is closer to the original CSS syntax- in fact, valid CSS
works just fine in SCSS.

Parcel compiles this down to CSS for us.

Some configuration can be found in `.sassrc.js`- though right now we're only
using this to tell it where our `node_modules` folder is to find dependencies.

##### PostCSS

[PostCSS](https://postcss.org/) is a tool for running extra transformations on
CSS. After our SASS is compiled, this runs over it.

We're making use of [Autoprefixer](https://github.com/postcss/autoprefixer),
[CSS-MQPacker](https://github.com/hail2u/node-css-mqpacker),
[postcss-import](https://github.com/postcss/postcss-import),
[postcss-preset-env](https://github.com/csstools/postcss-preset-env),
and [postcss-syntax](https://www.npmjs.com/package/postcss-syntax).

##### Image optimization

We don't have image optimization set up just yet for parcel, but in the
future that might be something we add; with this parcel could optimize our
images on the fly for us so we don't need to do anything special to keep
image filesizes small.

### Composer

Composer is a package manager for PHP. Please read up on
[their documentation](https://getcomposer.org/) for advanced usage.

We use `composer-runner` in our `package.json` file, which installs composer
and we set up a post-install script, so when you run `pnpm install`, it'll
run the appropriate commands to install our composer dependencies as well.

However, you may want to use composer tools directly or install/remove
packages. For that you'll have to install composer on your machine manually-
see the website linked above for more information.

Our composer
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
pnpm run test
```

You can also install PHPUnit on your own; if you do so you should be able
to run the PHPUnit command directly in our directory to do the same
as the composer script above.

PHPUnit's configuration is handled by `phpunit.xml` in the root directory.

#### Lint

We have a composer script to help lint PHP code, much like what we have for
JavaScript and CSS. Run it with this:

```bash
pnpm run php-lint
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

You can run them directly with the following commands:

```bash
pnpm run phpcbf
```

```bash
pnpm run phpcs
```

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
pnpm run phpmd
```

Which will do the same thing as that big command above.

## Dependencies

Let's talk about the dependencies to get our code running on the user-side.
These are managed with `pnpm` and `composer`, but unlike the developer tools
these are required to get our project up and running. A public release will
include these dependencies with it, but for development you'll need `pnpm` to
install them with its install commands.

### jQuery

[jQuery](https://jquery.com/) is the JavaScript framework we're using.

### Bootstrap

[Bootstrap](https://getbootstrap.com/) is the UI framework we're using.

### Font Awesome

[Font Awesome](https://fontawesome.com/) is an icon library that gives us access
to some great icons to display on our front-end.

### highlight.js

[hightlight.js](https://highlightjs.org/) is being used to use syntax
highlighting for code blocks, which will come as MFGG is centered around
game development.

### Symfony YAML Component

The [Symfony YAML Component](https://symfony.com/doc/2.8/components/yaml.html)
lets our code parse YAML files. Currnetly this is only being used for the
configuration file, but it may be useful for other things in the future.

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
