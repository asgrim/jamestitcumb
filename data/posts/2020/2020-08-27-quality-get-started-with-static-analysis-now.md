---
title: "Code Quality Series: Get Started with Static Analysis - NOW!"
tags: [php, quality, static analysis, psalm]
---

Static analysis is increasing in popularity in the world of PHP web applications. Rightly so; in my experience, running
static analysis in application build pipelines has uncovered previously unknown bugs. So how do we get started? As with
any new technique or tool, introducing it into an existing project will not be without issue. However, the main static
analysis tools in PHP have a way of creating a baseline; that is essentially saying:

 > All existing problems should be ignored, but any changes or additions should conform to the new rules.

Let's use the static analysis tool, Psalm, to fit this onto an existing project and create a baseline. First up, we can
require the tool with `composer`:

```bash
$ composer require --dev vimeo/psalm
```

Once installed, we can generate a default configuration very easily by running:

```bash
$ vendor/bin/psalm --init
```

Psalm tries to detect a reasonable "error level" (similar to how PHP Stan uses numbers for levels), however, because
we'd like to be strict, but with a known-issues baseline, we're going to tweak this a bit. Lets look at the existing
configuration that Psalm generated:

```xml
<?xml version="1.0"?>
<psalm
    errorLevel="3"
    resolveFromConfigFile="true"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns="https://getpsalm.org/schema/config"
    xsi:schemaLocation="https://getpsalm.org/schema/config vendor/vimeo/psalm/config.xsd"
>
    <projectFiles>
        <directory name="src" />
        <ignoreFiles>
            <directory name="vendor" />
        </ignoreFiles>
    </projectFiles>
</psalm>
```

Being an XML document, there is schema validation, so we can ignore `xmlns:xsi`, `xmlns` and `xsi:schemaLocation`. The
`resolveFromConfigFile` is just a setting to say "all paths are relative to the config file". The `projectFiles`
section should be checked to make sure everything you want to check has been included. I'd suggest adding your `tests`
path too here, if you have them.

The most important change I'd suggest removing `errorLevel="3"` and replacing it with `totallyTyped="true"`. The
default `errorLevel` is `1` (strictest) in Psalm, so we can omit the attribute, and enable `totallyTyped` mode, which
will complain about implicit type assumptions and so on. Note that in more recent versions of Psalm, if you're able to
use them, the `totallyTyped` attribute has been deprecated and `errorLevel="1"` should do the trick.

So your new configuration should look something like this:

```xml
<?xml version="1.0"?>
<psalm
    totallyTyped="true"
    resolveFromConfigFile="true"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns="https://getpsalm.org/schema/config"
    xsi:schemaLocation="https://getpsalm.org/schema/config vendor/vimeo/psalm/config.xsd"
>
    <projectFiles>
        <directory name="src" />
        <directory name="test" />
        <ignoreFiles>
            <directory name="vendor" />
        </ignoreFiles>
    </projectFiles>
</psalm>
```

Now you can run Psalm, like so:

```bash
$ vendor/bin/psalm
Scanning files...
Analyzing files...

E

<-- (LIST OF ERRORS REDACTED FOR BREVITY) -->


------------------------------
10 errors found
------------------------------

Checks took 0.35 seconds and used 51.655MB of memory
Psalm was able to infer types for 92.4051% of the codebase
```

In my example application, there are 10 errors that we need to now include into the new known-issues baseline we're
going to generate next:

```bash
$ vendor/bin/psalm --set-baseline=known-issues.xml
```

The output is mostly the same except you might notice two additional lines:

```
Writing error baseline to file...
Baseline saved to known-issues.xml.
```

If you have a look into `psalm.xml` you'll also see the `errorBaseline="known-issues.xml"` attribute has been added to
the root node. Now if you run `vendor/bin/psalm` again (with no parameters), you should see output like:

```
$ vendor/bin/psalm
Scanning files...
Analyzing files...

░

------------------------------
No errors found!
------------------------------
10 other issues found.
You can display them with --show-info=true
------------------------------

Checks took 0.17 seconds and used 64.879MB of memory
Psalm was able to infer types for 92.4051% of the codebase
```

Now, you can commit the `known-issues.xml`, your new `psalm.xml` and add the `vendor/bin/psalm` command into your CI
pipeline, for example if you're using GitHub Actions, this might work as-is depending on the platform you're developing
on and other necessary steps:

```yaml
name: Run static analysis on PRs

on:
  push:
    branches: [ master ]
  pull_request:
    branches: [ master ]

jobs:
  static-analysis:
    name: "Perform static analysis"
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: "Install PHP"
        uses: shivammathur/setup-php@v2
        with:
          coverage: "none"
          php-version: "7.4"
      - name: "Install dependencies"
        run: "composer install"
      - name: "Run Psalm"
        run: "vendor/bin/psalm"
```

It's worth mentioning that because static analysis does not run your code (hence the nomenclature "static analysis"),
that you won't need things like your databases, caches, and so on to be running, so in many cases, a step very similar
to above will work just fine.

From now on, any changes to existing code, or newly added code, where the errors have not already been included in the
`known-issues.xml` will cause your build to fail.

If you are able to fix some of these issues, you can also "reduce" the baseline. This will check for any known issues
that have been resolved, and remove them; doing this will not add any new issues to the baseline though:

```bash
vendor/bin/psalm --update-baseline
```

So there you have it; it's simple to get started with running static analysis in your PHP applications!

<!-- MARKETING -->
