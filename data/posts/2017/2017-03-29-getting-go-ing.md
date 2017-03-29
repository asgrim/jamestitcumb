---
title: Getting go-ing
tags: [golang]
---

I had a bit of a play around with [Go](https://golang.org/) today. Didn't get much further than a basic hello world but
using the `net/http` component to serve it in the browser. This post really serves as me reminding myself what I did to
set everything up and get going.

First up, installing `go` is easy because I'm on Ubuntu:

~~~ .bash
$ sudo apt-get install golang
~~~

Then, as I'm used to PhpStorm, I went ahead and installed JetBrains's EAP Go IDE,
[Gogland](https://www.jetbrains.com/go/) which was minimal fuss.

Following [the documentation](https://golang.org/doc/code.html) and
[a helpful screencast](https://www.youtube.com/watch?v=XCsL89YtqCs) I managed to figure out something that jarred me to
start with. I fired up Gogland, and it kept complaining about `GOPATH` being missing. It's not immediately clear what
this is, but it turns out that Go mandates a specific folder structure, for example if you chose your `GOPATH` to be in
`~/go`:

~~~
~/go
 - bin
   - project1
   - project2
 - pkg/linux_amd64/github.com/othervendor
   - libfoo.a
 - src/github.com
   - asgrim
     - project1 [...]
     - project2 [...]
   - othervendor
     - libfoo [...]
~~~

This was a bit frustrating at first, because I have have all other projects in `~/workspace/<project-name>`. So, after
throwing my toys out the pram and screaming at a wall, I got over it and understood the folder structure. A good thing
to do once you've also done the screaming thing is to set up paths, by adding this into `~/.profile`:

~~~bash
export GOPATH=$HOME/go
export PATH=$GOPATH/bin:$PATH
~~~

Once set up, I whizzed through the tutorial in the screencast above and got the "hello world" app running, along with
the "string" library to reverse the string. I then went a little further and used the `net/http` library to serve up
the string reversing tool as a web page, which was pretty easy to do.

Of course, not that it's much use to anyone, but the repo I set up is in
[https://github.com/asgrim/go-playground](https://github.com/asgrim/go-playground). Just a useful closer, it may help
to visualise that folder structure:

~~~
~/go
 - bin
   - hello
 - pkg/linux_amd64/github.com/asgrim/go-playground
   - string.a
 - src/github.com
   - asgrim
     - go-playground
       - hello [...]
       - string [...]
~~~

Another useful resource I found, though I haven't worked my way through it all is
[Evert Pot's](https://twitter.com/evertp) slides from his talk
[Go for PHP programmers](https://evertpot.com/talks/go-for-php-programmers).
