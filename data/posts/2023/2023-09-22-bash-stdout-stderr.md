---
title: "Labels for STDOUT and STDERR when developing Bash scripts"
tags: [bash, stdout, stderr, label, scripting, sed]
---

Time for my once-yearly blog post! This time, I'd like to post a tip when working on Bash scripts, and when you do,
caring about STDOUT and STDERR is important as a responsible programmer. Let's take an example script, such as:

```bash
#!/usr/bin/env bash

set -xeou pipefail

echo "this should be stdout"
echo "this shoudl be stderr" >&2
```

If you run this as is, you should see something like:

```
$ ./t.sh
+ echo 'this should be stdout'
this should be stdout
+ echo 'this shoudl be stderr'
this shoudl be stderr
```

There's no visual difference between the output when reading it as a human. Well, there is a way to improve this, to
help work on the script to ensure your stdout/stderr is being written appropriately. Simply append this little bit of
redirection + `sed` magic, ` 2> >(sed 's/^/e: /') > >(sed 's/^/o: /')`, to your command, such as:

```
$ ./t.sh 2> >(sed 's/^/e: /') > >(sed 's/^/o: /')
o: this should be stdout
e: + echo 'this should be stdout'
e: + echo 'this shoudl be stderr'
e: this shoudl be stderr
```

Notice how also, because I had `set -x`, the trace lines are also shown in the stderr stream. Naturally, this technique
will need `sed` installed. Enjoy!
