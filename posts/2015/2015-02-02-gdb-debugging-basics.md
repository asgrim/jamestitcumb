---
title: GDB Debugging Basics
---
The last time I did any C++ was back in the late 90's/early 00's, and Microsoft VisualC++ 6.0 was my tool of choice. Since then I have made the leap to Linux and I use this as my day-to-day OS. So, after a little discussion with Derick Rethans, I've found that I need to acquaint myself with the `gdb` tool.

Lets start by making a hello world program in `test.cpp`:

~~~ .cpp
#include <iostream>

int main()
{
  int i_retVal = 0;
  std::cout << "Hello world\n";
  return i_retVal;
}
~~~

We can then compile this (with the `-ggdb3` option, which produces debug information - or "symbols" - for gdb):

~~~ .bash
$ g++ -ggdb3 test.cpp -o test
~~~

We can run our hello world program now, and it works just like you'd expect:

~~~ .bash
$ ./test 
Hello world
~~~

Let's use the `gdb` tool to step debug through our program, line-by-line:

~~~ .gdb
$ gdb test
GNU gdb (Ubuntu 7.7.1-0ubuntu5~14.04.2) 7.7.1
Copyright (C) 2014 Free Software Foundation, Inc.
License GPLv3+: GNU GPL version 3 or later <http://gnu.org/licenses/gpl.html>
This is free software: you are free to change and redistribute it.
There is NO WARRANTY, to the extent permitted by law.  Type "show copying"
and "show warranty" for details.
This GDB was configured as "x86_64-linux-gnu".
Type "show configuration" for configuration details.
For bug reporting instructions, please see:
<http://www.gnu.org/software/gdb/bugs/>.
Find the GDB manual and other documentation resources online at:
<http://www.gnu.org/software/gdb/documentation/>.
For help, type "help".
Type "apropos word" to search for commands related to "word"...
Reading symbols from test...done.
(gdb) break 1
Breakpoint 1 at 0x400785: file test.cpp, line 1.
(gdb) run
Starting program: /home/james/workspace/cpptest/test 

Breakpoint 1, main () at test.cpp:5
5	  int i_retVal = 0;
(gdb) n
6	  std::cout << "Hello world\n";
(gdb) n
Hello world
7	  return i_retVal;
(gdb) n
8	}
(gdb) n
__libc_start_main (main=0x40077d <main()>, argc=1, argv=0x7fffffffde28, init=<optimised out>, fini=<optimised out>, 
    rtld_fini=<optimised out>, stack_end=0x7fffffffde18) at libc-start.c:321
321	libc-start.c: No such file or directory.
(gdb) n
[Inferior 1 (process 17788) exited normally]
(gdb) 
~~~

When we run `gdb test` note that the program does not actually get executed. You have full control of when execution starts, pauses and stops with `gdb`, so the assumption is that you have to explicitly run the program. Before we run though, the `break 1` command sets a breakpoint at line 1. So far I am not sure how to set breakpoints in different files, so that is a todo for me.

After we've set a breakpoint, we can use the `run` command which starts executing the program. The `n` (short for `next`) allows stepping down the function (also known as "Step Over"). If we use the `s` (short for `step`) command, then we will be doing a "Step Into" - we descend into each function call point. To "Step Out" you need to use `c` or `continue`.

You can also view the stack, modify variables and view variables whilst execution is paused:

~~~ .gdb
(gdb) run
Starting program: /home/james/workspace/cpptest/test 

Breakpoint 1, main () at test.cpp:5
5	  int i_retVal = 0;
(gdb) n
6	  std::cout << "Hello world\n";
(gdb) bt
#0  main () at test.cpp:6
(gdb) print i_retVal
$1 = 0
(gdb) set i_retVal = 5
(gdb) print i_retVal
$2 = 5
(gdb) n
Hello world
7	  return i_retVal;
(gdb) n
8	}
(gdb) n
__libc_start_main (main=0x40077d <main()>, argc=1, argv=0x7fffffffde28, init=<optimised out>, fini=<optimised out>, 
    rtld_fini=<optimised out>, stack_end=0x7fffffffde18) at libc-start.c:321
321	libc-start.c: No such file or directory.
(gdb) n
[Inferior 1 (process 17997) exited with code 05]
(gdb) 
~~~

Note that we modified the "return value" to be 5, so we saw `[Inferior 1 (process 17997) exited with code 05]` at the end instead of `exited normally` - we had full contorl over everything. Also note that we ran `bt` which shows the current stack trace. In our simple, there is only one function here so not very interesting for now.
